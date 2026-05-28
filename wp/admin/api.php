<?php
/**
 * De Kompany Admin API
 * ─────────────────────────────────────────────────────────────────────────────
 * Location : /wp/admin/api.php
 * Purpose  : Handles every XHR / fetch() call made by the JavaScript engine in
 *            footer.php. All endpoints are strict-admin-only (gated by auth.php).
 *
 * Auth model:
 *   - ADMIN ONLY. This file is fully gated for logged-in WordPress administrators.
 *   - Public frontend chat requests go exclusively through dkhq-chat-ajax.php.
 *
 * Load order:
 *   1. Define DKHQ_API_REQUEST so auth.php returns JSON 403 instead of redirect.
 *   2. require_once auth.php  — boots WP, checks login, defines helpers.
 *   3. Route $action to the matching endpoint block.
 * ─────────────────────────────────────────────────────────────────────────────
 */

// Tell auth.php to respond with JSON on auth failure (not a login redirect)
define('DKHQ_API_REQUEST', true);

require_once __DIR__ . '/auth.php';

// $wpdb and dkhq_json() are both available after auth.php loads.
global $wpdb;

$action = sanitize_text_field($_REQUEST['action'] ?? '');

// ── PROMPTS ──────────────────────────────────────────────────────────────────

if ($action === 'get_prompts') {
    $rows = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}dkhq_prompts ORDER BY sector, id"
    );
    dkhq_json($rows);
}

if ($action === 'save_prompt') {
    $id   = intval($_POST['id'] ?? 0);
    $data = [
        'sector'        => sanitize_text_field($_POST['sector']),
        'prompt_label'  => sanitize_text_field($_POST['prompt_label']),
        'system_prompt' => wp_kses_post($_POST['system_prompt']),
        'ai_model'      => sanitize_text_field($_POST['ai_model']),
        'temperature'   => floatval($_POST['temperature'] ?? 0.7),
        'max_tokens'    => intval($_POST['max_tokens'] ?? 300),
        'is_active'     => intval($_POST['is_active'] ?? 1),
    ];
    if ($id) {
        $wpdb->update("{$wpdb->prefix}dkhq_prompts", $data, ['id' => $id]);
        dkhq_json(['ok' => true, 'msg' => 'Prompt updated.']);
    } else {
        $wpdb->insert("{$wpdb->prefix}dkhq_prompts", $data);
        dkhq_json(['ok' => true, 'msg' => 'Prompt created.', 'id' => $wpdb->insert_id]);
    }
}

if ($action === 'delete_prompt') {
    $id = intval($_POST['id']);
    $wpdb->delete("{$wpdb->prefix}dkhq_prompts", ['id' => $id]);
    dkhq_json(['ok' => true]);
}

// ── CHAT LOGS & SESSIONS ─────────────────────────────────────────────────────

if ($action === 'get_chat_logs') {
    $sector = sanitize_text_field($_GET['sector'] ?? '');
    $limit  = intval($_GET['limit']  ?? 50);
    $offset = intval($_GET['offset'] ?? 0);
    $search = sanitize_text_field($_GET['search'] ?? '');

    $where = '1=1';
    $args  = [];
    if ($sector) { $where .= ' AND sector = %s'; $args[] = $sector; }
    if ($search) { $where .= ' AND message LIKE %s'; $args[] = '%' . $wpdb->esc_like($search) . '%'; }

    $query  = "SELECT * FROM {$wpdb->prefix}dkhq_chat_logs WHERE $where ORDER BY created_at DESC LIMIT %d OFFSET %d";
    $args[] = $limit;
    $args[] = $offset;

    $rows = $args
        ? $wpdb->get_results($wpdb->prepare($query, $args))
        : $wpdb->get_results($query);

    // Group by session_id for legacy callers
    $sessions = [];
    foreach ($rows as $row) {
        $sessions[$row->session_id][] = $row;
    }
    dkhq_json(['sessions' => $sessions]);
}

