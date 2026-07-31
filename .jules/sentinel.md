## 2026-05-20 - [Fix Insecure File Upload in Media Upload Endpoint]
**Vulnerability:** The `admin/api.php` file's `upload_media` action only validated the `Content-Type` header (`$_FILES['file']['type']`) to prevent malicious file uploads. Since this header is easily spoofed, attackers could upload `.php` files (RCE) by masquerading them as `image/jpeg`.
**Learning:** Do not rely exclusively on client-provided headers like MIME type for file upload security. Always validate the actual file extension extracted from the filename.
**Prevention:** Implement a strict whitelist of allowed file extensions using `pathinfo($filename, PATHINFO_EXTENSION)` and `strtolower()`, and enforce it server-side.
