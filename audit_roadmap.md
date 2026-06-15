# Comprehensive Audit & Refactoring Plan: De Kompany Architecture

This document breaks down the required work into actionable phases based on the audit of the existing De Kompany codebase.

## Component-by-Component Audit Findings

### 1. The Core Application Boot & Admin API (`admin/`)
*   **`admin/auth.php`, `admin/install.php`, `admin/api.php`**
    *   **Status:** Broken/Fatal Error on execution.
    *   **What needs fixing:** The path resolution logic attempts to `require_once` WordPress's `wp-load.php`. In the current deployment structure, it fails, causing a 500 Fatal Error.
    *   **Dependencies:** Needs a correct path to a valid WordPress installation, or a robust mock of WP functions (e.g. `sanitize_text_field`, `$wpdb`) if WP is not meant to be present in this environment.
    *   **Architecture Requirements:** The `dkhq_takeovers` table is created dynamically in `api.php` via an `admin_init` hook, but the rest of the tables are in `install.php`. This is inconsistent and should be centralized.

### 2. Homepage & Concierge App (`index.php`, `assets/js/index.js`, `components/index/index_component.php`)
*   **Status:** Partially functional UI, deeply broken backend connection.
*   **What needs fixing:**
    *   The `index.js` script tries to hit `ADMIN_API = "/wp/admin/api.php"`. The correct path is `/admin/api.php`. Because of this (and the `wp-load.php` error), chat logging and lead capture fail silently or throw errors in the console.
    *   **"Browse Departments" Buttons:** The Academic and Business sector buttons route correctly, but the "Innovation Sector" button routes to `/innovation`, which does not exist (404 error).

### 3. Business Sector (`business/`)
*   **`business/index.php`**
    *   **Status:** Partially refactored, monolithic code remaining.
    *   **What needs fixing:** The file attempts to use components, but still contains a massive `main` section.
    *   **"Start Strategy Session" Button:** `onclick="toggleChat()"` works to open the UI, but the underlying JS chat connection is broken (same API issue as homepage).
    *   **"Our Portfolio" Button:** `href="#portfolio"` - anchor exists, but page layout needs review to ensure smooth scrolling.
*   **`business/header.php`**
    *   **Status:** Needs refactoring.
    *   **What needs fixing:** Has navigation links (`href="#about-us"`, `#business-expertise`, etc.) that rely on anchors on the index page. These need to be validated to ensure sections actually have these IDs.
*   **`business/footer.php`**
    *   **Status:** Monolithic, broken `wp-load.php` require.
    *   **What needs fixing:** The file attempts to `require_once` `wp-load.php` to fetch API keys, causing a fatal error (see `business/error_log`). It needs to be refactored into a component (`components/business/business_footer_component.php`), and the API key fetching logic needs to be secured or handled gracefully if WP isn't loaded.
*   **`components/business/business_index_component.php` & `business_footer_component.php`**
    *   **Status:** Placeholders.
    *   **What needs fixing:** Both files exist but are 0 bytes. The logic from `business/index.php` and `business/footer.php` needs to be correctly extracted into these files, separating concerns (HTML vs inline CSS/JS).

### 4. Academic/Student Sector (`student/`)
*   **`student/index.php`**
    *   **Status:** Monolithic, contains placeholders.
    *   **What needs fixing:** Needs full extraction to `components/student/student_index_component.php`.
    *   **"Explore Resources" / "Read Article" Buttons:** There are buttons with `href="#"`. These need real URLs or need to be hidden until the content exists.
*   **`student/header.php`**
    *   **Status:** Monolithic.
    *   **What needs fixing:** Needs extraction to `components/student/student_header_component.php`.
*   **`student/footer.php`**
    *   **Status:** Monolithic, contains placeholders.
    *   **What needs fixing:** Contains social links with `href="#"`. These must be connected to actual social profiles or removed. Needs extraction to `components/student/student_footer_component.php`.

### 5. Innovation Sector (`innovation/`)
*   **Status:** Missing entirely.
*   **What needs fixing:** The entire directory, routing, and UI components need to be built from scratch following the pattern established in the Business and Academic sectors.

---

## Phase 1: Authentication & Infrastructure Stabilization

**What is being built:**
A resilient, predictable authentication and boot process for the custom API endpoints and admin scripts. This involves fixing the path resolution in `admin/api.php`, `admin/auth.php`, and `admin/install.php` so they execute without fatal errors. It also involves correcting the API endpoint paths in the frontend JavaScript.

**Why it belongs at this stage:**
The core of the system (APIs, logging, admin panel) relies on WordPress functions. Until the API layer functions correctly and returns 200/JSON instead of 500/Fatal Errors, no dynamic features (chat, leads, admin dashboard) can be tested or completed.

**Inputs and dependencies:**
- Current `admin/auth.php`, `admin/install.php`, `admin/api.php` files.
- Frontend JS files like `assets/js/index.js`.

**Expected outputs:**
- Calling `/admin/api.php?action=get_stats` returns a valid JSON response (even if empty) instead of a 500 error.
- The `assets/js/index.js` points to `ADMIN_API = "/admin/api.php"` instead of `"/wp/admin/api.php"`.
- The admin dashboard loads without breaking.

