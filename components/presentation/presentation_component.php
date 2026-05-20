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
