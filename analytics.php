<?php
include (dirname(__FILE__)) . "/../../functions/get_genre_fxn.php";
include (dirname(__FILE__)) . "/../../db/core.php";
isAdminLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Plot Twist</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>

<body>
    <!-- Sidebar -->
    <?php include (dirname(__FILE__)) . "/admin_header.php"; ?>

    <!-- Main Content -->
    <main>
        <!-- Header -->
        <header>
            <h1>Welcome, Admin</h1>
            <button onclick="document.location.href='../../actions/logout.php'" id="logout-btn">Logout</button>
        </header>

        <section id="analytics">
            <h2>Analytics Dashboard</h2>
            <canvas id="user-chart" width="400" height="200"></canvas>
        </section>


    </main>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for analytics -->
    <script src="../../assets/js/admin.js"></script>
</body>

</html>