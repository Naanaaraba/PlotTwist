<?php
include (dirname(__FILE__)) . "/../../functions/get_all_users_fxn.php";
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

        <!-- Dashboard Sections -->
        <section id="user-management">
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                    <?php get_all_users_fxn(); ?>
                </tbody>
            </table>
        </section>


    </main>


    <script src="../../assets/js/deleteUser.js"></script>
</body>

</html>