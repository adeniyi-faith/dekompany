<?php
/**
 * De Kompany Admin API
 * /admin/api.php — handles all XHR/fetch calls from the dashboard
 *
 * AUTH MODEL:
 *  - PUBLIC actions (log_message, capture_lead, check_takeover): allowed from any visitor.
 *  - ADMIN actions (everything else): require logged-in WP admin via auth.php.
 *
 * NEW in this version:
 *  - log_message triggers instant email notification to all WP admins on first user message
 *  - send_takeover_message: admin injects a human message into the live chat
 *  - check_takeover: frontend polls this to receive admin messages
 *  - get_takeover_status: dashboard checks if a session is in takeover mode
 *  - end_takeover: admin releases the session back to AI
 */

// ── Load WordPress (without the admin-only gate) ──────────────────────────────
$wp_load_candidates = [
    dirname(dirname(__DIR__)) . '/wp-load.php',
    dirname(__DIR__) . '/wp-load.php',
    $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php',
];
$_wp_loaded = false;
foreach ($wp_load_candidates as $_p) {
    if (file_exists($_p)) { require_once $_p; $_wp_loaded = true; break; }
}
if (!$_wp_loaded) { http_response_code(500); echo json_encode(['ok'=>false,'msg'=>'WP not found']); exit; }

global $wpdb;

// ── CORS: allow same-origin fetch from the site's own domain ─────────────────
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// ── Public actions — NO login required ────────────────────────────────────────
$action = sanitize_text_field($_REQUEST['action'] ?? '');

$public_actions = ['log_message', 'capture_lead', 'check_takeover'];

if (!in_array($action, $public_actions)) {
    if (!is_user_logged_in() || !current_user_can('manage_options')) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
        exit;
    }
}

if (!function_exists('dkhq_json')) {
    function dkhq_json($data, $code = 200) {
        http_response_code($code);
        echo json_encode($data);
        exit;
    }
}

// ── PROMPTS ──────────────────────────────────────────────
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

if ($action === 'get_prompts') {
    $rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dkhq_prompts ORDER BY sector, id");
    dkhq_json($rows);
}

if ($action === 'delete_prompt') {
    $id = intval($_POST['id']);
    $wpdb->delete("{$wpdb->prefix}dkhq_prompts", ['id' => $id]);
    dkhq_json(['ok' => true]);
}

// ── CHAT LOGS ────────────────────────────────────────────
if ($action === 'log_message') {
    $session_id = sanitize_text_field($_POST['session_id'] ?? wp_generate_uuid4());
    $sector     = sanitize_text_field($_POST['sector'] ?? 'unknown');
    $sender     = in_array($_POST['sender'], ['user', 'bot', 'admin']) ? $_POST['sender'] : 'user';
    $message    = sanitize_textarea_field($_POST['message'] ?? '');

    $data = [
        'session_id' => $session_id,
        'sector'     => $sector,
        'sender'     => $sender,
        'message'    => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
    ];
    $wpdb->insert("{$wpdb->prefix}dkhq_chat_logs", $data);
    $log_id = $wpdb->insert_id;

    // ── INSTANT NOTIFICATION: fire on the FIRST user message of a session ──
    if ($sender === 'user') {
        $already_notified = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs
             WHERE session_id = %s AND sender = 'user' AND id != %d",
            $session_id, $log_id
        ));

        if (!$already_notified) {
            // This is the very first user message — send email to all admins
            dkhq_notify_admins($session_id, $sector, $message);
        }
    }

    dkhq_json(['ok' => true, 'log_id' => $log_id]);
}

/**
 * Sends an instant email notification to every WP user with manage_options.
 */