**Architectural constraints:**
- If this is a standalone environment without WordPress, a lightweight WordPress function mock layer (e.g., stubbing `sanitize_text_field`, `$wpdb`, etc.) must be created *carefully and completely* to allow the custom tables and logic to function. If WordPress is intended to be here, the paths must be corrected to point to the actual install.

**Edge cases and failure states:**
- Graceful error handling in the JS if the API is unreachable.

---

## Phase 2: Complete Component Extraction & Modularization

**What is being built:**
The systematic extraction of inline styles, inline scripts, and HTML/PHP logic from the remaining monolithic files into the designated `components/`, `assets/css/`, and `assets/js/` directories.

**Why it belongs at this stage:**
The previous refactoring effort was partially completed (e.g., `components/business/business_mochelle_component.php` exists, but `components/business/business_index_component.php` and `business_footer_component.php` are empty). A clean, modular architecture is essential before adding new features or fixing logical flows.

**Inputs and dependencies:**
- Phase 1 (Authentication/Infrastructure Stabilization) should be complete to ensure backend calls work.
- Existing monolithic files (e.g., `business/index.php`, `business/footer.php`, `about/index.php`, `student/index.php`, `student/footer.php`).

**Expected outputs:**
- All pages use `require_once` to load their main structural components.
- No inline `<style>` or `<script>` tags exist in the main PHP files.
- `assets/css/` and `assets/js/` contain all the respective styles and logic.
- The `business_index_component.php` and `business_footer_component.php` files are fully populated.

**Architectural constraints:**
- Follow the established naming convention: `components/{sector}/{name}_component.php`.
- Ensure PHP variables needed by external JS are passed via a global `window.DKHQ_CONFIG` object (as partially implemented in scripts like `fix_business_footer.py`).

**Edge cases and failure states:**
- Missing variables in the global config object could break JavaScript logic; ensure all necessary PHP variables are securely injected before the external scripts load.

---

## Phase 3: "Innovation Sector" Implementation

**What is being built:**
The missing "Innovation Sector" pages and routing. The index page mentions routing tags for it (`[ROUTE_INNOVATION]`), but the folder and files do not exist.

**Why it belongs at this stage:**
The UI advertises the Innovation Sector as a core offering, and the AI concierge is programmed to route users there. Its absence represents a broken user journey. This should be built cleanly using the components pattern established in Phase 2.

**Inputs and dependencies:**
- Phase 2 (Modularization) so the new section can be built using the clean component pattern.
- The design language established in the `business/` and `student/` sectors.

**Expected outputs:**
- An `/innovation/` directory containing `index.php`, `header.php`, and `footer.php`.
- Corresponding component files in `components/innovation/`.
- The UI properly routes users to this sector without 404 errors.

**Architectural constraints:**
- Must follow the same structural and visual patterns as the existing sectors (hero section, service grid, AI concierge integration).

**Edge cases and failure states:**
- If a user requests a specific innovation service, the AI should correctly categorize and route them to the specific section or page within the new directory.

---

## Phase 4: AI Concierge & Chat Architecture Solidification

**What is being built:**
A comprehensive audit and fix of the live chat/takeover system. The admin interface has buttons for live takeovers, but the backend polling (`check_takeover`) and state management need to be verified and hardened to ensure messages aren't lost during handoffs.

**Why it belongs at this stage:**
The platform heavily relies on the AI concierge for lead capture and routing. The "Live Takeover" feature is critical for the concierge model. Once the API is stable (Phase 1), this feature needs to be fully tested and integrated.

**Inputs and dependencies:**
- Phase 1 (Working APIs and WordPress DB connections).
- The `admin/api.php` and `wp-content/plugins/dkhq-chat-ajax/` logic.

**Expected outputs:**
- A seamless transition when an admin "takes over" a chat: the AI stops responding, and human messages are delivered in real-time to the user.
- Clear UI indicators for the user that they are now speaking with a human.
- Proper handling when the admin ends the takeover (handing back to the AI).

**Architectural constraints:**
- Must use efficient polling or Server-Sent Events (SSE) to minimize server load.

**Edge cases and failure states:**
- Network disconnects during a live takeover.
- Two admins attempting to take over the same session.

---

## Phase 5: UI/UX & Functional Polish

**What is being built:**
Wiring up all placeholder links (e.g., `#` hrefs in the headers/footers), ensuring empty states in the admin panel are visually consistent, and verifying form submissions (like lead capture) have proper loading and success states.

**Why it belongs at this stage:**
This is the final polish step. The core architecture, new features, and integrations are complete. This phase ensures the application feels production-ready.

**Inputs and dependencies:**
- All previous phases.

**Expected outputs:**
- No dead links (`href="#"`). All navigation links point to the correct sections or pages.
- Smooth transitions and feedback for all user actions (e.g., submitting a contact form, sending a chat message).
- Consistent error handling in the UI if an API request fails.

**Architectural constraints:**
- Adhere to the existing Tailwind CSS design system.

**Edge cases and failure states:**
- Forms submitted with missing or invalid data should provide clear, inline validation errors.
