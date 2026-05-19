<?php
/**
 * Plugin Name: De Kompany Chat AJAX
 * Description: Registers public AJAX endpoints for the academic/business chat widgets.
 * Version: 1.2 (Includes Full History Retrieval & Reactive Polling Endpoints)
 * Author: De Kompany / GetOnline Studio
 *
 * Location: /wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php
 *
 * HOW IT WORKS:
 * WordPress has a built-in AJAX handler at /wp/wp-admin/admin-ajax.php
 * It accepts POST requests and routes them by 'action' parameter.
 * wp_ajax_nopriv_{action} = runs for logged-out visitors (what we need).
 * wp_ajax_{action}        = runs for logged-in users too.
 * This completely bypasses .htaccess permalink conflicts.
 */

if (!defined('ABSPATH')) exit;

// ── log_message ───────────────────────────────────────────────────────────────
function dkhq_ajax_log_message() {
    global $wpdb;

    $session_id = sanitize_text_field($_POST['session_id'] ?? '');
    $sector     = sanitize_text_field($_POST['sector']     ?? 'academic');
    $sender     = in_array($_POST['sender'] ?? '', ['user','bot', 'admin']) ? $_POST['sender'] : 'user';
    $message    = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($session_id) || empty($message)) {
        wp_send_json(['ok' => false, 'msg' => 'Missing fields']);
    }

    $inserted = $wpdb->insert(
        $wpdb->prefix . 'dkhq_chat_logs',
        [
            'session_id' => $session_id,
            'sector'     => $sector,
            'sender'     => $sender,
            'message'    => $message,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
        ]
    );

    if ($inserted === false) {
        wp_send_json(['ok' => false, 'msg' => 'DB error: ' . $wpdb->last_error]);
    }

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

    wp_send_json(['ok' => true, 'log_id' => $log_id]);
}
add_action('wp_ajax_nopriv_dkhq_log_message', 'dkhq_ajax_log_message');
add_action('wp_ajax_dkhq_log_message',        'dkhq_ajax_log_message');

/**
 * Sends an instant email notification to every WP user with manage_options.
 */
function dkhq_notify_admins($session_id, $sector, $first_message) {
    $admin_users = get_users(['role__in' => ['administrator'], 'fields' => ['user_email']]);
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

// ── capture_lead ──────────────────────────────────────────────────────────────
function dkhq_ajax_capture_lead() {
    global $wpdb;

    $session_id  = sanitize_text_field($_POST['session_id']      ?? '');
    $sector      = sanitize_text_field($_POST['sector']          ?? 'academic');
    $name        = sanitize_text_field($_POST['name']            ?? '');
    $email       = sanitize_email($_POST['email']                ?? '');
    $phone       = sanitize_text_field($_POST['phone']           ?? '');
    $first_query = sanitize_textarea_field($_POST['first_query']  ?? '');

    // Deduplicate by email + sector
    if ($email) {
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}dkhq_leads WHERE email = %s AND sector = %s",
            $email, $sector
        ));
        if ($exists) {
            wp_send_json(['ok' => true, 'msg' => 'Lead already exists', 'id' => $exists]);
        }
    }

    $inserted = $wpdb->insert(
        $wpdb->prefix . 'dkhq_leads',
        [
            'session_id'  => $session_id,
            'sector'      => $sector,
            'name'        => $name,
            'email'       => $email,
            'phone'       => $phone,
            'first_query' => $first_query,
            'status'      => 'new',
        ]
    );

    if ($inserted === false) {
        wp_send_json(['ok' => false, 'msg' => 'DB error: ' . $wpdb->last_error]);
    }

    wp_send_json(['ok' => true, 'id' => $wpdb->insert_id]);
}
add_action('wp_ajax_nopriv_dkhq_capture_lead', 'dkhq_ajax_capture_lead');
add_action('wp_ajax_dkhq_capture_lead',        'dkhq_ajax_capture_lead');

