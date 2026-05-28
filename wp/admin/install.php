<?php
/**
 * De Kompany Admin — DB Installer + API Key Setup
 * Run once: yourdomain.com/wp/admin/install.php
 * DELETE this file after use.
 */

// ── BULLETPROOF WP LOADER ────────────────────────────────────────────────────
$possible_paths = [
    dirname(__DIR__) . '/wp-load.php',
    $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php',
    dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php',
    dirname(dirname(__DIR__)) . '/wp-load.php'
];
$wp_load = false;
foreach ($possible_paths as $path) {
    if (file_exists($path)) { $wp_load = $path; break; }
}
if (!$wp_load) {
    die('<h2 style="font-family:monospace;color:red;">wp-load.php not found. Adjust path in install.php.</h2>');
}
require_once $wp_load;

if (!current_user_can('manage_options')) {
    wp_die('Unauthorized. You must be logged in as an admin to run this installer.');
}

global $wpdb;
$charset = $wpdb->get_charset_collate();

// ── HANDLE KEY SAVE BEFORE TABLE CREATION ────────────────────────────────────
$key_saved   = false;
$key_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dkhq_gemini_key'])) {
    check_admin_referer('dkhq_install_save');
    $submitted_key = sanitize_text_field(trim($_POST['dkhq_gemini_key']));
    if (!empty($submitted_key)) {
        update_option('dkhq_gemini_key', $submitted_key);
        $key_saved   = true;
        $key_message = 'Gemini API key saved successfully.';
    }
    // Optionally save model preference
    if (!empty($_POST['dkhq_default_model'])) {
        update_option('dkhq_default_model', sanitize_text_field($_POST['dkhq_default_model']));
    }
}

// ── TABLE DEFINITIONS ─────────────────────────────────────────────────────────

$sql_prompts = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_prompts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sector VARCHAR(50) NOT NULL COMMENT 'academic | business | concierge',
    prompt_label VARCHAR(100) NOT NULL,
    system_prompt LONGTEXT NOT NULL,
    ai_model VARCHAR(100) DEFAULT 'gemini-2.5-flash',
    temperature FLOAT DEFAULT 0.7,
    max_tokens INT DEFAULT 400,
    is_active TINYINT(1) DEFAULT 1,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) $charset;";

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

$sql_toggles = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}dkhq_section_toggles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sector VARCHAR(50) NOT NULL,
    section_key VARCHAR(100) NOT NULL,
    section_label VARCHAR(200) NOT NULL,
    is_visible TINYINT(1) DEFAULT 1,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY sector_section (sector, section_key)
) $charset;";

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

// ── SEED DEFAULT PROMPTS ─────────────────────────────────────────────────────
$existing = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_prompts");
if ($existing == 0) {
    $prompts = [
        ['academic', 'Academic Coach',
         "You are an enthusiastic Academic Coach for 'De Kompany' (Academic Services). Tone: Encouraging, smart, helpful, mentoring. Services: Academic Writing, Research, Coaching. AVOID military slang. Keep answers short, plain text, and easy to read. ALWAYS end your response with a short question to check if they need more help. When the user provides their name or email, acknowledge it warmly."],
        ['business', 'Strategic Consultant',
         "You are a Senior Strategy Consultant for 'De Kompany' (Business Services). Tone: Professional, sophisticated, concise, data-driven. Services: Brand Strategy, Documentation, Corporate Writing. DO NOT use markdown characters like asterisks or hashtags. Keep answers plain text. Conclude your response with a relevant strategic question to guide them to the next step. When the user provides their name or email, acknowledge it professionally."],
        ['concierge', 'De Kompany Concierge',
         "You are the De Kompany Concierge — friendly, knowledgeable, and helpful. You guide visitors to the right sector: Academic (for students needing writing, research, coaching) or Business (for companies needing strategy, documentation, brand development). Ask what brings them here, then direct them accordingly. Keep responses warm, brief, and conversational."],
    ];
    foreach ($prompts as $p) {
        $wpdb->insert("{$wpdb->prefix}dkhq_prompts", [
            'sector' => $p[0], 'prompt_label' => $p[1], 'system_prompt' => $p[2]
        ]);
    }
}

