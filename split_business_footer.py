import os

with open('business/footer.php', 'r', encoding='utf-8') as f:
    content = f.read()

style_start = content.find('<style>')
style_end = content.find('</style>') + len('</style>')
if style_start != -1:
    css_content = content[style_start + len('<style>'):style_end - len('</style>')].strip()
else:
    css_content = ''

script_start = content.find('<script>')
script_end = content.rfind('</script>') + len('</script>')

if script_start != -1:
    js_content = content[script_start:script_end]
    js_content = js_content.replace('<script>', '').replace('</script>', '').strip()
else:
    js_content = ''


html_start = content.find('<!-- Footer UI -->')
html_end = style_start if style_start != -1 else script_start
html_content = content[html_start:html_end]

os.makedirs('assets/css', exist_ok=True)
os.makedirs('assets/js', exist_ok=True)
os.makedirs('components/business', exist_ok=True)

with open('assets/css/business_footer.css', 'w', encoding='utf-8') as f:
    f.write(css_content)

with open('assets/js/business_footer.js', 'w', encoding='utf-8') as f:
    f.write(js_content)

with open('components/business/business_footer_component.php', 'w', encoding='utf-8') as f:
    f.write(html_content.strip())

new_main_content = content[:html_start] + "    <link rel=\"stylesheet\" href=\"/assets/css/business_footer.css\">\n<?php require_once __DIR__ . '/../components/business/business_footer_component.php'; ?>\n    <script src=\"/assets/js/business_footer.js\"></script>\n</body>\n</html>"

with open('business/footer.php', 'w', encoding='utf-8') as f:
    f.write(new_main_content)
