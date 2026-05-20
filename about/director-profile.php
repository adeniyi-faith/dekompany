<?php
$pageTitle = "Director's Profile";
$pageDesc = "Profile of the Managing Director, De Kompany.";
include 'header.php';
?>

<link rel="stylesheet" href="/assets/css/about_director.css">

<?php require_once __DIR__ . '/../components/about/about_director_component.php'; ?>

<script src="/assets/js/about_director.js"></script>

<?php include 'footer.php'; ?>