function dkhq_notify_admins($session_id, $sector, $first_message) {
    // Get all admin users
    $admin_users = get_users(['role__in' => ['administrator'], 'fields' => ['user_email', 'display_name']]);
    if (empty($admin_users)) return;

    $sector_label = ucfirst($sector);
    $admin_url    = home_url('/wp/admin/admin.php');
    $short_msg    = mb_substr($first_message, 0, 200);
    $time         = current_time('D, d M Y \a\t H:i');

    $subject = "🔔 New {$sector_label} Chat Started — De Kompany";

    $body = "
<html><body style='font-family:Inter,Arial,sans-serif;background:#f8f9fb;padding:24px;'>
<div style='max-width:520px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;border:1px solid #e5e9f0;'>
    <div style='background:#111827;padding:20px 24px;'>
        <p style='color:#e8b84b;font-weight:700;font-size:15px;margin:0;'>⚡ De Kompany Admin</p>
    </div>
    <div style='padding:24px;'>
        <h2 style='color:#111827;font-size:18px;margin:0 0 8px;'>New Conversation Started</h2>
        <p style='color:#6b7280;font-size:13px;margin:0 0 20px;'>{$time}</p>

        <table style='width:100%;font-size:13px;border-collapse:collapse;margin-bottom:20px;'>
            <tr>
                <td style='padding:10px 14px;background:#f1f4f9;border:1px solid #e5e9f0;font-weight:600;color:#374151;width:120px;'>Department</td>
                <td style='padding:10px 14px;border:1px solid #e5e9f0;color:#111827;'>{$sector_label}</td>
            </tr>
            <tr>
                <td style='padding:10px 14px;background:#f1f4f9;border:1px solid #e5e9f0;font-weight:600;color:#374151;'>Session ID</td>
                <td style='padding:10px 14px;border:1px solid #e5e9f0;font-family:monospace;font-size:11px;color:#6b7280;'>{$session_id}</td>
            </tr>
            <tr>
                <td style='padding:10px 14px;background:#f1f4f9;border:1px solid #e5e9f0;font-weight:600;color:#374151;'>First Message</td>
                <td style='padding:10px 14px;border:1px solid #e5e9f0;color:#111827;font-style:italic;'>" . esc_html($short_msg) . "</td>
            </tr>
        </table>

        <a href='{$admin_url}' style='display:inline-block;background:#1a56db;color:#fff;text-decoration:none;padding:12px 22px;border-radius:8px;font-weight:700;font-size:13px;margin-bottom:8px;'>
            View in Dashboard →
        </a>
        <p style='color:#9ca3af;font-size:11px;margin:12px 0 0;'>You are receiving this because you are a De Kompany administrator. To take over the conversation manually, open the Conversations page in your admin dashboard.</p>
    </div>
</div>
</body></html>
";

    $headers = ['Content-Type: text/html; charset=UTF-8', 'From: De Kompany Admin <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>'];

    foreach ($admin_users as $admin) {
        wp_mail($admin->user_email, $subject, $body, $headers);
    }
}

if ($action === 'get_chat_logs') {
    $sector = sanitize_text_field($_GET['sector'] ?? '');
    $limit  = intval($_GET['limit'] ?? 50);
    $offset = intval($_GET['offset'] ?? 0);
    $search = sanitize_text_field($_GET['search'] ?? '');

    $where = '1=1';
    $args  = [];
    if ($sector) { $where .= ' AND sector = %s'; $args[] = $sector; }
    if ($search) { $where .= ' AND message LIKE %s'; $args[] = '%' . $wpdb->esc_like($search) . '%'; }

    $query  = "SELECT * FROM {$wpdb->prefix}dkhq_chat_logs WHERE $where ORDER BY created_at DESC LIMIT %d OFFSET %d";
    $args[] = $limit;
    $args[] = $offset;

    $rows  = $args ? $wpdb->get_results($wpdb->prepare($query, $args)) : $wpdb->get_results($query);

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
                WHERE cl2.session_id = cl.session_id AND cl2.sender='user'
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
    $sid  = sanitize_text_field($_GET['session_id']);
    $rows = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_chat_logs WHERE session_id = %s ORDER BY id ASC",
        $sid
    ));
    dkhq_json($rows);
}

// ── ADMIN TAKEOVER ────────────────────────────────────────
// Admin sends a message into the live chat
if ($action === 'send_takeover_message') {
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');
    $message    = sanitize_textarea_field($_POST['message'] ?? '');
    $admin_name = sanitize_text_field($_POST['admin_name'] ?? 'Admin');

    if (!$session_id || !$message) dkhq_json(['ok' => false, 'msg' => 'Missing data'], 400);

    // Ensure takeover row exists and is active
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s",
        $session_id
    ));
    if ($existing) {
        $wpdb->update("{$wpdb->prefix}dkhq_takeovers", ['is_active' => 1, 'admin_name' => $admin_name], ['session_id' => $session_id]);
    } else {
        $wpdb->insert("{$wpdb->prefix}dkhq_takeovers", [
            'session_id' => $session_id,
            'admin_name' => $admin_name,
            'is_active'  => 1,
        ]);
    }

    // Log the admin message in chat_logs so transcript stays complete
    $wpdb->insert("{$wpdb->prefix}dkhq_chat_logs", [
        'session_id' => $session_id,
        'sector'     => $wpdb->get_var($wpdb->prepare(
            "SELECT sector FROM {$wpdb->prefix}dkhq_chat_logs WHERE session_id = %s LIMIT 1",
            $session_id
        )),
        'sender'     => 'admin',
        'message'    => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => '',
    ]);

    dkhq_json(['ok' => true, 'msg' => 'Message sent to visitor.']);
}