if ($action === 'get_sessions') {
    $sector = sanitize_text_field($_GET['sector'] ?? '');
    $where  = $sector ? $wpdb->prepare('WHERE sector = %s', $sector) : '';
    $rows   = $wpdb->get_results("
        SELECT cl.session_id, cl.sector,
               MIN(cl.created_at) as started,
               MAX(cl.created_at) as last_msg,
               COUNT(*) as msg_count,
               (SELECT message FROM {$wpdb->prefix}dkhq_chat_logs cl2
                WHERE cl2.session_id = cl.session_id AND cl2.sender = 'user'
                ORDER BY cl2.id LIMIT 1) as first_msg,
               COALESCE(
                   (SELECT 1 FROM {$wpdb->prefix}dkhq_takeovers tk
                    WHERE tk.session_id = cl.session_id AND tk.is_active = 1 LIMIT 1),
                   0
               ) as is_takeover
        FROM {$wpdb->prefix}dkhq_chat_logs cl
        $where
        GROUP BY cl.session_id, cl.sector
        ORDER BY last_msg DESC
        LIMIT 100
    ");
    dkhq_json($rows);
}

if ($action === 'get_session_detail') {
    $sid  = sanitize_text_field($_GET['session_id'] ?? '');
    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_chat_logs WHERE session_id = %s ORDER BY id ASC",
        $sid
    ));
    dkhq_json($rows);
}

// ── ADMIN TAKEOVER ────────────────────────────────────────────────────────────

if ($action === 'start_takeover') {
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');

    // Upsert: update existing row or insert fresh one
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s",
        $session_id
    ));

    if ($exists) {
        $wpdb->update(
            "{$wpdb->prefix}dkhq_takeovers",
            ['admin_id' => get_current_user_id(), 'is_active' => 1],
            ['session_id' => $session_id]
        );
    } else {
        $wpdb->insert("{$wpdb->prefix}dkhq_takeovers", [
            'session_id' => $session_id,
            'admin_id'   => get_current_user_id(),
            'is_active'  => 1,
        ]);
    }
    dkhq_json(['ok' => true]);
}

if ($action === 'send_takeover_message') {
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');
    $message    = sanitize_textarea_field($_POST['message'] ?? '');

    if (!$session_id || !$message) {
        dkhq_json(['ok' => false, 'msg' => 'Missing session_id or message'], 400);
    }

    // Keep the takeover row marked active
    $wpdb->update(
        "{$wpdb->prefix}dkhq_takeovers",
        ['is_active' => 1, 'admin_id' => get_current_user_id()],
        ['session_id' => $session_id]
    );

    // Log admin message into the chat transcript so the visitor sees it
    $wpdb->insert("{$wpdb->prefix}dkhq_chat_logs", [
        'session_id' => $session_id,
        'sector'     => $wpdb->get_var($wpdb->prepare(
            "SELECT sector FROM {$wpdb->prefix}dkhq_chat_logs WHERE session_id = %s LIMIT 1",
            $session_id
        )) ?: 'business',
        'sender'     => 'admin',
        'message'    => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => '',
    ]);

    dkhq_json(['ok' => true, 'msg' => 'Message sent to visitor.']);
}

if ($action === 'end_takeover') {
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');
    $wpdb->update(
        "{$wpdb->prefix}dkhq_takeovers",
        ['is_active' => 0],
        ['session_id' => $session_id]
    );
    dkhq_json(['ok' => true]);
}

if ($action === 'get_takeover_status') {
    $session_id = sanitize_text_field($_GET['session_id'] ?? '');
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s",
        $session_id
    ));

    // Resolve the admin's first name dynamically (never stored in plain text)
    $admin_name = '';
    if ($row && $row->is_active) {
        $admin = get_userdata($row->admin_id);
        if ($admin) $admin_name = explode(' ', $admin->display_name)[0];
    }

    dkhq_json([
        'is_active'  => $row ? (bool) $row->is_active : false,
        'admin_name' => $admin_name,
    ]);
}

// ── LEADS ─────────────────────────────────────────────────────────────────────

if ($action === 'get_leads') {
    $sector = sanitize_text_field($_GET['sector'] ?? '');
    $status = sanitize_text_field($_GET['status'] ?? '');
    $where  = '1=1';
    $args   = [];
    if ($sector) { $where .= ' AND sector = %s'; $args[] = $sector; }
    if ($status) { $where .= ' AND status = %s'; $args[] = $status; }
    $query = "SELECT * FROM {$wpdb->prefix}dkhq_leads WHERE $where ORDER BY created_at DESC";
    $rows  = $args
        ? $wpdb->get_results($wpdb->prepare($query, $args))
        : $wpdb->get_results($query);
    dkhq_json($rows);
}

