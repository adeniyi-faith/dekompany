<?php
/*
Plugin Name: Faith Backend Setup
Description: Enables Post Formats and creates the Likes table.
Version: 1.0
*/

// 1. Force Enable Post Formats (Regardless of Theme)
add_action('after_setup_theme', function() {
    add_theme_support('post-formats', ['status', 'link', 'image']);
    add_theme_support('post-thumbnails');
}, 100);

// 2. Create the Likes Table (Runs when you visit WP Admin)
add_action('admin_init', function() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'faith_stats';
    
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id bigint(20) NOT NULL,
            likes_count bigint(20) DEFAULT 0,
            PRIMARY KEY  (id),
            UNIQUE KEY post_id (post_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
});