// Admin ends takeover — hands back to AI
if ($action === 'end_takeover') {
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');
    $wpdb->update("{$wpdb->prefix}dkhq_takeovers", ['is_active' => 0], ['session_id' => $session_id]);
    dkhq_json(['ok' => true]);
}

// Dashboard: get takeover status for a session
if ($action === 'get_takeover_status') {
    $session_id = sanitize_text_field($_GET['session_id'] ?? '');
    $row = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s",
        $session_id
    ));
    dkhq_json([
        'is_active'  => $row ? (bool)$row->is_active : false,
        'admin_name' => $row ? $row->admin_name : '',
    ]);
}

// PUBLIC: Frontend polls this to receive admin messages
// Returns only messages the frontend hasn't seen yet (based on last known log id)
if ($action === 'check_takeover') {
    $session_id  = sanitize_text_field($_GET['session_id'] ?? '');
    $last_log_id = intval($_GET['last_log_id'] ?? 0);

    if (!$session_id) dkhq_json(['takeover' => false, 'messages' => []]);

    // Is admin in control of this session?
    $takeover = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s AND is_active = 1",
        $session_id
    ));

    // Any new admin messages since last poll?
    $new_msgs = $wpdb->get_results($wpdb->prepare(
        "SELECT id, message, sender FROM {$wpdb->prefix}dkhq_chat_logs
         WHERE session_id = %s AND id > %d AND sender IN ('admin')
         ORDER BY id ASC",
        $session_id, $last_log_id
    ));

    dkhq_json([
        'takeover'   => !empty($takeover),
        'admin_name' => $takeover ? $takeover->admin_name : '',
        'messages'   => $new_msgs,
    ]);
}

// ── LEADS ────────────────────────────────────────────────
if ($action === 'capture_lead') {
    $data = [
        'session_id'  => sanitize_text_field($_POST['session_id'] ?? ''),
        'sector'      => sanitize_text_field($_POST['sector'] ?? ''),
        'name'        => sanitize_text_field($_POST['name'] ?? ''),
        'email'       => sanitize_email($_POST['email'] ?? ''),
        'phone'       => sanitize_text_field($_POST['phone'] ?? ''),
        'first_query' => sanitize_textarea_field($_POST['first_query'] ?? ''),
        'status'      => 'new',
    ];
    if ($data['email']) {
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}dkhq_leads WHERE email = %s AND sector = %s",
            $data['email'], $data['sector']
        ));
        if ($exists) {
            dkhq_json(['ok' => true, 'msg' => 'Lead already exists.', 'id' => $exists]);
        }
    }
    $wpdb->insert("{$wpdb->prefix}dkhq_leads", $data);
    dkhq_json(['ok' => true, 'id' => $wpdb->insert_id]);
}

