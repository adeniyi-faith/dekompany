## 2024-05-20 - Mobile Menu Accessibility Enhancements
**Learning:** Found multiple mobile navigation "hamburger" menus built using icon-only `<button>`s without `aria-label`s or proper visual focus states (some even used `focus:outline-none`). It seems to be a recurring pattern across the business, student, and about sector header components.
**Action:** Always ensure icon-only buttons receive `aria-label`, have their nested icons set to `aria-hidden="true"`, and use `focus-visible:ring-2` to provide clear keyboard focus states without stripping default focus styles incorrectly.
