const librarySearch = document.getElementById("discoverSearchBar");
const genreFilterSelect = document.querySelector("#genre_filter");
const moodFilterSelect = document.querySelector("#mood_filter");
const lengthFilterSelect = document.querySelector("#length_filter");
const booksGrid = document.getElementById("booksGrid");
const prevPageBtn = document.getElementById("prev-page");
const nextPageBtn = document.getElementById("next-page");
const pageNumberDisplay = document.getElementById("page-number");

let currentPage = 1;
let totalPages = 1; // Total pages will be set after fetching results

// // Fetch books from the backend and update the grid
// function getSearchResults() {
//   const query = librarySearch.value.trim();
//   const genre_filter = genreFilterSelect.value;
//   const mood_filter = moodFilterSelect.value;
//   const length_filter = lengthFilterSelect.value;

//   const xhttp = new XMLHttpRequest();
//   xhttp.onload = () => {
//     if (xhttp.status === 200) {
//       booksGrid.innerHTML = xhttp.responseText;

//       // Read total pages from hidden input
//       const totalPagesElement = document.getElementById("total-pages");
//       totalPages = totalPagesElement
//         ? parseInt(totalPagesElement.value, 10)
//         : 1;

//       console.log("Total Pages:", totalPages);

//       updatePaginationButtons();
//     } else {
//       booksGrid.innerHTML = "<p>Error fetching books. Please try again.</p>";
//     }
//   };

//   xhttp.open(
//     "GET",
//     `../actions/fetch_search_results_action.php?query=${encodeURIComponent(
//       query
//     )}&genre=${encodeURIComponent(genre_filter)}&mood=${encodeURIComponent(
//       mood_filter
//     )}&length=${encodeURIComponent(length_filter)}&page=${currentPage}`,
//     true
//   );
//   xhttp.send();

//   booksGrid.innerHTML = "<p>Loading...</p>";
// }

// Handle page navigation
function changePage(direction) {
  if (direction === "next" && currentPage < totalPages) {
    currentPage++;
  } else if (direction === "prev" && currentPage > 1) {
    currentPage--;
  }

  // Fetch search results with updated page
  getSearchResults();
}

// // Update pagination buttons' visibility
// function updatePaginationButtons() {
//   // Hide pagination buttons if no results or on a single page
//   if (totalPages <= 1 || booksGrid.innerHTML.includes("No books found")) {
//     prevPageBtn.style.display = "none";
//     nextPageBtn.style.display = "none";
//   } else {
//     prevPageBtn.style.display = "inline";
//     nextPageBtn.style.display = "inline";
//   }

//   // Disable/enable buttons based on current page
//   prevPageBtn.disabled = currentPage <= 1;
//   nextPageBtn.disabled = currentPage >= totalPages;

//   pageNumberDisplay.innerText = `Page ${currentPage}`;
// }

// Event listeners for search and filters
librarySearch.addEventListener("input", getSearchResults);
genreFilterSelect.addEventListener("change", getSearchResults);
moodFilterSelect.addEventListener("change", getSearchResults);
lengthFilterSelect.addEventListener("change", getSearchResults);

// Event listeners for page navigation
prevPageBtn.addEventListener("click", () => changePage("prev"));
nextPageBtn.addEventListener("click", () => changePage("next"));

// Initial search on page load
document.addEventListener("DOMContentLoaded", getSearchResults);

function getSearchResults() {
  const query = librarySearch.value.trim();
  const genre_filter = genreFilterSelect.value;
  const mood_filter = moodFilterSelect.value;
  const length_filter = lengthFilterSelect.value;

  const xhttp = new XMLHttpRequest();
  xhttp.onload = () => {
    if (xhttp.status === 200) {
      const response = JSON.parse(xhttp.responseText);

      // Clear existing books
      booksGrid.innerHTML = "";

      // Render books
      response.books.forEach((book) => {
        const bookCard = `
          <a href="reader.php?book=${book.book_file}&book_id=${book.id}" class="book-card">
            <div class="book-cover">
              <img src="${book.cover}" alt="Book Cover">
            </div>
            <div class="book-info">
              <h4>${book.title}</h4>
              <p>${book.author}</p>
            </div>
          </a>
        `;
        booksGrid.innerHTML += bookCard;
      });

      // Update pagination
      totalPages = response.totalPages;
      currentPage = response.currentPage;
      updatePaginationButtons();
    } else {
      booksGrid.innerHTML = "<p>Error fetching books. Please try again.</p>";
    }
  };

  xhttp.open(
    "GET",
    `../actions/fetch_search_results_action.php?query=${encodeURIComponent(
      query
    )}&genre=${encodeURIComponent(genre_filter)}&mood=${encodeURIComponent(
      mood_filter
    )}&length=${encodeURIComponent(length_filter)}&page=${currentPage}`,
    true
  );
  xhttp.send();
}

function updatePaginationButtons() {
  // Hide pagination if only one page
  if (totalPages <= 1) {
    prevPageBtn.style.display = "none";
    nextPageBtn.style.display = "none";
    return;
  }

  // Show pagination buttons
  prevPageBtn.style.display = "inline";
  nextPageBtn.style.display = "inline";

  // Disable/enable prev/next buttons
  prevPageBtn.disabled = currentPage <= 1;
  nextPageBtn.disabled = currentPage >= totalPages;

  // Update page number display
  pageNumberDisplay.innerText = `Page ${currentPage} of ${totalPages}`;
}
