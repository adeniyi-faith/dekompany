<?php
/*
Plugin Name: Faith Core Logic
Description: Custom table management for Likes and Post Format support.
Version: 1.0
*/

// 1. Enable Post Formats to distinguish Content Types
// In Admin: Standard = Visual/Indepth, Status = Thought, Link = Link
add_action('after_setup_theme', function() {
    add_theme_support('post-formats', ['status', 'link', 'image']);
    add_theme_support('post-thumbnails');
});

// 2. Custom Database Table for Likes (High Performance)
// Runs on plugin load to ensure table exists. In prod, run this manually once.
add_action('admin_init', function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'faith_stats';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id bigint(20) NOT NULL,
            likes_count bigint(20) DEFAULT 0,
            views_count bigint(20) DEFAULT 0,
            PRIMARY KEY  (id),
            UNIQUE KEY post_id (post_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
});

// 3. Helper: Get Like Count
function get_faith_likes($post_id) {
    global $wpdb;
    $table = $wpdb->prefix . 'faith_stats';
    $count = $wpdb->get_var($wpdb->prepare("SELECT likes_count FROM $table WHERE post_id = %d", $post_id));
    return $count ? (int)$count : 0;
}

// 4. Helper: Increment Like (Used by API)
function increment_faith_like($post_id) {
    global $wpdb;
    $table = $wpdb->prefix . 'faith_stats';
    
    // Insert or Update (Upsert)
    $query = "INSERT INTO $table (post_id, likes_count) VALUES (%d, 1) 
              ON DUPLICATE KEY UPDATE likes_count = likes_count + 1";
              
    return $wpdb->query($wpdb->prepare($query, $post_id));
}