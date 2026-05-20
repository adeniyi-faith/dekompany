<?php
// 1. Dynamic SEO Logic
// If variables are not set by the page, these defaults are used.
$metaTitle = isset($pageTitle) ? $pageTitle . " | De Kompany" : "De Kompany | Global Headquarters";
$metaDesc = isset($pageDesc) ? $pageDesc : "Structuring intelligence for the modern world. We operate at the intersection of corporate strategy, academic rigor, and digital innovation.";
$metaImage = isset($pageImage) ? $pageImage : "https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg"; // Default Brand Logo
$currentUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-DRSB4JLYKS"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-DRSB4JLYKS');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title><?php echo htmlspecialchars($metaTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <link rel="canonical" href="<?php echo $currentUrl; ?>">

    <!-- Open Graph / Facebook / WhatsApp (Crucial for Sharing) -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $currentUrl; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($metaTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <meta property="og:image" content="<?php echo $metaImage; ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo $currentUrl; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($metaTitle); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($metaDesc); ?>">
    <meta property="twitter:image" content="<?php echo $metaImage; ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="https://api.getonlinestudio.com/wp-content/uploads/2025/12/IMG-20251209-WA0003.jpg" type="image/jpeg">

    <!-- Styles & Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;800&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="/assets/css/about_header.css">
</head>
<body class="bg-white text-slate-900 font-sans selection:bg-blue-900 selection:text-white">

    <?php require_once __DIR__ . '/../components/about/about_header_component.php'; ?>

    <script src="/assets/js/about_header.js"></script>
