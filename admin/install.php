<?php
/**
 * De Kompany Admin — DB Installer
 * Run once: yourdomain.com/admin/install.php
 * Delete after use.
 */

// Load WordPress
// --- BULLETPROOF PATH RESOLVER START ---
$possible_paths = [
    dirname(__DIR__) . '/wp-load.php',
    $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php',
    dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php',
    dirname(dirname(__DIR__)) . '/wp-load.php'
];

$wp_load = false;
foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        $wp_load = $path;
        break;
    }
}

if (!$wp_load) {
    die('<h2 style="font-family:monospace;color:red;">wp-load.php not found. Adjust path in install.php.</h2>');
}
require_once $wp_load;
// --- BULLETPROOF PATH RESOLVER END ---

if (!current_user_can('manage_options')) {
    wp_die('Unauthorized. You must be logged in as an admin to run this installer.');
}

global $wpdb;
$charset = $wpdb->get_charset_collate();

// 1. AI Prompts Table
$sql_prompts = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_prompts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sector VARCHAR(50) NOT NULL COMMENT 'academic | business | concierge',
    prompt_label VARCHAR(100) NOT NULL,
    system_prompt LONGTEXT NOT NULL,
    ai_model VARCHAR(100) DEFAULT 'gemini-2.5-flash-lite',
    temperature FLOAT DEFAULT 0.7,
    max_tokens INT DEFAULT 300,
    is_active TINYINT(1) DEFAULT 1,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) $charset;";

// 2. Chat Logs Table
$sql_logs = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_chat_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    sector VARCHAR(50) NOT NULL,
    sender ENUM('user','bot') NOT NULL,
    message LONGTEXT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_session (session_id),
    INDEX idx_sector (sector),
    INDEX idx_created (created_at)
) $charset;";

// 3. Leads Table
$sql_leads = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_leads (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100),
    sector VARCHAR(50),
    name VARCHAR(150),
    email VARCHAR(200),
    phone VARCHAR(50),
    first_query TEXT,
    status ENUM('new','contacted','converted','archived') DEFAULT 'new',
    notes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_sector (sector),
    INDEX idx_status (status),
    INDEX idx_email (email)
) $charset;";

// 4. Client Presentation Pages
$sql_presentations = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_presentations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(200) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    client_name VARCHAR(200),
    sector VARCHAR(50) DEFAULT 'business',
    hero_headline TEXT,
    hero_subheadline TEXT,
    sections LONGTEXT COMMENT 'JSON array of section blocks',
    theme VARCHAR(50) DEFAULT 'business',
    is_published TINYINT(1) DEFAULT 0,
    password_protected VARCHAR(100) DEFAULT NULL,
    view_count INT DEFAULT 0,
    created_by BIGINT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) $charset;";

// 5. Section Toggles
$sql_toggles = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_section_toggles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sector VARCHAR(50) NOT NULL,
    section_key VARCHAR(100) NOT NULL,
    section_label VARCHAR(200) NOT NULL,
    is_visible TINYINT(1) DEFAULT 1,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY sector_section (sector, section_key)
) $charset;";

// 6. Media Library
$sql_media = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_media (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    original_name VARCHAR(255),
    file_url TEXT NOT NULL,
    file_type VARCHAR(50),
    file_size INT,
    alt_text VARCHAR(255),
    tags VARCHAR(500),
    uploaded_by BIGINT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) $charset;";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';
dbDelta($sql_prompts);
dbDelta($sql_logs);
dbDelta($sql_leads);
dbDelta($sql_presentations);
dbDelta($sql_toggles);
dbDelta($sql_media);

// Seed default prompts
$existing = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_prompts");
if ($existing == 0) {
    $prompts = [
        ['academic', 'Academic Coach', "You are an enthusiastic Academic Coach for 'De Kompany' (Academic Services). Tone: Encouraging, smart, helpful, mentoring. Services: Academic Writing, Research, Coaching. AVOID military slang. Keep answers short, plain text, and easy to read. ALWAYS end your response with a short question to check if they need more help. When the user provides their name or email, acknowledge it warmly."],
        ['business', 'Strategic Consultant', "You are a Senior Strategy Consultant for 'De Kompany' (Business Services). Tone: Professional, sophisticated, concise, data-driven. Services: Brand Strategy, Documentation, Corporate Writing. DO NOT use markdown characters like asterisks or hashtags. Keep answers plain text. Conclude your response with a relevant strategic question to guide them to the next step. When the user provides their name or email, acknowledge it professionally."],
        ['concierge', 'De Kompany Concierge', "You are the De Kompany Concierge — friendly, knowledgeable, and helpful. You guide visitors to the right sector: Academic (for students needing writing, research, coaching) or Business (for companies needing strategy, documentation, brand development). Ask what brings them here, then direct them accordingly. Keep responses warm, brief, and conversational."],
    ];
    foreach ($prompts as $p) {
        $wpdb->insert("{$wpdb->prefix}dkhq_prompts", [
            'sector' => $p[0], 'prompt_label' => $p[1], 'system_prompt' => $p[2]
        ]);
    }
}

// Seed default section toggles
$existing_toggles = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_section_toggles");
if ($existing_toggles == 0) {
    $sections = [
        ['academic', 'hero', 'Academic Hero Section'],
        ['academic', 'student-services', 'Academic Services Grid'],
        ['academic', 'student-lounge', 'Student Lounge / Library'],
        ['academic', 'system-logs', 'Terminal / System Logs'],
        ['business', 'hero', 'Business Hero Section'],
        ['business', 'about-us', 'About Us / Knowledge Architecture'],
        ['business', 'business-expertise', 'Core Expertise Grid'],
        ['business', 'portfolio', 'Why De Kompany / Stats'],
        ['business', 'business-insights', 'Strategic Insights / Blog'],
    ];
    foreach ($sections as $s) {
        $wpdb->insert("{$wpdb->prefix}dkhq_section_toggles", [
            'sector' => $s[0], 'section_key' => $s[1], 'section_label' => $s[2], 'is_visible' => 1
        ]);
    }
}

echo '<!DOCTYPE html><html><head><style>body{font-family:monospace;background:#0a1128;color:#e2e8f0;padding:40px;} .ok{color:#4ade80;} .table{color:#facc15;} h1{color:white;}</style></head><body>';
echo '<h1>✅ De Kompany Admin — Installation Complete</h1>';
echo '<p class="ok">All tables created successfully:</p>';
$tables = ['dkhq_prompts','dkhq_chat_logs','dkhq_leads','dkhq_presentations','dkhq_section_toggles','dkhq_media'];
foreach ($tables as $t) {
    echo "<p>→ <span class='table'>{$wpdb->prefix}{$t}</span> ✓</p>";
}
echo '<br><p style="color:#f87171;font-weight:bold;">⚠️ DELETE this install.php file immediately after setup!</p>';
echo '<p><a href="./index.php" style="color:#facc15;">→ Go to Admin Dashboard</a></p>';
echo '</body></html>';
