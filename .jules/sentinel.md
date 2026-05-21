
## 2025-02-27 - [File Upload RCE Vulnerability]
**Vulnerability:** The `admin/api.php` file upload endpoint was only verifying the `Content-Type` header (`$file['type']`) to determine if a file is safe.
**Learning:** Because the `Content-Type` header is fully user-controlled during an upload request, an attacker could upload a `.php` file by setting its content type to `image/jpeg`. This would result in the file being saved with a `.php` extension in the upload directory, enabling Remote Code Execution (RCE).
**Prevention:** Always validate both the actual MIME type of the file contents (using `mime_content_type` or `finfo`) AND enforce a strict whitelist for the file extension derived using `pathinfo`.
