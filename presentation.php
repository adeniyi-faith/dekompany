<?php
/**
 * De Kompany — Client Presentation Page
 * URL: /presentation.php?slug=your-client-slug
 * Uses wp-load to fetch from DB, renders standalone with correct theme.
 */
$wp_load = __DIR__ . '/wp-load.php';
if (!file_exists($wp_load)) die('Configuration error.');
require_once $wp_load;

global $wpdb;

$slug = sanitize_title($_GET['slug'] ?? '');
if (!$slug) wp_die('No presentation specified.');

$page = $wpdb->get_row($wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}dkhq_presentations WHERE slug = %s AND is_published = 1",
    $slug
));

if (!$page) {
    // Check if exists but unpublished (admin preview)
    $draft = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}dkhq_presentations WHERE slug = %s", $slug));
    if (!$draft || !current_user_can('manage_options')) {
        wp_die('Page not found or not published.');
    }
    $page = $draft;
    $is_preview = true;
}

// Password check
if ($page->password_protected) {
    session_start();
    $session_key = 'dkhq_pres_' . $slug;
    if (empty($_SESSION[$session_key])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pres_password'])) {
            if ($_POST['pres_password'] === $page->password_protected) {
                $_SESSION[$session_key] = true;
            } else {
                $pw_error = 'Incorrect password.';
            }
        }
        if (empty($_SESSION[$session_key])) {
            ?><!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
            <title><?php echo esc_html($page->title); ?> — Protected</title>
            <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700&display=swap" rel="stylesheet">
            <style>body{background:#050a18;display:flex;align-items:center;justify-content:center;min-height:100vh;font-family:'Syne',sans-serif;color:#e2e8f0;margin:0;}
            .box{background:#0c1530;border:1px solid #1a2a5e;border-radius:14px;padding:40px;width:100%;max-width:400px;text-align:center;}
            h2{color:white;margin-bottom:8px;}p{color:#8da0bf;font-size:14px;margin-bottom:24px;}
            input{width:100%;padding:12px 16px;background:#050a18;border:1px solid #243070;border-radius:8px;color:white;font-size:14px;box-sizing:border-box;margin-bottom:14px;}
            button{width:100%;padding:12px;background:#e8b84b;border:none;border-radius:8px;font-weight:700;font-size:15px;cursor:pointer;color:#000;}
            .err{color:#f05a5a;font-size:13px;margin-bottom:10px;}</style>
            </head><body><div class="box">
            <h2>🔒 Protected Page</h2>
            <p><?php echo esc_html($page->title); ?></p>
            <?php if (!empty($pw_error)) echo '<div class="err">' . esc_html($pw_error) . '</div>'; ?>
            <form method="POST"><input type="password" name="pres_password" placeholder="Enter password" required><button type="submit">Access Page</button></form>
            </div></body></html><?php
            exit;
        }
    }
}

// Increment views
$wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}dkhq_presentations SET view_count = view_count + 1 WHERE id = %d", $page->id));

$sections = json_decode($page->sections ?: '[]', true) ?: [];
$is_business = $page->sector !== 'academic';

// Colours
$bg_main    = $is_business ? '#ffffff' : '#050a18';
$text_main  = $is_business ? '#1e293b' : '#e2e8f0';
$accent     = $is_business ? '#1e3a8a' : '#e8b84b';
$accent2    = $is_business ? '#3b82f6' : '#f5d07a';
$card_bg    = $is_business ? '#f8fafc' : '#0c1530';
$card_border= $is_business ? '#e2e8f0' : '#1a2a5e';
$nav_bg     = $is_business ? 'rgba(255,255,255,0.97)' : 'rgba(5,10,24,0.97)';
$hero_text  = $is_business ? '#1e3a8a' : '#ffffff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html($page->title); ?> — De Kompany</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Space+Grotesk:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
    --bg: <?php echo $bg_main; ?>;
    --text: <?php echo $text_main; ?>;
    --accent: <?php echo $accent; ?>;
    --accent2: <?php echo $accent2; ?>;
    --card-bg: <?php echo $card_bg; ?>;
    --card-border: <?php echo $card_border; ?>;
    --nav-bg: <?php echo $nav_bg; ?>;
    --hero-text: <?php echo $hero_text; ?>;
}
body { background: var(--bg); color: var(--text); font-family: 'Space Grotesk', sans-serif; }

nav { position: sticky; top: 0; z-index: 50; background: var(--nav-bg); backdrop-filter: blur(8px); border-bottom: 1px solid var(--card-border); padding: 14px 24px; display: flex; align-items: center; justify-content: space-between; }
.logo { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 20px; color: var(--accent); }
.logo span { color: var(--text); font-weight: 400; font-size: 13px; display: block; opacity: .6; }
.client-tag { font-size: 12px; background: var(--card-bg); border: 1px solid var(--card-border); padding: 5px 14px; border-radius: 999px; color: var(--accent); font-weight: 600; }

.hero { padding: 80px 24px; max-width: 900px; margin: 0 auto; text-align: center; }
.hero-eyebrow { font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--accent); margin-bottom: 16px; }
.hero h1 { font-family: 'Syne', sans-serif; font-size: clamp(32px, 5vw, 58px); font-weight: 800; color: var(--hero-text); line-height: 1.1; margin-bottom: 20px; }
.hero p { font-size: 18px; opacity: .7; max-width: 640px; margin: 0 auto; line-height: 1.7; }

.sections-wrap { max-width: 860px; margin: 0 auto; padding: 0 24px 80px; }
.section-block { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 14px; padding: 36px; margin-bottom: 24px; }
.section-block h3 { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; color: var(--accent); margin-bottom: 14px; }
.section-block p  { line-height: 1.8; opacity: .8; font-size: 15px; }
.section-block ul { list-style: none; padding: 0; }
.section-block ul li { padding: 10px 0; border-bottom: 1px solid var(--card-border); display: flex; align-items: center; gap: 10px; font-size: 15px; }
.section-block ul li:last-child { border: none; }
.section-block ul li::before { content: '→'; color: var(--accent); font-weight: 700; }

.cta-block { background: var(--accent); border-radius: 14px; padding: 48px; text-align: center; color: white; margin-bottom: 24px; }
.cta-block h3 { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 12px; }
.cta-block p  { opacity: .85; font-size: 16px; margin-bottom: 24px; }
.cta-btn { display: inline-block; background: white; color: var(--accent); font-weight: 700; font-size: 15px; padding: 14px 36px; border-radius: 10px; text-decoration: none; }
.cta-btn:hover { opacity: .9; }

footer { text-align: center; padding: 32px; font-size: 12px; opacity: .4; border-top: 1px solid var(--card-border); }

<?php if (!$is_business): ?>
body { background: linear-gradient(180deg, #050a18 0%, #080f24 100%); }
.hero h1 .gold { color: #e8b84b; }
<?php endif; ?>

<?php if (!empty($is_preview)): ?>
.preview-bar { position: fixed; top: 0; left: 0; right: 0; z-index: 9999; background: #f5a442; padding: 8px 20px; font-size: 13px; font-weight: 700; text-align: center; color: #000; }
body { padding-top: 40px; }
<?php endif; ?>
</style>
</head>
<body>
<?php if (!empty($is_preview)): ?>
<div class="preview-bar">⚠ PREVIEW MODE — This page is not yet published | <a href="./admin/" style="color:#000;text-decoration:underline;">Back to Admin</a></div>
<?php endif; ?>

<nav>
    <div class="logo">De Kompany<span>Presentation</span></div>
    <?php if ($page->client_name): ?>
    <div class="client-tag">Prepared for <?php echo esc_html($page->client_name); ?></div>
    <?php endif; ?>
</nav>

<div class="hero">
    <div class="hero-eyebrow">Confidential Presentation</div>
    <h1><?php echo wp_kses_post($page->hero_headline ?: $page->title); ?></h1>
    <?php if ($page->hero_subheadline): ?>
    <p><?php echo esc_html($page->hero_subheadline); ?></p>
    <?php endif; ?>
</div>

<div class="sections-wrap">
    <?php foreach ($sections as $section):
        $type = $section['type'] ?? 'text';
        if ($type === 'cta'): ?>
        <div class="cta-block">
            <h3><?php echo esc_html($section['heading'] ?? ''); ?></h3>
            <?php if (!empty($section['body'])): ?><p><?php echo esc_html($section['body']); ?></p><?php endif; ?>
            <?php if (!empty($section['button'])): ?>
            <a href="<?php echo esc_url($section['link'] ?? '#'); ?>" class="cta-btn"><?php echo esc_html($section['button']); ?></a>
            <?php endif; ?>
        </div>
        <?php elseif ($type === 'list'): ?>
        <div class="section-block">
            <h3><?php echo esc_html($section['heading'] ?? ''); ?></h3>
            <ul><?php foreach ($section['items'] ?? [] as $item): ?><li><?php echo esc_html($item); ?></li><?php endforeach; ?></ul>
        </div>
        <?php else: ?>
        <div class="section-block">
            <h3><?php echo esc_html($section['heading'] ?? ''); ?></h3>
            <p><?php echo esc_html($section['body'] ?? ''); ?></p>
        </div>
        <?php endif;
    endforeach; ?>
</div>

<footer>
    &copy; <?php echo date('Y'); ?> De Kompany — This document is confidential and prepared exclusively for <?php echo esc_html($page->client_name ?: 'the client'); ?>.
</footer>
</body>
</html>