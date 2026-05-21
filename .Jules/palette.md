## 2024-05-20 - Mobile Menu Accessibility Enhancements
**Learning:** Found multiple mobile navigation "hamburger" menus built using icon-only `<button>`s without `aria-label`s or proper visual focus states (some even used `focus:outline-none`). It seems to be a recurring pattern across the business, student, and about sector header components.
**Action:** Always ensure icon-only buttons receive `aria-label`, have their nested icons set to `aria-hidden="true"`, and use `focus-visible:ring-2` to provide clear keyboard focus states without stripping default focus styles incorrectly.
## 2024-05-20 - Icon-only buttons accessibility missing in footer
**Learning:** Found multiple icon-only buttons in the business footer component that were missing `aria-label` attributes and proper visual focus states (newsletter subscribe, chat trigger, chat close, and chat send). This pattern seems to extend beyond the headers into the footers.
**Action:** Consistently added `aria-label`, `aria-hidden="true"` on inner icons, and `focus-visible:ring-2 focus-visible:ring-blue-900 outline-none` classes to improve accessibility across these interactive elements.
