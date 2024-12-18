const modal = document.getElementById("bookModal");
const closeButton = document.querySelector(".close-button");
const cancelButton = document.querySelector(".cancel-button");

// Function to open the modal
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = "flex";
  }
}

// Function to close a modal
function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.style.display = "none";
  }
}

// Close modal when clicking outside of modal content
document.addEventListener("click", (event) => {
  const openModals = document.querySelectorAll(".modal");
  openModals.forEach((modal) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});

// Add close button functionality to all modals
document.querySelectorAll(".modal .close-button").forEach((closeBtn) => {
  closeBtn.addEventListener("click", () => {
    const modal = closeBtn.closest(".modal");
    modal.style.display = "none";
  });
});

// Add cancel button functionality to all modals
document.querySelectorAll(".modal .cancel-button").forEach((cancelBtn) => {
  cancelBtn.addEventListener("click", () => {
    const modal = cancelBtn.closest(".modal");
    modal.style.display = "none";
  });
});

// Expose modal functions globally if needed
window.openModal = openModal;
window.closeModal = closeModal;

// add book
function addBook(data) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = () => {
    if (
      xhttp.DONE &&
      xhttp.status == 200 &&
      xhttp.responseText.trim() == "Book and cover added successfully!"
    ) {
      Swal.fire({
        title: "Success",
        text: xhttp.responseText,
        icon: "success",
        confirmButtonText: "Ok",
      }).then((response) => {
        window.location.reload();
      });
      return;
    }
    console.log("An error occurred", xhttp.responseText);
    Swal.fire({
      title: "Something went wrong!",
      text: xhttp.responseText,
      icon: "error",
      confirmButtonText: "Ok",
    });
  };
  xhttp.open("POST", "../../actions/add_book_action.php", true);
  xhttp.send(data);
}

// delete book
function deleteBook(book_id) {
  const xhttp = new XMLHttpRequest();
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      xhttp.onload = () => {
        if (xhttp.responseText.trim() == "Book deleted successfully!") {
          Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          }).then(() => {
            window.location.reload();
          });
        } else {
          Swal.fire({
            title: "Error!",
            text: "Failed to delete",
            icon: "error",
          });
        }
      };
      xhttp.open("POST", "../../actions/delete_book_action.php", true);
      xhttp.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );
      xhttp.send("deleteBookID=" + book_id);
    }
  });
}

const addBookBtn = document.getElementById("addBookBtn");
// const deleteBookBtn = document.getElementById("deleteBookBtn");

addBookBtn.addEventListener("click", () => {
  const form = document.getElementById("addBookForm");
  const formData = new FormData(form);
  formData.append("addBook", "");
  addBook(formData);
});

// Edit Book Function
function editBook(data) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = () => {
    if (
      xhttp.DONE &&
      xhttp.status == 200 &&
      xhttp.responseText.trim() == "Book updated successfully!"
    ) {
      Swal.fire({
        title: "Success",
        text: xhttp.responseText,
        icon: "success",
        confirmButtonText: "Ok",
      }).then((response) => {
        window.location.reload();
      });
      return;
    }
    console.log("An error occurred", xhttp.responseText);
    Swal.fire({
      title: "Something went wrong!",
      text: xhttp.responseText,
      icon: "error",
      confirmButtonText: "Ok",
    });
  };
  xhttp.open("POST", "../../actions/edit_book_action.php", true);
  xhttp.send(data);
}