if ($action === 'update_lead') {
    $id = intval($_POST['id']);
    $wpdb->update("{$wpdb->prefix}dkhq_leads", [
        'status' => sanitize_text_field($_POST['status'] ?? 'new'),
        'notes'  => sanitize_textarea_field($_POST['notes'] ?? ''),
        'phone'  => sanitize_text_field($_POST['phone'] ?? ''),
    ], ['id' => $id]);
    dkhq_json(['ok' => true]);
}

if ($action === 'delete_lead') {
    $wpdb->delete("{$wpdb->prefix}dkhq_leads", ['id' => intval($_POST['id'])]);
    dkhq_json(['ok' => true]);
}

// ── SECTION TOGGLES ───────────────────────────────────────────────────────────

if ($action === 'get_toggles') {
    $rows = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}dkhq_section_toggles ORDER BY sector, id"
    );
    dkhq_json($rows);
}

if ($action === 'toggle_section') {
    $sector = sanitize_text_field($_POST['sector']);
    $key    = sanitize_text_field($_POST['section_key']);
    $vis    = intval($_POST['is_visible']);
    $wpdb->update(
        "{$wpdb->prefix}dkhq_section_toggles",
        ['is_visible' => $vis],
        ['sector' => $sector, 'section_key' => $key]
    );
    dkhq_json(['ok' => true]);
}

if ($action === 'add_toggle') {
    $wpdb->insert("{$wpdb->prefix}dkhq_section_toggles", [
        'sector'        => sanitize_text_field($_POST['sector']),
        'section_key'   => sanitize_text_field($_POST['section_key']),
        'section_label' => sanitize_text_field($_POST['section_label']),
        'is_visible'    => 1,
    ]);
    dkhq_json(['ok' => true, 'id' => $wpdb->insert_id]);
}

// ── MEDIA LIBRARY ─────────────────────────────────────────────────────────────

if ($action === 'upload_media') {
    if (empty($_FILES['file'])) {
        dkhq_json(['ok' => false, 'msg' => 'No file received'], 400);
    }

    $upload_dir = wp_upload_dir();
    $dkhq_dir   = $upload_dir['basedir'] . '/dkhq-media/';
    $dkhq_url   = $upload_dir['baseurl'] . '/dkhq-media/';

    if (!file_exists($dkhq_dir)) wp_mkdir_p($dkhq_dir);

    $file    = $_FILES['file'];
    $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'application/pdf'];

    if (!in_array($file['type'], $allowed)) {
        dkhq_json(['ok' => false, 'msg' => 'File type not allowed. Accepted: JPEG, PNG, WebP, SVG, PDF.'], 400);
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        dkhq_json(['ok' => false, 'msg' => 'File exceeds the 5 MB limit.'], 400);
    }

    $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safe     = sanitize_file_name(pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = $safe . '_' . time() . '.' . $ext;
    $dest     = $dkhq_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        dkhq_json(['ok' => false, 'msg' => 'Upload failed — check server write permissions.'], 500);
    }

    $wpdb->insert("{$wpdb->prefix}dkhq_media", [
        'filename'      => $filename,
        'original_name' => sanitize_file_name($file['name']),
        'file_url'      => $dkhq_url . $filename,
        'file_type'     => $file['type'],
        'file_size'     => $file['size'],
        'alt_text'      => sanitize_text_field($_POST['alt_text'] ?? ''),
        'tags'          => sanitize_text_field($_POST['tags'] ?? ''),
        'uploaded_by'   => get_current_user_id(),
    ]);
    dkhq_json(['ok' => true, 'url' => $dkhq_url . $filename, 'id' => $wpdb->insert_id]);
}

if ($action === 'get_media') {
    $rows = $wpdb->get_results(
        "SELECT * FROM {$wpdb->prefix}dkhq_media ORDER BY created_at DESC LIMIT 200"
    );
    dkhq_json($rows);
}

