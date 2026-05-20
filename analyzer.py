import os

def analyze_file(filepath):
    with open(filepath, 'r', encoding='utf-8', errors='ignore') as f:
        content = f.read()
        lines = content.split('\n')
        line_count = len(lines)

        has_inline_style = '<style' in content or 'style=' in content
        has_inline_script = '<script' in content
        has_php = '<?php' in content
        has_html = '<html' in content or '<div' in content

        issues = []
        if has_inline_style:
            issues.append('contains inline styles')
        if has_inline_script:
            issues.append('contains inline scripts')
        if has_php and has_html:
            issues.append('mixed concerns (PHP and HTML)')
        if line_count > 300:
            issues.append('long file (over 300 lines)')

        print(f"File: {filepath}")
        print(f"  Lines: {line_count}")
        if issues:
            print(f"  Issues: {', '.join(issues)}")
        else:
            print("  Status: Looks fine / minor issues")
        print()

for root, _, files in os.walk('.'):
    if '.git' in root or 'node_modules' in root:
        continue
    for file in files:
        if file.endswith(('.php', '.html', '.js', '.css')):
            analyze_file(os.path.join(root, file))
