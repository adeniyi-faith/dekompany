import os

with open('about/director-profile.php', 'r', encoding='utf-8') as f:
    content = f.read()

style_start = content.find('<style>') + len('<style>')
style_end = content.find('</style>')
if style_start != -1:
    css_content = content[style_start:style_end].strip()
else:
    css_content = ''

js_content = ''
script_start = content.find('<script>')
if script_start != -1:
    script_end = content.find('</script>', script_start) + len('</script>')
    js_content = content[script_start+8:script_end-9].strip()


main_start = content.find('<!-- Profile Hero -->')
main_end = content.find('<?php include \'footer.php\'; ?>')
body_content = content[main_start:main_end]

# remove script and style tags from body_content if any
if '<style>' in body_content:
    body_content = body_content[:body_content.find('<style>')] + body_content[body_content.find('</style>')+8:]

if '<script>' in body_content:
    body_content = body_content[:body_content.find('<script>')] + body_content[body_content.find('</script>')+9:]

os.makedirs('assets/css', exist_ok=True)
os.makedirs('assets/js', exist_ok=True)
os.makedirs('components/about', exist_ok=True)

with open('assets/css/about_director.css', 'w', encoding='utf-8') as f:
    f.write(css_content)

with open('assets/js/about_director.js', 'w', encoding='utf-8') as f:
    f.write(js_content)

with open('components/about/about_director_component.php', 'w', encoding='utf-8') as f:
    f.write(body_content.strip())

new_main_content = f"""<?php
$pageTitle = "Director's Profile";
$pageDesc = "Profile of the Managing Director, De Kompany.";
include 'header.php';
?>

<link rel="stylesheet" href="/assets/css/about_director.css">

<?php require_once __DIR__ . '/../components/about/about_director_component.php'; ?>

<script src="/assets/js/about_director.js"></script>

<?php include 'footer.php'; ?>"""

with open('about/director-profile.php', 'w', encoding='utf-8') as f:
    f.write(new_main_content)
