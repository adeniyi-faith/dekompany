<?php
/**
 * Plugin Name: Rain of Blessings App Logic
 * Description: Core business logic, encryption, and custom tables.
 * Version: 1.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ============================================
// 1. DATABASE SCHEMA SETUP
// ============================================
function rob_create_custom_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    // Loans Table
    $table_loans = $wpdb->prefix . 'loans';
    $sql_loans = "CREATE TABLE $table_loans (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        amount decimal(15,2) NOT NULL,
        duration_days int(11) NOT NULL,
        interest_rate decimal(5,2) NOT NULL,
        total_repayment decimal(15,2) NOT NULL,
        status varchar(20) DEFAULT 'pending' NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        due_date datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    // Transactions Table
    $table_trans = $wpdb->prefix . 'transactions';
    $sql_trans = "CREATE TABLE $table_trans (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        type varchar(20) NOT NULL,
        amount decimal(15,2) NOT NULL,
        status varchar(20) DEFAULT 'success' NOT NULL,
        reference varchar(50) DEFAULT '',
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql_loans );
    dbDelta( $sql_trans );
}
add_action( 'admin_init', 'rob_create_custom_tables' );

// ============================================
// 2. ENCRYPTION ENGINE (NIN / BVN)
// ============================================
function rob_encrypt($data) {
    if (empty($data)) return '';
    // Use WordPress Auth Salt as the key
    $key = wp_salt('auth'); 
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    // Store IV with data (separated by ::)
    return base64_encode($encrypted . '::' . $iv);
}

function rob_decrypt($data) {
    if (empty($data)) return '';
    $key = wp_salt('auth');
    $decoded = base64_decode($data);
    if (!strpos($decoded, '::')) return ''; // Invalid format
    
    list($encrypted_data, $iv) = explode('::', $decoded, 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

// ============================================
// 3. GLOBAL PROFILE PICTURE HANDLER
// ============================================
// This forces get_avatar_url() to use our custom uploaded image
add_filter('pre_get_avatar_data', 'rob_custom_avatar_logic', 10, 2);

function rob_custom_avatar_logic($args, $id_or_email) {
    $user = false;

    if (is_numeric($id_or_email)) {
        $user = get_user_by('id', $id_or_email);
    } elseif (is_object($id_or_email) && !empty($id_or_email->user_id)) {
        $user = get_user_by('id', (int) $id_or_email->user_id);
    }

    if ($user && is_object($user)) {
        $custom_avatar_id = get_user_meta($user->ID, 'rob_custom_avatar', true);
        if ($custom_avatar_id) {
            $img_url = wp_get_attachment_url($custom_avatar_id);
            if ($img_url) {
                $args['url'] = $img_url;
            }
        }
    }
    return $args;
}

// ============================================
// 4. HELPER FUNCTIONS
// ============================================
function rob_get_active_loan( $user_id ) {
    global $wpdb;
    $table = $wpdb->prefix . 'loans';
    return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE user_id = %d AND status = 'active' LIMIT 1", $user_id ) );
}

function rob_get_user_history( $user_id, $limit = 10 ) {
    global $wpdb;
    $table = $wpdb->prefix . 'transactions';
    return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table WHERE user_id = %d ORDER BY created_at DESC LIMIT %d", $user_id, $limit ) );
}