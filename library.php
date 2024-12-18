<?php
include (dirname(__FILE__)) . "/../db/core.php";
include (dirname(__FILE__)) . "/../functions/display_library_books_fxn.php";
isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reading Interface | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/library.css">
    <link rel="stylesheet" href="../assets/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="../assets/css/book_card.css">

</head>

<body>
    <!-- Header -->
    <?php include (dirname(__FILE__)) . "/../header.php"; ?>

    <main>
        <section class="library-section">
            <div class="library-header">
                <h1>My Library</h1>
                <div class="library-filters">
                    <input type="search" id="librarySearchBar" placeholder="Search books..." class="search-input">
                    <select class="filter-select">
                        <option value="all">All Books</option>
                        <option value="reading">Currently Reading</option>
                        <option value="completed">Completed</option>
                        <option value="bookmarked">Bookmarked</option>
                    </select>
                </div>
            </div>

            <div id="booksGrid" class="books-grid">
                <!-- Example Book Card -->

            </div>
        </section>
    </main>

    <script src="../assets/js/search.js"></script>
</body>

</html>