if ($action === 'get_leads') {
    $sector = sanitize_text_field($_GET['sector'] ?? '');
    $status = sanitize_text_field($_GET['status'] ?? '');
    $where  = '1=1';
    $args   = [];
    if ($sector) { $where .= ' AND sector = %s'; $args[] = $sector; }
    if ($status) { $where .= ' AND status = %s'; $args[] = $status; }
    $query = "SELECT * FROM {$wpdb->prefix}dkhq_leads WHERE $where ORDER BY created_at DESC";
    $rows  = $args ? $wpdb->get_results($wpdb->prepare($query, $args)) : $wpdb->get_results($query);
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

// ── SECTION TOGGLES ──────────────────────────────────────
if ($action === 'get_toggles') {
    $rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dkhq_section_toggles ORDER BY sector, id");
    dkhq_json($rows);
}

if ($action === 'toggle_section') {
    $sector = sanitize_text_field($_POST['sector']);
    $key    = sanitize_text_field($_POST['section_key']);
    $vis    = intval($_POST['is_visible']);
    $wpdb->update("{$wpdb->prefix}dkhq_section_toggles", ['is_visible' => $vis], ['sector' => $sector, 'section_key' => $key]);
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

// ── MEDIA LIBRARY ────────────────────────────────────────
if ($action === 'upload_media') {
    if (empty($_FILES['file'])) dkhq_json(['ok' => false, 'msg' => 'No file'], 400);

    $upload_dir = wp_upload_dir();
    $dkhq_dir   = $upload_dir['basedir'] . '/dkhq-media/';
    $dkhq_url   = $upload_dir['baseurl'] . '/dkhq-media/';

    if (!file_exists($dkhq_dir)) wp_mkdir_p($dkhq_dir);

    $file    = $_FILES['file'];
    $allowed = ['image/jpeg','image/png','image/webp','image/svg+xml','application/pdf'];
    if (!in_array($file['type'], $allowed)) dkhq_json(['ok' => false, 'msg' => 'File type not allowed'], 400);
    if ($file['size'] > 5 * 1024 * 1024) dkhq_json(['ok' => false, 'msg' => 'Max 5MB'], 400);

    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'pdf'];
    if (!in_array($ext, $allowed_exts)) dkhq_json(['ok' => false, 'msg' => 'File extension not allowed'], 400);

    $safe     = sanitize_file_name(pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = $safe . '_' . time() . '.' . $ext;
    $dest     = $dkhq_dir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) dkhq_json(['ok' => false, 'msg' => 'Upload failed'], 500);

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
    $rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dkhq_media ORDER BY created_at DESC LIMIT 200");
    dkhq_json($rows);
}

if ($action === 'delete_media') {
    $id  = intval($_POST['id']);
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}dkhq_media WHERE id = %d", $id));
    if ($row) {
        $upload_dir = wp_upload_dir();
        @unlink($upload_dir['basedir'] . '/dkhq-media/' . $row->filename);
        $wpdb->delete("{$wpdb->prefix}dkhq_media", ['id' => $id]);
    }
    dkhq_json(['ok' => true]);
}

// ── PRESENTATIONS ────────────────────────────────────────
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

if ($action === 'get_presentations') {
    $rows = $wpdb->get_results("SELECT id, slug, title, client_name, sector, is_published, view_count, created_at FROM {$wpdb->prefix}dkhq_presentations ORDER BY created_at DESC");
    dkhq_json($rows);
}

if ($action === 'get_presentation') {
    $id  = intval($_GET['id']);
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}dkhq_presentations WHERE id = %d", $id));
    dkhq_json($row);
}

if ($action === 'delete_presentation') {
    $wpdb->delete("{$wpdb->prefix}dkhq_presentations", ['id' => intval($_POST['id'])]);
    dkhq_json(['ok' => true]);
}

// ── DASHBOARD STATS ──────────────────────────────────────
if ($action === 'get_stats') {
    $stats = [
        'total_leads'     => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_leads")),
        'new_leads'       => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_leads WHERE status='new'")),
        'total_sessions'  => intval($wpdb->get_var("SELECT COUNT(DISTINCT session_id) FROM {$wpdb->prefix}dkhq_chat_logs")),
        'total_messages'  => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs")),
        'academic_msgs'   => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs WHERE sector='academic'")),
        'business_msgs'   => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_chat_logs WHERE sector='business'")),
        'presentations'   => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_presentations")),
        'media_count'     => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_media")),
        'live_takeovers'  => intval($wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_takeovers WHERE is_active=1")),
        'recent_leads'    => $wpdb->get_results("SELECT name, email, sector, status, created_at FROM {$wpdb->prefix}dkhq_leads ORDER BY created_at DESC LIMIT 5"),
        'recent_sessions' => $wpdb->get_results("SELECT session_id, sector, COUNT(*) as msgs, MIN(created_at) as started FROM {$wpdb->prefix}dkhq_chat_logs GROUP BY session_id, sector ORDER BY started DESC LIMIT 5"),
    ];
    dkhq_json($stats);
}

// Default fallback
dkhq_json(['ok' => false, 'msg' => 'Unknown action: ' . $action], 400);