// ── SEED DEFAULT SECTION TOGGLES ─────────────────────────────────────────────
$existing_toggles = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}dkhq_section_toggles");
if ($existing_toggles == 0) {
    $sections = [
        ['academic', 'hero',            'Academic Hero Section'],
        ['academic', 'student-services','Academic Services Grid'],
        ['academic', 'student-lounge',  'Student Lounge / Library'],
        ['academic', 'system-logs',     'Terminal / System Logs'],
        ['business', 'hero',            'Business Hero Section'],
        ['business', 'about-us',        'About Us / Knowledge Architecture'],
        ['business', 'business-expertise','Core Expertise Grid'],
        ['business', 'portfolio',       'Why De Kompany / Stats'],
        ['business', 'business-insights','Strategic Insights / Blog'],
    ];
    foreach ($sections as $s) {
        $wpdb->insert("{$wpdb->prefix}dkhq_section_toggles", [
            'sector' => $s[0], 'section_key' => $s[1], 'section_label' => $s[2], 'is_visible' => 1
        ]);
    }
}

// ── READ EXISTING KEY (to show masked in form) ────────────────────────────────
$existing_key   = get_option('dkhq_gemini_key', '');
$existing_model = get_option('dkhq_default_model', 'gemini-2.5-flash');
$key_is_set     = !empty($existing_key);
$masked_key     = $key_is_set ? substr($existing_key, 0, 8) . str_repeat('•', 24) : '';

// ── VERIFY API KEY WORKS (test call) ─────────────────────────────────────────
$api_test_result = '';
$api_test_ok     = null;
if ($key_is_set) {
    $test_model = $existing_model ?: 'gemini-2.5-flash';
    $test_url   = "https://generativelanguage.googleapis.com/v1beta/models/{$test_model}:generateContent?key={$existing_key}";
    $test_body  = json_encode([
        'contents' => [['role' => 'user', 'parts' => [['text' => 'Say OK']]]],
        'generationConfig' => ['maxOutputTokens' => 5]
    ]);
    $test_resp = wp_remote_post($test_url, [
        'headers'     => ['Content-Type' => 'application/json'],
        'body'        => $test_body,
        'timeout'     => 10,
    ]);
    if (is_wp_error($test_resp)) {
        $api_test_result = 'Could not reach Gemini API: ' . $test_resp->get_error_message();
        $api_test_ok     = false;
    } else {
        $body = json_decode(wp_remote_retrieve_body($test_resp), true);
        if (!empty($body['candidates'][0]['content']['parts'][0]['text'])) {
            $api_test_result = '✅ Connection verified — Gemini API key is working.';
            $api_test_ok     = true;
        } elseif (!empty($body['error']['message'])) {
            $api_test_result = '❌ API Error: ' . esc_html($body['error']['message']);
            $api_test_ok     = false;
        } else {
            $api_test_result = '⚠️ Unexpected response. Key may still work — check manually.';
            $api_test_ok     = null;
        }
    }
}

