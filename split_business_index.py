import os

with open('business/index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# No <style> or <script> tags present in business/index.php.
# HTML logic to extract to components/business/business_index_component.php

os.makedirs('components/business', exist_ok=True)
os.makedirs('assets/css', exist_ok=True)
os.makedirs('assets/js', exist_ok=True)

# create empty css and js
with open('assets/css/business_index.css', 'w', encoding='utf-8') as f:
    pass

with open('assets/js/business_index.js', 'w', encoding='utf-8') as f:
    pass

# Extract the <main> block
main_start = content.find('<main')
main_end = content.find('</main>') + len('</main>')
main_content = content[main_start:main_end]

with open('components/business/business_index_component.php', 'w', encoding='utf-8') as f:
    f.write(main_content.strip())

new_main_content = content[:main_start] + "<?php require_once __DIR__ . '/../components/business/business_index_component.php'; ?>\n\n    <script src=\"/assets/js/business_index.js\"></script>\n" + content[main_end:]

with open('business/index.php', 'w', encoding='utf-8') as f:
    f.write(new_main_content)
