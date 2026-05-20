import os

with open('about/header.php', 'r', encoding='utf-8') as f:
    content = f.read()

style_start = content.find('<style>') + len('<style>')
style_end = content.find('</style>')
css_content = content[style_start:style_end].strip()

script_start = content.find('<script>', content.find('</nav>')) + len('<script>')
script_end = content.find('</script>', script_start)
js_content = content[script_start:script_end].strip()

nav_start = content.find('<nav')
nav_end = content.find('</nav>') + len('</nav>')
nav_content = content[nav_start:nav_end]

os.makedirs('assets/css', exist_ok=True)
os.makedirs('assets/js', exist_ok=True)
os.makedirs('components/about', exist_ok=True)

with open('assets/css/about_header.css', 'w', encoding='utf-8') as f:
    f.write(css_content)

with open('assets/js/about_header.js', 'w', encoding='utf-8') as f:
    f.write(js_content)

with open('components/about/about_header_component.php', 'w', encoding='utf-8') as f:
    f.write(nav_content.strip())

head_content = content[:content.find('<style>')]
body_tag = content[content.find('<body'):content.find('>', content.find('<body'))+1]

new_main_content = f"{head_content}    <link rel=\"stylesheet\" href=\"/assets/css/about_header.css\">\n</head>\n{body_tag}\n\n    <?php require_once __DIR__ . '/../components/about/about_header_component.php'; ?>\n\n    <script src=\"/assets/js/about_header.js\"></script>\n"

with open('about/header.php', 'w', encoding='utf-8') as f:
    f.write(new_main_content)
