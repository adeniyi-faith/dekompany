files = [
    ("presentation.php", "presentation"),
    ("dekompany-concierge-logo-glow.html", "logo_glow"),
    ("index.html", "index"),
    ("business/header.php", "business_header"),
    ("business/index.php", "business_index"),
    ("business/mochelle-fashion-school.php", "business_mochelle"),
    ("business/footer.php", "business_footer"),
    ("about/header.php", "about_header"),
    ("about/index.php", "about_index"),
    ("about/director-profile.php", "about_director"),
    ("about/pov.php", "about_pov"),
    ("about/team.php", "about_team"),
    ("student/header.php", "student_header"),
    ("student/index.php", "student_index"),
    ("student/services.php", "student_services"),
    ("student/footer.php", "student_footer"),
    ("admin/auth.php", "admin_auth"),
    ("admin/install.php", "admin_install"),
    ("admin/api.php", "admin_api"),
    ("admin/index.php", "admin_index"),
    ("wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php", "dkhq_chat_ajax")
]

plan = ""
step = 1

for filepath, name in files:
    plan += f"{step}. **Refactor `{filepath}`**\n"
    plan += f"   - Read `{filepath}` to determine components to extract.\n"
    plan += f"   - Extract inline styles to `assets/css/{name}.css`.\n"
    plan += f"   - Extract inline scripts to `assets/js/{name}.js`.\n"
    plan += f"   - Extract HTML/PHP logic to `components/{name.split('_')[0]}/{name}_component.php`.\n"
    plan += f"   - Update `{filepath}` to `require_once` the components and load the assets.\n"
    step += 1

    plan += f"{step}. **Verify `{filepath}`**\n"
    plan += f"   - Run `php -l` on `{filepath}` and extracted components.\n"
    plan += f"   - Start PHP server if not running and use curl to verify it returns 200 OK.\n"
    step += 1

plan += f"{step}. **Run all relevant tests to ensure the changes are correct and have not introduced regressions.**\n"
plan += f"   - Run the full test suite if available.\n"
step += 1

plan += f"{step}. **Complete pre commit steps**\n"
plan += f"   - Complete pre commit steps to ensure proper testing, verification, review, and reflection are done.\n"

with open("plan2.md", "w") as f:
    f.write(plan)
