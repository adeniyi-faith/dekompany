import os

with open('about/index.php', 'r', encoding='utf-8') as f:
    content = f.read()

# restore index.php logic
content = f"""<?php
$pageTitle = "The Firm";
$pageDesc = "De Kompany is an elite knowledge architecture firm.";
include 'header.php';
?>

<?php require_once __DIR__ . '/../components/about/about_index_component.php'; ?>

<?php include 'footer.php'; ?>"""

with open('about/index.php', 'w', encoding='utf-8') as f:
    f.write(content)
