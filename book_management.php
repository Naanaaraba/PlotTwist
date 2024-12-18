<?php
include (dirname(__FILE__)) . "/../../functions/get_genre_fxn.php";
include (dirname(__FILE__)) . "/../../functions/get_mood_fxn.php";
include (dirname(__FILE__)) . "/../../functions/get_book_length_fxn.php";
include (dirname(__FILE__)) . "/../../functions/get_all_books_fxn.php";
include (dirname(__FILE__)) . "/../../functions/get_single_book_fxn.php";
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
    <link rel="stylesheet" href="../../assets/css/sweetalert2.min.css">
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.3s ease;
        }

        .close-button {
            float: right;
            font-size: 18px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-actions .cancel-button {
            background: #ccc;
            color: #333;
        }

        .form-actions button[type="submit"] {
            background: #007bff;
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
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

        <section id="book-management">
            <h2>Book Management</h2>
            <button onclick="openModal('bookModal')">Add New Book</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Description</th>
                        <th>Genre</th>
                        <th>Publication Year</th>
                        <th>ISBN</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="book-table">
                    <?php get_all_books_fxn(); ?>
                </tbody>
            </table>
        </section>


        <div id="bookModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Add Book</h2>
                <form id="addBookForm">

                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <!-- Author ID -->
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" required>
                    </div>

                    <!-- Genre ID -->
                    <div class="form-group">
                        <label for="genre_id">Genre</label>
                        <?php get_genre_fxn(); ?>
                    </div>

                    <!-- Mood ID -->
                    <div class="form-group">
                        <label for="genre_id">Mood</label>
                        <?php get_mood_fxn(); ?>
                    </div>

                    <!-- Book Length ID -->
                    <div class="form-group">
                        <label for="length_id">Book Length</label>
                        <?php get_book_length_fxn(); ?>
                    </div>

                    <!-- Publication Year -->
                    <div class="form-group">
                        <label for="page_count">Page Count</label>
                        <input type="number" id="page_count" name="page_count" required>
                    </div>

                    <!-- Publication Year -->
                    <div class="form-group">
                        <label for="publication_year">Publication Year</label>
                        <input type="number" id="publication_year" name="publication_year" min="1000" max="9999" required>
                    </div>

                    <!-- ISBN -->
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" maxlength="13" id="isbn" name="isbn" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <!-- Cover File -->
                    <div class="form-group">
                        <label for="cover_file">Book Cover</label>
                        <input type="file" id="cover_file" name="cover_file" accept=".jpg,.jpeg,.png" required>
                    </div>

                    <!-- Book File -->
                    <div class="form-group">
                        <label for="book_file">Book File</label>
                        <input type="file" id="book_file" name="book_file" accept=".pdf,.epub,.mobi" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="button" id="addBookBtn" name="addBook">Save Book</button>
                        <button type="button" class="cancel-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <div id="viewBookModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Book Details</h2>

                <!-- Book Title -->
                <div class="form-group">
                    <label for="view-title">Title:</label>
                    <p id="view-title" class="details-text"></p>
                </div>

                <!-- Author -->
                <div class="form-group">
                    <label for="view-author">Author:</label>
                    <p id="view-author" class="details-text"></p>
                </div>

                <!-- Genre -->
                <div class="form-group">
                    <label for="view-genre">Genre:</label>
                    <p id="view-genre" class="details-text"></p>
                </div>

                <!-- Publication Year -->
                <div class="form-group">
                    <label for="view-publication-year">Publication Year:</label>
                    <p id="view-publication-year" class="details-text"></p>
                </div>

                <!-- ISBN -->
                <div class="form-group">
                    <label for="view-isbn">ISBN:</label>
                    <p id="view-isbn" class="details-text"></p>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="view-description">Description:</label>
                    <p id="view-description" class="details-text"></p>
                </div>

                <!-- Cover File -->
                <div class="form-group">
                    <label for="view-book-file">Cover File:</label>
                    <a id="view-book-file" href="#" target="_blank">Download</a>
                </div>


                <!-- Book File -->
                <div class="form-group">
                    <label for="view-book-file">Book File:</label>
                    <a id="view-book-file" href="#" target="_blank">Download</a>
                </div>

                <!-- Close Button -->
                <div class="form-actions">
                    <button type="button" class="cancel-button">Close</button>
                </div>
            </div>
        </div>


        <div id="editBookModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Edit Book</h2>
                <form id="editBookForm">
                    <input type="hidden" id="book_id" name="book_id">

                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <!-- Author ID -->
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" required>
                    </div>

                    <!-- Genre ID -->
                    <div class="form-group">
                        <label for="genre_id">Genre</label>
                        <?php get_genre_fxn(); ?>
                    </div>

                    <!-- Publication Year -->
                    <div class="form-group">
                        <label for="publication_year">Publication Year</label>
                        <input type="number" id="publication_year" name="publication_year" min="1000" max="9999" required>
                    </div>

                    <!-- ISBN -->
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" maxlength="13" id="isbn" name="isbn" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <!-- Cover File -->
                    <div class="form-group">
                        <label for="cover_file">Book Cover</label>
                        <input type="file" id="cover_file" name="cover_file" accept=".jpg,.jpeg,.png" required>
                    </div>

                    <!-- Book File -->
                    <div class="form-group">
                        <label for="book_file">Book File</label>
                        <input type="file" id="book_file" name="book_file" accept=".pdf,.epub,.mobi" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-actions">
                        <button type="button" id="editBookBtn" name="addBook">Save Book</button>
                        <button type="button" class="cancel-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </main>

    <script src="../../assets/js/sweetalert2.min.js"></script>
    <script src=" ../../assets/js/book.js"></script>
</body>

</html>