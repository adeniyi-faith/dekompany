import os

with open('assets/js/business_footer.js', 'r', encoding='utf-8') as f:
    js_content = f.read()

# Since js_content has PHP template variables, we need to inject them from the main footer.php as window variables before including the script.
with open('business/footer.php', 'r', encoding='utf-8') as f:
    main_content = f.read()

# Revert to passing vars via script tag before the external JS file
script_injection = """
<script>
    window.DKHQ_CONFIG = {
        ADMIN_API: '<?php echo esc_js($admin_api); ?>',
        GEMINI_KEY: '<?php echo esc_js($gemini_key); ?>',
        AI_MODEL: '<?php echo esc_js($ai_model); ?>',
        SYSTEM_P: `<?php echo $system_prompt; ?>`,
        MAX_TOKENS: <?php echo intval($max_tokens); ?>,
        TEMPERATURE: <?php echo floatval($temperature); ?>,
        SECTOR: 'business'
    };
</script>
"""

main_content = main_content.replace('<script src="/assets/js/business_footer.js"></script>', script_injection + '<script src="/assets/js/business_footer.js"></script>')

with open('business/footer.php', 'w', encoding='utf-8') as f:
    f.write(main_content)

# Update js file to use window.DKHQ_CONFIG
js_content = js_content.replace("'<?php echo esc_js($admin_api); ?>'", "window.DKHQ_CONFIG.ADMIN_API")
js_content = js_content.replace("'<?php echo esc_js($gemini_key); ?>'", "window.DKHQ_CONFIG.GEMINI_KEY")
js_content = js_content.replace("'<?php echo $ai_model; ?>'", "window.DKHQ_CONFIG.AI_MODEL")
js_content = js_content.replace("`<?php echo $system_prompt; ?>`", "window.DKHQ_CONFIG.SYSTEM_P")
js_content = js_content.replace("<?php echo $max_tokens; ?>", "window.DKHQ_CONFIG.MAX_TOKENS")
js_content = js_content.replace("<?php echo $temperature; ?>", "window.DKHQ_CONFIG.TEMPERATURE")

with open('assets/js/business_footer.js', 'w', encoding='utf-8') as f:
    f.write(js_content)
