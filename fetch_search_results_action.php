<?php

require_once(dirname(__FILE__) . "/../db/db_connection.php");


if (isset($_GET["query"], $_GET["filter"])) {
    $search_term = isset($_GET['query']) ? trim($_GET['query']) : '';
    $filter = isset($_GET['filter']) ? trim($_GET['filter']) : 'all';

    // Sanitize inputs
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $filter = mysqli_real_escape_string($conn, $filter);

    // Build SQL query with more precise joins and grouping
    $sql = "SELECT books.book_id, books.title, books.author, books.cover_file, books.book_file,
               genres.genre_name, 
               MAX(COALESCE(reading_progress.progress_count, 0)) AS progress_count
            FROM books
            JOIN genres ON books.genre_id = genres.genre_id
            LEFT JOIN reading_progress ON books.book_id = reading_progress.book_id
            LEFT JOIN reading_status ON reading_progress.status = reading_status.status_id
            WHERE books.title LIKE '%$search_term%'";

    // Apply filter conditions
    if ($filter === "reading") {
        $sql .= " AND reading_status.status_id = 1";
    } elseif ($filter === "completed") {
        $sql .= " AND reading_status.status_id = 2";
    } elseif ($filter === "bookmarked") {
        $sql .= " AND reading_status.status_id = 3";
    }

    // Group by book to prevent duplicates
    $sql .= " GROUP BY books.book_id, books.title, books.author, books.cover_file, genres.genre_name";

    $result = mysqli_query($conn, $sql);

    // Output book cards
    if ($result && mysqli_num_rows($result) > 0) {
        while ($book = mysqli_fetch_assoc($result)) {
            $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
            echo '<a href="reader.php?book=' . $book["book_file"] . '&book_id=' . $book["book_id"] . '" class="book-card">
                    <div class="book-cover">
                        <img src="' . $book_image . '" alt="Book Cover">
                        <div class="book-progress">
                            <div class="progress-bar" style="width: 65%"></div>
                        </div>
                    </div>
                    <div class="book-info">
                        <h4>' . $book["title"] . '</h4>
                        <p>' . $book["author"] . '</p>
                        <div class="book-actions">
                            <button class="bookmark-btn">
                                <i class="bx bx-bookmark"></i>
                            </button>
                            <span class="progress-text">' . $book["progress_count"] . '%</span>
                        </div>
                    </div>
                </a>';
        }
    } else {
        echo '<p>No books found matching your search criteria.</p>';
    }
}

if (isset($_GET["query"], $_GET["mood"], $_GET["length"], $_GET["genre"])) {
    header('Content-Type: application/json');
    $response = ['books' => [], 'totalPages' => 1];

    $search_term = (isset($_GET['query']) && trim($_GET['query']) !== '') ? trim($_GET['query']) : '';
    $mood = (isset($_GET['mood']) && trim($_GET['mood']) !== '') ? trim($_GET['mood']) : 'all';
    $length = (isset($_GET['length']) && trim($_GET['length']) !== '') ? trim($_GET['length']) : 'all';
    $genre = (isset($_GET['genre']) && trim($_GET['genre']) !== '') ? trim($_GET['genre']) : 'all';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Define how many books per page
    $books_per_page = 10;
    $offset = ($page - 1) * $books_per_page;

    // Sanitize inputs
    $search_term = mysqli_real_escape_string($conn, $search_term);
    $mood = mysqli_real_escape_string($conn, $mood);
    $length = mysqli_real_escape_string($conn, $length);
    $genre = mysqli_real_escape_string($conn, $genre);

    // Count total books
    $count_sql = "SELECT COUNT(DISTINCT books.book_id) AS total_books
    FROM books
    JOIN genres ON books.genre_id = genres.genre_id
    WHERE books.title LIKE '%$search_term%'";

    // Apply filters to count query
    if ($genre !== "all") {
        $count_sql .= " AND books.genre_id = '$genre'";
    }

    if ($mood !== "all") {
        $count_sql .= " AND books.mood_id = '$mood'";
    }

    if ($length !== "all") {
        if ($length === '1') {
            $count_sql .= " AND books.page_count < 200";
        } elseif ($length === '2') {
            $count_sql .= " AND books.page_count BETWEEN 200 AND 400";
        } elseif ($length === '3') {
            $count_sql .= " AND books.page_count > 400";
        }
    }

    $count_result = mysqli_query($conn, $count_sql);
    $total_books = mysqli_fetch_assoc($count_result)['total_books'];
    $total_pages = ceil($total_books / $books_per_page);

    // Modify main query to fetch books
    $sql = "SELECT DISTINCT books.book_id, books.title, books.author, books.book_file, books.cover_file
    FROM books
    JOIN genres ON books.genre_id = genres.genre_id
    WHERE books.title LIKE '%$search_term%'";

    // Apply same filters to main query
    if ($genre !== "all") {
        $sql .= " AND books.genre_id = '$genre'";
    }

    if ($mood !== "all") {
        $sql .= " AND books.mood_id = '$mood'";
    }

    if ($length !== "all") {
        if ($length === '1') {
            $sql .= " AND books.page_count < 200";
        } elseif ($length === '2') {
            $sql .= " AND books.page_count BETWEEN 200 AND 400";
        } elseif ($length === '3') {
            $sql .= " AND books.page_count > 400";
        }
    }

    $sql .= " LIMIT $books_per_page OFFSET $offset";

    $result = mysqli_query($conn, $sql);

    // Collect book results
    $books = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($book = mysqli_fetch_assoc($result)) {
            $book_image = !empty($book["cover_file"]) ? $book["cover_file"] : "../assets/images/bookart.jpg";
            $books[] = [
                'id' => $book["book_id"],
                'title' => $book["title"],
                'author' => $book["author"],
                'book_file' => $book["book_file"],
                'cover' => $book_image
            ];
        }
    }

    // Prepare response
    $response = [
        'books' => $books,
        'totalPages' => $total_pages,
        'currentPage' => $page
    ];

    echo json_encode($response);
}
