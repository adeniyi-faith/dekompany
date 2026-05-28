<?php
/**
 * De Kompany Admin — Auth & Bootstrap
 * ─────────────────────────────────────────────────────────────────────────────
 * Location : /wp/admin/auth.php
 * Purpose  : Boots WordPress, enforces the admin-only security gate, and
 *            defines all shared constants + helper functions used across
 *            admin.php, api.php, header.php, and footer.php.
 *
 * Include order:
 *   header.php  → require_once __DIR__ . '/auth.php'  (first line)
 *   api.php     → require_once __DIR__ . '/auth.php'  (first line)
 * ─────────────────────────────────────────────────────────────────────────────
 */

// ── 1. BOOT WORDPRESS ────────────────────────────────────────────────────────
// admin.php lives at /wp/admin/, so wp-load.php is one directory up (/wp/).
$wp_load = dirname(__DIR__) . '/wp-load.php';
if (!file_exists($wp_load)) {
    die('wp-load.php not found. Expected at: ' . $wp_load);
}
require_once $wp_load;

// api.php uses a multi-candidate fallback because it can be called directly
// via XHR from different directory contexts. Only run this block when the
// single-path boot above failed (i.e., when auth.php is included from api.php).
if (!defined('ABSPATH')) {
    $wp_load_candidates = [
        dirname(dirname(__DIR__)) . '/wp-load.php',   // /wp-load.php
        dirname(__DIR__)          . '/wp-load.php',   // /wp/wp-load.php
        $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php',   // docroot fallback
    ];
    $_wp_loaded = false;
    foreach ($wp_load_candidates as $_p) {
        if (file_exists($_p)) { require_once $_p; $_wp_loaded = true; break; }
    }
    if (!$_wp_loaded) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'msg' => 'WordPress could not be loaded.']);
        exit;
    }
}

// ── 2. SECURITY GATE ─────────────────────────────────────────────────────────
// Every admin file must pass this gate. Non-admin callers are bounced away.
// api.php sends a JSON 403; admin.php redirects to the WP login page.
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    if (defined('DKHQ_API_REQUEST') && DKHQ_API_REQUEST) {
        // Called from api.php — return JSON error
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
        exit;
    }
    // Called from admin.php / header.php — redirect to WP login
    wp_redirect(wp_login_url(home_url('/wp/admin/admin.php')));
    exit;
}

// ── 3. GLOBAL SETUP ──────────────────────────────────────────────────────────
global $wpdb;

if (!defined('DKHQ_ADMIN'))   define('DKHQ_ADMIN',   true);
if (!defined('DKHQ_VERSION')) define('DKHQ_VERSION', '1.0.0');

// The admin API URL — always points to api.php in the same folder
if (!defined('DKHQ_API_URL')) define('DKHQ_API_URL', home_url('/wp/admin/api.php'));

// ── 4. ENTERPRISE AUTO-REPAIR ────────────────────────────────────────────────
// Because this is a custom dashboard, native WP hooks like 'admin_init' do
// not fire. This manually forces the plugin to build the takeovers table if
// it is missing on a fresh install.
if (function_exists('dkhq_create_takeover_table')) {
    dkhq_create_takeover_table();
}

// ── 5. SHARED HELPER FUNCTIONS ───────────────────────────────────────────────

/**
 * Return the active AI prompt row for a given sector.
 */
function dkhq_get_prompt(string $sector): ?object {
    global $wpdb;
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}dkhq_prompts
         WHERE sector = %s AND is_active = 1
         ORDER BY id DESC LIMIT 1",
        $sector
    ));
}

/**
 * Return whether a given section is marked visible (defaults to true when
 * no row exists — "show everything" is the safe default).
 */
function dkhq_section_visible(string $sector, string $key): bool {
    global $wpdb;
    $row = $wpdb->get_var($wpdb->prepare(
        "SELECT is_visible FROM {$wpdb->prefix}dkhq_section_toggles
         WHERE sector = %s AND section_key = %s",
        $sector, $key
    ));
    return ($row === null) ? true : (bool) $row;
}

/**
 * Sanitize and echo a string for safe HTML output.
 */
function dkhq_e(string $str): void {
    echo esc_html($str);
}

/**
 * Emit a JSON response and terminate execution.
 * Used by api.php for every endpoint response.
 */
function dkhq_json(array $data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($data);
    exit;
}