if ($action === 'delete_media') {
    $id  = intval($_POST['id']);
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_media WHERE id = %d", $id
    ));
    if ($row) {
        $upload_dir = wp_upload_dir();
        @unlink($upload_dir['basedir'] . '/dkhq-media/' . $row->filename);
        $wpdb->delete("{$wpdb->prefix}dkhq_media", ['id' => $id]);
    }
    dkhq_json(['ok' => true]);
}

// ── PRESENTATIONS ─────────────────────────────────────────────────────────────

if ($action === 'get_presentations') {
    $rows = $wpdb->get_results(
        "SELECT id, slug, title, client_name, sector, is_published, view_count, created_at
         FROM {$wpdb->prefix}dkhq_presentations
         ORDER BY created_at DESC"
    );
    dkhq_json($rows);
}

if ($action === 'get_presentation') {
    $id  = intval($_GET['id']);
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_presentations WHERE id = %d", $id
    ));
    dkhq_json($row);
}

if ($action === 'save_presentation') {
    $id   = intval($_POST['id'] ?? 0);
    $data = [
        'slug'               => sanitize_title($_POST['slug'] ?? ''),
        'title'              => sanitize_text_field($_POST['title'] ?? ''),
        'client_name'        => sanitize_text_field($_POST['client_name'] ?? ''),
        'sector'             => sanitize_text_field($_POST['sector'] ?? 'business'),
        'hero_headline'      => sanitize_text_field($_POST['hero_headline'] ?? ''),
        'hero_subheadline'   => sanitize_textarea_field($_POST['hero_subheadline'] ?? ''),
        'sections'           => wp_kses_post($_POST['sections'] ?? '[]'),
        'theme'              => sanitize_text_field($_POST['theme'] ?? 'business'),
        'is_published'       => intval($_POST['is_published'] ?? 0),
        'password_protected' => sanitize_text_field($_POST['password_protected'] ?? ''),
        'created_by'         => get_current_user_id(),
    ];
    if ($id) {
        $wpdb->update("{$wpdb->prefix}dkhq_presentations", $data, ['id' => $id]);
        dkhq_json(['ok' => true, 'msg' => 'Presentation updated.']);
    } else {
        $wpdb->insert("{$wpdb->prefix}dkhq_presentations", $data);
        dkhq_json(['ok' => true, 'id' => $wpdb->insert_id, 'slug' => $data['slug']]);
    }
}

if ($action === 'delete_presentation') {
    $wpdb->delete("{$wpdb->prefix}dkhq_presentations", ['id' => intval($_POST['id'])]);
    dkhq_json(['ok' => true]);
}

// ── DASHBOARD STATS ───────────────────────────────────────────────────────────

if ($action === 'get_stats') {
    // Graceful check — prevents crash on a fresh install before the table exists
    $takeover_exists = $wpdb->get_var(
        "SHOW TABLES LIKE '{$wpdb->prefix}dkhq_takeovers'"
    ) === "{$wpdb->prefix}dkhq_takeovers";

    $stats = [
        'total_leads'     => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_leads")),
        'new_leads'       => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_leads WHERE status='new'")),
        'total_sessions'  => intval($wpdb->get_var("SELECT COUNT(DISTINCT session_id) FROM {$wpdb->prefix}dkhq_chat_logs")),
        'total_messages'  => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs")),
        'academic_msgs'   => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs WHERE sector='academic'")),
        'business_msgs'   => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs WHERE sector='business'")),
        'presentations'   => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_presentations")),
        'media_count'     => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_media")),
        'live_takeovers'  => $takeover_exists
            ? intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_takeovers WHERE is_active=1"))
            : 0,
        'recent_leads'    => $wpdb->get_results(
            "SELECT name, email, sector, status, created_at FROM {$wpdb->prefix}dkhq_leads ORDER BY created_at DESC LIMIT 5"
        ),
        'recent_sessions' => $wpdb->get_results(
            "SELECT session_id, sector, COUNT(*) as msgs, MIN(created_at) as started
             FROM {$wpdb->prefix}dkhq_chat_logs
             GROUP BY session_id, sector
             ORDER BY started DESC
             LIMIT 5"
        ),
    ];
    dkhq_json($stats);
}

// ── FALLBACK ──────────────────────────────────────────────────────────────────
dkhq_json(['ok' => false, 'msg' => 'Unknown action: ' . esc_html($action)], 400);
