# Codebase Refactoring Audit & Plan

1. **Refactor `presentation.php`**
   - Read `presentation.php` to determine components to extract.
   - Extract inline styles to `assets/css/presentation.css`.
   - Extract inline scripts to `assets/js/presentation.js`.
   - Extract HTML/PHP logic to `components/presentation/presentation_component.php`.
   - Update `presentation.php` to `require_once` the components and load the assets.
2. **Verify `presentation.php`**
   - Run `php -l` on `presentation.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
3. **Refactor `dekompany-concierge-logo-glow.html`**
   - Read `dekompany-concierge-logo-glow.html` to determine components to extract.
   - Extract inline styles to `assets/css/logo_glow.css`.
   - Extract inline scripts to `assets/js/logo_glow.js`.
   - Extract HTML/PHP logic to `components/logo/logo_glow_component.php`.
   - Update `dekompany-concierge-logo-glow.html` to `require_once` the components and load the assets.
4. **Verify `dekompany-concierge-logo-glow.html`**
   - Run `php -l` on `dekompany-concierge-logo-glow.html` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
5. **Refactor `index.html`**
   - Read `index.html` to determine components to extract.
   - Extract inline styles to `assets/css/index.css`.
   - Extract inline scripts to `assets/js/index.js`.
   - Extract HTML/PHP logic to `components/index/index_component.php`.
   - Update `index.html` to `require_once` the components and load the assets.
6. **Verify `index.html`**
   - Run `php -l` on `index.html` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
7. **Refactor `business/header.php`**
   - Read `business/header.php` to determine components to extract.
   - Extract inline styles to `assets/css/business_header.css`.
   - Extract inline scripts to `assets/js/business_header.js`.
   - Extract HTML/PHP logic to `components/business/business_header_component.php`.
   - Update `business/header.php` to `require_once` the components and load the assets.
8. **Verify `business/header.php`**
   - Run `php -l` on `business/header.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
9. **Refactor `business/index.php`**
   - Read `business/index.php` to determine components to extract.
   - Extract inline styles to `assets/css/business_index.css`.
   - Extract inline scripts to `assets/js/business_index.js`.
   - Extract HTML/PHP logic to `components/business/business_index_component.php`.
   - Update `business/index.php` to `require_once` the components and load the assets.
10. **Verify `business/index.php`**
   - Run `php -l` on `business/index.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
11. **Refactor `business/mochelle-fashion-school.php`**
   - Read `business/mochelle-fashion-school.php` to determine components to extract.
   - Extract inline styles to `assets/css/business_mochelle.css`.
   - Extract inline scripts to `assets/js/business_mochelle.js`.
   - Extract HTML/PHP logic to `components/business/business_mochelle_component.php`.
   - Update `business/mochelle-fashion-school.php` to `require_once` the components and load the assets.
12. **Verify `business/mochelle-fashion-school.php`**
   - Run `php -l` on `business/mochelle-fashion-school.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
13. **Refactor `business/footer.php`**
   - Read `business/footer.php` to determine components to extract.
   - Extract inline styles to `assets/css/business_footer.css`.
   - Extract inline scripts to `assets/js/business_footer.js`.
   - Extract HTML/PHP logic to `components/business/business_footer_component.php`.
   - Update `business/footer.php` to `require_once` the components and load the assets.
14. **Verify `business/footer.php`**
   - Run `php -l` on `business/footer.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
15. **Refactor `about/header.php`**
   - Read `about/header.php` to determine components to extract.
   - Extract inline styles to `assets/css/about_header.css`.
   - Extract inline scripts to `assets/js/about_header.js`.
   - Extract HTML/PHP logic to `components/about/about_header_component.php`.
   - Update `about/header.php` to `require_once` the components and load the assets.
16. **Verify `about/header.php`**
   - Run `php -l` on `about/header.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
17. **Refactor `about/index.php`**
   - Read `about/index.php` to determine components to extract.
   - Extract inline styles to `assets/css/about_index.css`.
   - Extract inline scripts to `assets/js/about_index.js`.
   - Extract HTML/PHP logic to `components/about/about_index_component.php`.
   - Update `about/index.php` to `require_once` the components and load the assets.
18. **Verify `about/index.php`**
   - Run `php -l` on `about/index.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
19. **Refactor `about/director-profile.php`**
   - Read `about/director-profile.php` to determine components to extract.
   - Extract inline styles to `assets/css/about_director.css`.
   - Extract inline scripts to `assets/js/about_director.js`.
   - Extract HTML/PHP logic to `components/about/about_director_component.php`.
   - Update `about/director-profile.php` to `require_once` the components and load the assets.
20. **Verify `about/director-profile.php`**
   - Run `php -l` on `about/director-profile.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
21. **Refactor `about/pov.php`**
   - Read `about/pov.php` to determine components to extract.
   - Extract inline styles to `assets/css/about_pov.css`.
   - Extract inline scripts to `assets/js/about_pov.js`.
   - Extract HTML/PHP logic to `components/about/about_pov_component.php`.
   - Update `about/pov.php` to `require_once` the components and load the assets.