// ── update_lead_summary ────────────────────────────────────────────────────────
function dkhq_ajax_update_lead_summary() {
    global $wpdb;
    $session_id = sanitize_text_field($_POST['session_id'] ?? '');
    $summary    = sanitize_textarea_field($_POST['summary'] ?? '');

    if (empty($session_id) || empty($summary)) {
        wp_send_json(['ok' => false, 'msg' => 'Missing fields']);
    }

    $updated = $wpdb->update(
        $wpdb->prefix . 'dkhq_leads',
        ['first_query' => $summary], 
        ['session_id' => $session_id],
        ['%s'], 
        ['%s']  
    );

    if ($updated === false) { wp_send_json(['ok' => false, 'msg' => 'DB err']); }
    wp_send_json(['ok' => true]);
}
add_action('wp_ajax_nopriv_dkhq_update_lead_summary', 'dkhq_ajax_update_lead_summary');
add_action('wp_ajax_dkhq_update_lead_summary',        'dkhq_ajax_update_lead_summary');

// ── LEGACY TAKEOVER POLLING (Kept for backward compatibility) ─────────────────
function dkhq_ajax_check_takeover() {
    global $wpdb;
    $session_id = sanitize_text_field($_GET['session_id'] ?? '');
    $last_log_id = intval($_GET['last_log_id'] ?? 0);

    if (!$session_id) wp_send_json(['takeover' => false]);

    // Check if an admin is currently live
    $takeover = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s AND is_active = 1 LIMIT 1", $session_id));

    // Get any new messages from the admin that the user hasn't seen yet
    $messages = $wpdb->get_results($wpdb->prepare("SELECT id, message FROM {$wpdb->prefix}dkhq_chat_logs WHERE session_id = %s AND sender = 'admin' AND id > %d ORDER BY id ASC", $session_id, $last_log_id));

    $admin_name = 'Human Agent';
    if ($takeover) {
        $admin = get_userdata($takeover->admin_id);
        if ($admin) $admin_name = explode(' ', $admin->display_name)[0];
    }

    wp_send_json([
        'takeover'   => $takeover ? true : false,
        'admin_name' => $admin_name,
        'messages'   => $messages
    ]);
}
add_action('wp_ajax_nopriv_check_takeover', 'dkhq_ajax_check_takeover');
add_action('wp_ajax_check_takeover',        'dkhq_ajax_check_takeover');


// ── NEW: FULL SESSION DETAILS (For LocalStorage Chat Recovery) ─────────────────
function dkhq_ajax_get_session_detail() {
    global $wpdb;
    $session_id = sanitize_text_field($_GET['session_id'] ?? '');
    
    if (!$session_id) {
        wp_send_json([]);
    }

    // Fetch the entire chat history for this specific visitor
    $messages = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_chat_logs WHERE session_id = %s ORDER BY id ASC",
        $session_id
    ));

    wp_send_json($messages ?: []);
}
add_action('wp_ajax_nopriv_dkhq_get_session_detail', 'dkhq_ajax_get_session_detail');
add_action('wp_ajax_dkhq_get_session_detail',        'dkhq_ajax_get_session_detail');


// ── NEW: STRICT TAKEOVER STATUS CHECK (For High-Speed Polling) ─────────────────
function dkhq_ajax_get_takeover_status() {
    global $wpdb;
    $session_id = sanitize_text_field($_GET['session_id'] ?? '');
    
    if (!$session_id) {
        wp_send_json(['is_active' => false]);
    }

    // Check the latest takeover status for this session
    $takeover = $wpdb->get_row($wpdb->prepare(
        "SELECT is_active FROM {$wpdb->prefix}dkhq_takeovers WHERE session_id = %s ORDER BY id DESC LIMIT 1",
        $session_id
    ));

    wp_send_json([
        'is_active' => $takeover ? (bool)$takeover->is_active : false
    ]);
}
add_action('wp_ajax_nopriv_dkhq_get_takeover_status', 'dkhq_ajax_get_takeover_status');
add_action('wp_ajax_dkhq_get_takeover_status',        'dkhq_ajax_get_takeover_status');


// ── CREATE TAKEOVERS TABLE (Engine Auto-Repair) ───────────────────────────────
function dkhq_create_takeover_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'dkhq_takeovers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        session_id varchar(100) NOT NULL,
        admin_id bigint(20) NOT NULL,
        is_active tinyint(1) DEFAULT 1,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY session_id (session_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
// Triggers the table creation silently when you load the WordPress backend
add_action('admin_init', 'dkhq_create_takeover_table');