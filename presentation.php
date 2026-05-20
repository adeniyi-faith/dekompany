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
            die();
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

$body_class = [];
if (!$is_business) $body_class[] = 'academic';
if (!empty($is_preview)) $body_class[] = 'has-preview';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo esc_html($page->title); ?> — De Kompany</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Space+Grotesk:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/presentation.css">
<style>
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
</style>
</head>
<body class="<?php echo implode(' ', $body_class); ?>">
<?php require_once __DIR__ . '/components/presentation/presentation_component.php'; ?>
</body>
</html>
