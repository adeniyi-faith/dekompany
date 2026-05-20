import os

with open('dekompany-concierge-logo-glow.html', 'r', encoding='utf-8') as f:
    content = f.read()

style_start = content.find('<style>') + len('<style>')
style_end = content.find('</style>')
css_content = content[style_start:style_end].strip()

script_start = content.find('<script>', content.find('</style>')) + len('<script>')
script_end = content.find('</script>', script_start)
js_content = content[script_start:script_end].strip()

# component_html should be everything inside body minus the script block
body_start = content.find('<body>') + len('<body>')
body_end = content.find('</body>')

body_content = content[body_start:body_end]
# Remove script block from body
body_content = body_content[:body_content.find('<script>')] + body_content[body_content.find('</script>')+len('</script>'):]


with open('assets/css/logo_glow.css', 'w', encoding='utf-8') as f:
    f.write(css_content)

with open('assets/js/logo_glow.js', 'w', encoding='utf-8') as f:
    f.write(js_content)

with open('components/logo/logo_glow_component.php', 'w', encoding='utf-8') as f:
    f.write(body_content.strip())

head_content = content[:content.find('<style>')]
new_main_content = f"{head_content}    <link rel=\"stylesheet\" href=\"/assets/css/logo_glow.css\">\n</head>\n<body>\n<?php require_once __DIR__ . '/components/logo/logo_glow_component.php'; ?>\n<script src=\"/assets/js/logo_glow.js\"></script>\n</body>\n</html>"

with open('dekompany-concierge-logo-glow.php', 'w', encoding='utf-8') as f:
    f.write(new_main_content)
