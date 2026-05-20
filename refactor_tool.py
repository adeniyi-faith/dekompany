import os

def refactor_file(filepath, name, section):
    print(f"Refactoring {filepath}...")
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    css_content = ''
    js_content = ''

    style_start = content.find('<style>')
    if style_start != -1:
        style_end = content.find('</style>') + len('</style>')
        css_content = content[style_start + len('<style>'):style_end - len('</style>')].strip()
        content = content[:style_start] + content[style_end:]

    script_start = content.rfind('<script>')
    if script_start != -1:
        script_end = content.find('</script>', script_start) + len('</script>')
        js_content = content[script_start + len('<script>'):script_end - len('</script>')].strip()
        content = content[:script_start] + content[script_end:]

    os.makedirs('assets/css', exist_ok=True)
    os.makedirs('assets/js', exist_ok=True)
    os.makedirs(f'components/{section}', exist_ok=True)

    with open(f'assets/css/{name}.css', 'w', encoding='utf-8') as f:
        f.write(css_content)

    with open(f'assets/js/{name}.js', 'w', encoding='utf-8') as f:
        f.write(js_content)

    component_path = f'components/{section}/{name}_component.php'
    with open(component_path, 'w', encoding='utf-8') as f:
        f.write(content.strip())

    new_content = f"""<?php
// Extracted component {name}
?>
<link rel="stylesheet" href="/assets/css/{name}.css">
<?php require_once __DIR__ . '/../{component_path}'; ?>
<script src="/assets/js/{name}.js"></script>
"""
    if "admin/" not in filepath and "wp/" not in filepath: # don't fully replace if not sure
        pass

    # Actually, full replacement isn't always right (e.g. headers vs content pages).
    # We should do this manually per file to avoid breaking include chains.
    print(f"Extraction for {filepath} complete. Review before updating the file.")

if __name__ == "__main__":
    pass