22. **Verify `about/pov.php`**
   - Run `php -l` on `about/pov.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
23. **Refactor `about/team.php`**
   - Read `about/team.php` to determine components to extract.
   - Extract inline styles to `assets/css/about_team.css`.
   - Extract inline scripts to `assets/js/about_team.js`.
   - Extract HTML/PHP logic to `components/about/about_team_component.php`.
   - Update `about/team.php` to `require_once` the components and load the assets.
24. **Verify `about/team.php`**
   - Run `php -l` on `about/team.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
25. **Refactor `student/header.php`**
   - Read `student/header.php` to determine components to extract.
   - Extract inline styles to `assets/css/student_header.css`.
   - Extract inline scripts to `assets/js/student_header.js`.
   - Extract HTML/PHP logic to `components/student/student_header_component.php`.
   - Update `student/header.php` to `require_once` the components and load the assets.
26. **Verify `student/header.php`**
   - Run `php -l` on `student/header.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
27. **Refactor `student/index.php`**
   - Read `student/index.php` to determine components to extract.
   - Extract inline styles to `assets/css/student_index.css`.
   - Extract inline scripts to `assets/js/student_index.js`.
   - Extract HTML/PHP logic to `components/student/student_index_component.php`.
   - Update `student/index.php` to `require_once` the components and load the assets.
28. **Verify `student/index.php`**
   - Run `php -l` on `student/index.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
29. **Refactor `student/services.php`**
   - Read `student/services.php` to determine components to extract.
   - Extract inline styles to `assets/css/student_services.css`.
   - Extract inline scripts to `assets/js/student_services.js`.
   - Extract HTML/PHP logic to `components/student/student_services_component.php`.
   - Update `student/services.php` to `require_once` the components and load the assets.
30. **Verify `student/services.php`**
   - Run `php -l` on `student/services.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
31. **Refactor `student/footer.php`**
   - Read `student/footer.php` to determine components to extract.
   - Extract inline styles to `assets/css/student_footer.css`.
   - Extract inline scripts to `assets/js/student_footer.js`.
   - Extract HTML/PHP logic to `components/student/student_footer_component.php`.
   - Update `student/footer.php` to `require_once` the components and load the assets.
32. **Verify `student/footer.php`**
   - Run `php -l` on `student/footer.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
33. **Refactor `admin/auth.php`**
   - Read `admin/auth.php` to determine components to extract.
   - Extract inline styles to `assets/css/admin_auth.css`.
   - Extract inline scripts to `assets/js/admin_auth.js`.
   - Extract HTML/PHP logic to `components/admin/admin_auth_component.php`.
   - Update `admin/auth.php` to `require_once` the components and load the assets.
34. **Verify `admin/auth.php`**
   - Run `php -l` on `admin/auth.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
35. **Refactor `admin/install.php`**
   - Read `admin/install.php` to determine components to extract.
   - Extract inline styles to `assets/css/admin_install.css`.
   - Extract inline scripts to `assets/js/admin_install.js`.
   - Extract HTML/PHP logic to `components/admin/admin_install_component.php`.
   - Update `admin/install.php` to `require_once` the components and load the assets.
36. **Verify `admin/install.php`**
   - Run `php -l` on `admin/install.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
37. **Refactor `admin/api.php`**
   - Read `admin/api.php` to determine components to extract.
   - Extract inline styles to `assets/css/admin_api.css`.
   - Extract inline scripts to `assets/js/admin_api.js`.
   - Extract HTML/PHP logic to `components/admin/admin_api_component.php`.
   - Update `admin/api.php` to `require_once` the components and load the assets.
38. **Verify `admin/api.php`**
   - Run `php -l` on `admin/api.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
39. **Refactor `admin/index.php`**
   - Read `admin/index.php` to determine components to extract.
   - Extract inline styles to `assets/css/admin_index.css`.
   - Extract inline scripts to `assets/js/admin_index.js`.
   - Extract HTML/PHP logic to `components/admin/admin_index_component.php`.
   - Update `admin/index.php` to `require_once` the components and load the assets.
40. **Verify `admin/index.php`**
   - Run `php -l` on `admin/index.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
41. **Refactor `wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php`**
   - Read `wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php` to determine components to extract.
   - Extract inline styles to `assets/css/dkhq_chat_ajax.css`.
   - Extract inline scripts to `assets/js/dkhq_chat_ajax.js`.
   - Extract HTML/PHP logic to `components/dkhq/dkhq_chat_ajax_component.php`.
   - Update `wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php` to `require_once` the components and load the assets.
42. **Verify `wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php`**
   - Run `php -l` on `wp/wp-content/plugins/dkhq-chat-ajax/dkhq-chat-ajax.php` and extracted components.
   - Start PHP server if not running and use curl to verify it returns 200 OK.
43. **Run all relevant tests to ensure the changes are correct and have not introduced regressions.**
   - Run the full test suite if available.
44. **Complete pre-commit steps**
   - Complete pre-commit steps to ensure proper testing, verification, review, and reflection are done.