// Function to populate edit modal
function populateEditModal(bookId) {
  console.log(bookId);
  const xhttp = new XMLHttpRequest();
  xhttp.onload = () => {
    if (xhttp.status === 200) {
      try {
        // Check if the response is valid JSON
        const book = JSON.parse(xhttp.responseText);

        // Check if the book data is complete and valid
        if (book && book.book_id) {
          console.log({ book });

          // Populate form fields
          document.querySelector("#editBookModal #book_id").value =
            book.book_id;
          document.querySelector("#editBookModal #title").value = book.title;
          document.querySelector("#editBookModal #author").value = book.author;
          document.querySelector("#editBookModal #publication_year").value =
            book.publication_year;
          document.querySelector("#editBookModal #isbn").value = book.isbn;
          document.querySelector("#editBookModal #description").value =
            book.description;

          // Set the correct genre option
          const genreSelect = document.querySelector(
            "#editBookModal #genre_filter"
          );
          for (let i = 0; i < genreSelect.options.length; i++) {
            if (genreSelect.options[i].value == book.genre_id) {
              genreSelect.selectedIndex = i;
              break;
            }
          }

          // Open the edit modal
          openModal("editBookModal");
        } else {
          // Handle the case where the book data is incomplete or invalid
          throw new Error("Invalid book data received");
        }
      } catch (error) {
        console.error("Error parsing book data:", error);
        Swal.fire({
          title: "Error",
          text: "Failed to load book details or received invalid data.",
          icon: "error",
        });
      }
    } else {
      // Handle cases where the server response is not 200
      console.error("Error fetching book data, status code:", xhttp.status);
      Swal.fire({
        title: "Error",
        text: "Failed to load book details. Server responded with an error.",
        icon: "error",
      });
    }
  };

  xhttp.onerror = () => {
    // Handle network errors
    console.error("Network error occurred while fetching book data.");
    Swal.fire({
      title: "Error",
      text: "Network error occurred while fetching book details.",
      icon: "error",
    });
  };

  xhttp.open(
    "GET",
    `../../actions/get_single_book_action.php?bookId=${bookId}`,
    true
  );
  xhttp.send();
}

// Event Listener for Edit Book Button in Edit Modal
document
  .querySelector("#editBookModal #editBookBtn")
  .addEventListener("click", () => {
    const form = document.getElementById("editBookForm");
    const formData = new FormData(form);
    formData.append("editBook", "");
    editBook(formData);
  });

// Add event listeners to dynamically created edit buttons
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("book-table").addEventListener("click", (event) => {
    const editButton = event.target.closest(".edit-book");
    if (editButton) {
      const bookId = editButton.getAttribute("data-book-id");
      populateEditModal(bookId);
    }

    const viewButton = event.target.closest(".view-book");
    if (viewButton) {
      const bookId = viewButton.getAttribute("data-book-id");
      viewBookDetails(bookId);
    }
  });
});

// Close Edit Modal
document
  .querySelector("#editBookModal .close-button")
  .addEventListener("click", () => {
    document.getElementById("editBookModal").style.display = "none";
  });

document
  .querySelector("#editBookModal .cancel-button")
  .addEventListener("click", () => {
    document.getElementById("editBookModal").style.display = "none";
  });

// Function to populate edit modal
function viewBookDetails(bookId) {
  console.log(bookId);
  const xhttp = new XMLHttpRequest();
  xhttp.onload = () => {
    if (xhttp.status == 200) {
      try {
        const book = JSON.parse(xhttp.responseText);

        // Populate form fields
        document.querySelector("#viewBookModal #view-title").innerText =
          book.title;
        document.querySelector("#viewBookModal #view-author").innerText =
          book.author;
        document.querySelector(
          "#viewBookModal #view-publication-year"
        ).innerText = book.publication_year;
        document.querySelector("#viewBookModal #view-isbn").innerText =
          book.isbn;
        document.querySelector("#viewBookModal #view-description").innerText =
          book.description;
        document.querySelector("#viewBookModal #view-genre").innerText =
          book.genre_name;

        // Open the edit modal
        openModal("viewBookModal");
      } catch (error) {
        console.error("Error parsing book data:", error);
        Swal.fire({
          title: "Error",
          text: "Failed to load book details",
          icon: "error",
        });
      }
    }
  };

  xhttp.open(
    "GET",
    `../../actions/get_single_book_action.php?bookId=${bookId}`,
    true
  );
  xhttp.send();
}