$tables = ['dkhq_prompts','dkhq_chat_logs','dkhq_leads','dkhq_presentations','dkhq_section_toggles','dkhq_media'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>De Kompany — Installer</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Courier New', monospace; background: #0a1128; color: #e2e8f0; padding: 32px 16px; min-height: 100vh; }
    .wrap { max-width: 680px; margin: 0 auto; }
    h1 { color: #fff; font-size: 1.4rem; margin-bottom: 4px; }
    .sub { color: #64748b; font-size: 0.8rem; margin-bottom: 32px; }
    .card { background: #0d1b39; border: 1px solid #1e3a6b; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
    .card h2 { color: #facc15; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 16px; }
    .row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
    .ok  { color: #4ade80; }
    .err { color: #f87171; }
    .warn { color: #fb923c; }
    .table-name { color: #facc15; }
    label { display: block; font-size: 0.8rem; color: #94a3b8; margin-bottom: 6px; margin-top: 14px; }
    input[type=text], input[type=password], select {
        width: 100%; padding: 10px 14px; background: #0a1628;
        border: 1.5px solid #1e3a6b; border-radius: 8px; color: #e2e8f0;
        font-family: monospace; font-size: 0.9rem; outline: none;
    }
    input:focus, select:focus { border-color: #facc15; }
    .btn {
        display: inline-block; margin-top: 18px; padding: 10px 24px;
        background: #ca8a04; color: #fff; border: none; border-radius: 8px;
        font-family: monospace; font-size: 0.9rem; cursor: pointer; font-weight: bold;
        transition: background 0.2s;
    }
    .btn:hover { background: #d97706; }
    .alert { padding: 12px 16px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; }
    .alert.success { background: #14532d44; border: 1px solid #4ade80; color: #4ade80; }
    .alert.error   { background: #7f1d1d44; border: 1px solid #f87171; color: #f87171; }
    .alert.warn    { background: #7c2d1244; border: 1px solid #fb923c; color: #fb923c; }
    .api-status { padding: 10px 14px; border-radius: 8px; font-size: 0.82rem; margin-top: 12px; }
    .api-ok   { background: #14532d33; border: 1px solid #4ade8055; color: #4ade80; }
    .api-fail { background: #7f1d1d33; border: 1px solid #f8717155; color: #f87171; }
    .api-warn { background: #78350f33; border: 1px solid #fb923c55; color: #fb923c; }
    .delete-warn { margin-top: 24px; color: #f87171; font-size: 0.8rem; line-height: 1.6; }
    a.dash-link { display: inline-block; margin-top: 12px; color: #facc15; font-size: 0.85rem; text-decoration: none; }
    a.dash-link:hover { text-decoration: underline; }
    .hint { font-size: 0.75rem; color: #475569; margin-top: 4px; }
    .toggler { cursor: pointer; color: #facc15; font-size: 0.75rem; text-decoration: underline; background: none; border: none; padding: 0; margin-left: 8px; }
</style>
</head>
<body>
<div class="wrap">
    <h1>🛠 De Kompany Admin — Installer</h1>
    <p class="sub">Run once. Delete this file after use.</p>

    <?php if ($key_saved): ?>
    <div class="alert success">✅ <?php echo esc_html($key_message); ?></div>
    <?php endif; ?>

    <!-- ── TABLES SECTION ── -->
    <div class="card">
        <h2>Database Tables</h2>
        <?php foreach ($tables as $t): ?>
        <div class="row">
            <span class="ok">✓</span>
            <span class="table-name"><?php echo $wpdb->prefix . $t; ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ── GEMINI API KEY SECTION ── -->
    <div class="card">
        <h2>🔑 Gemini API Key Setup</h2>

        <?php if ($key_is_set && $api_test_ok === true): ?>
        <div class="api-status api-ok"><?php echo $api_test_result; ?></div>
        <?php elseif ($key_is_set && $api_test_ok === false): ?>
        <div class="api-status api-fail"><?php echo $api_test_result; ?></div>
        <?php elseif ($key_is_set && $api_test_ok === null): ?>
        <div class="api-status api-warn"><?php echo $api_test_result; ?></div>
        <?php endif; ?>

        <form method="POST">
            <?php wp_nonce_field('dkhq_install_save'); ?>

            <label>
                Gemini API Key
                <button type="button" class="toggler" onclick="
                    var f=document.getElementById('gkey');
                    f.type = f.type==='password' ? 'text' : 'password';
                    this.textContent = f.type==='password' ? 'show' : 'hide';
                ">show</button>
            </label>
            <input type="password" id="gkey" name="dkhq_gemini_key"
                   placeholder="<?php echo $key_is_set ? $masked_key : 'AIzaSy...'; ?>"
                   autocomplete="off">
            <p class="hint">
                Get your key at
                <a href="https://aistudio.google.com/app/apikey" target="_blank"
                   style="color:#facc15;">aistudio.google.com/app/apikey</a>
                — it's free. Leave blank to keep existing key.
            </p>

            <label>Default AI Model</label>
            <select name="dkhq_default_model">
                <?php
                $models = [
                    'gemini-2.5-flash'       => 'gemini-2.5-flash (Recommended — fast + smart)',
                    'gemini-2.5-flash-lite'  => 'gemini-2.5-flash-lite (Lightest, lowest cost)',
                    'gemini-2.0-flash'       => 'gemini-2.0-flash (Stable)',
                    'gemini-1.5-pro'         => 'gemini-1.5-pro (Highest quality, slower)',
                ];
                foreach ($models as $val => $label):
                    $sel = ($existing_model === $val) ? 'selected' : '';
                ?>
                <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
            <p class="hint">This sets the model used in prompts DB. You can override per-prompt in the admin later.</p>

            <button type="submit" class="btn">Save API Key &amp; Test Connection →</button>
        </form>

        <?php if (!$key_is_set): ?>
        <div class="alert warn" style="margin-top:16px;">
            ⚠️ No Gemini key found. The academic chat will show an <em>unregistered caller</em> error until you save a key above.
        </div>
        <?php endif; ?>
    </div>

    <!-- ── NEXT STEPS ── -->
    <div class="card">
        <h2>✅ Installation Complete</h2>
        <p style="color:#94a3b8;font-size:0.85rem;line-height:1.7;">
            Tables created. Prompts seeded. API key stored in WordPress options (never in code).<br>
            The key is injected into footer.php server-side — it is never exposed in HTML source.
        </p>
        <a class="dash-link" href="./index.php">→ Go to Admin Dashboard</a>
    </div>

    <p class="delete-warn">
        ⚠️ DELETE this install.php file immediately after setup!<br>
        It is publicly accessible and must be removed for security.
    </p>
</div>
</body>
</html>