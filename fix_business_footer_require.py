import os

with open('business/footer.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Replace the manual wp_load_paths check with a simpler require_once that doesn't trigger the error if we ensure wp-load exists.
# Actually, the error is because we deleted wp-load.php after we ran index.php test, so the mock is gone.
# We should recreate wp-load.php mock permanently for the sandbox, or at least during tests.
