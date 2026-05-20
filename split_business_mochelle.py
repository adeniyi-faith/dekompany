import os

with open('business/mochelle-fashion-school.php', 'r', encoding='utf-8') as f:
    content = f.read()

style_start = content.find('<style>') + len('<style>')
style_end = content.find('</style>')
css_content = content[style_start:style_end].strip()

script_start = content.find('<script>')
script_end = content.find('</script>') + len('</script>')
if script_start != -1:
    js_content = content[script_start + len('<script>'):script_end - len('</script>')].strip()
    # remove from content
else:
    js_content = ''

body_start = content.find('</style>') + len('</style>')
body_end = content.find('<?php include \'footer.php\'; ?>')
body_content = content[body_start:body_end]

if script_start != -1:
    body_content = body_content[:body_content.find('<script>')] + body_content[body_content.find('</script>')+len('</script>'):]


os.makedirs('assets/css', exist_ok=True)
os.makedirs('assets/js', exist_ok=True)
os.makedirs('components/business', exist_ok=True)

with open('assets/css/business_mochelle.css', 'w', encoding='utf-8') as f:
    f.write(css_content)

with open('assets/js/business_mochelle.js', 'w', encoding='utf-8') as f:
    f.write(js_content)

with open('components/business/business_mochelle_component.php', 'w', encoding='utf-8') as f:
    f.write(body_content.strip())

new_main_content = f"<?php include 'header.php'; ?>\n\n<link rel=\"stylesheet\" href=\"/assets/css/business_mochelle.css\">\n\n<?php require_once __DIR__ . '/../components/business/business_mochelle_component.php'; ?>\n\n<script src=\"/assets/js/business_mochelle.js\"></script>\n\n<?php include 'footer.php'; ?>"

with open('business/mochelle-fashion-school.php', 'w', encoding='utf-8') as f:
    f.write(new_main_content)
