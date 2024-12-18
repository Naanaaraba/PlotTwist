<?php
include (dirname(__FILE__)) . "/../db/core.php";
include (dirname(__FILE__)) . "/../functions/get_genre_fxn.php";
include (dirname(__FILE__)) . "/../functions/get_mood_fxn.php";
include (dirname(__FILE__)) . "/../functions/get_book_length_fxn.php";
include (dirname(__FILE__)) . "/../functions/display_discover_books_fxn.php";
isLoggedIn();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search & Discovery | Plot Twist</title>
    <link rel="stylesheet" href="../assets/css/book_card.css">
    <link rel="stylesheet" href="../assets/css/discover.css">
</head>

<body>
    <!-- Header -->
    <?php
    include (dirname(__FILE__)) . "/../header.php";
    ?>

    <!-- Search Container -->
    <main>
        <div class="search-container">
            <h1>Search & Discover Books</h1>
            <!-- Search Bar with Autocomplete -->
            <div class="search-bar">
                <input
                    type="text"
                    id="discoverSearchBar"
                    placeholder="Search for books, authors, or genres..."
                    autocomplete="off">
                <ul id="autocomplete-list" class="autocomplete-list"></ul>
            </div>

            <!-- Filters -->
            <div class="filters">
                <?php get_genre_fxn() ?>

                <?php get_mood_fxn() ?>

                <?php get_book_length_fxn() ?>

                <select id="sort-filter">
                    <option value="relevance">Sort By: Relevance</option>
                    <option value="popularity">Popularity</option>
                    <option value="rating">Rating</option>
                    <option value="newest">Newest</option>
                </select>
            </div>
        </div>

        <!-- Search Results -->
        <div id="search-results" class="results-container">
            <h2>Search Results</h2>
            <div id="booksGrid" class="books-grid">
                <?php  ?>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <button id="prev-page">Previous</button>
                <span id="page-number">Page 1</span>
                <button id="next-page">Next</button>
            </div>

        </div>
    </main>
    <script src="../assets/js/discover.js"></script>
</body>

</html>