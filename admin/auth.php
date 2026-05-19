<?php
/**
 * De Kompany Admin — Auth & Bootstrap
 * Include at top of every admin page.
 */

// Load WordPress without theme
// --- BULLETPROOF PATH RESOLVER START ---
$possible_paths = [
    dirname(__DIR__) . '/wp-load.php',                                  // Standard: dekompany.com/admin/
    $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php',                         // Standard: Server Document Root
    dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php',       // Edge Case: placed inside wp-content/themes/your-theme/admin/
    dirname(dirname(__DIR__)) . '/wp-load.php'                          // Edge Case: placed inside a subfolder like public_html/app/admin/
];

$wp_load = false;
foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        $wp_load = $path;
        break;
    }
}

if (!$wp_load) {
    die('<div style="padding:20px; font-family:sans-serif; color:red;"><strong>CRITICAL ERROR:</strong> wp-load.php not found. Please ensure the /admin/ folder is uploaded directly to your WordPress root, or hardcode the absolute path in admin/auth.php.</div>');
}
require_once $wp_load;
// --- BULLETPROOF PATH RESOLVER END ---

// Must be logged-in WordPress admin
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_redirect(wp_login_url(home_url('/admin/')));
    exit;
}

global $wpdb;
define('DKHQ_ADMIN', true);
define('DKHQ_VERSION', '1.0.0');

// Helper: get active prompt for sector
function dkhq_get_prompt($sector) {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_prompts WHERE sector = %s AND is_active = 1 ORDER BY id DESC LIMIT 1",
        $sector
    ));
}

// Helper: is section visible?
function dkhq_section_visible($sector, $key) {
    global $wpdb;
    $row = $wpdb->get_var($wpdb->prepare(
        "SELECT is_visible FROM {$wpdb->prefix}dkhq_section_toggles WHERE sector = %s AND section_key = %s",
        $sector, $key
    ));
    return ($row === null) ? true : (bool)$row;
}

// Helper: sanitize + escape
function dkhq_e($str) {
    echo esc_html($str);
}

// Handle AJAX-style POST actions (non-nonce checked routes for API)
function dkhq_json($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
