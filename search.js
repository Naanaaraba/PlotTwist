const librarySearch = document.getElementById("librarySearchBar");
const filterSelect = document.querySelector(".filter-select");
const booksGrid = document.getElementById("booksGrid");

// Fetch books from the backend and update the grid
function getSearchResults() {
  const query = librarySearch.value.trim(); // Search term
  const filter = filterSelect.value; // Selected filter

  // AJAX request to fetch filtered books
  const xhttp = new XMLHttpRequest();
  xhttp.onload = () => {
    if (xhttp.status === 200) {
      booksGrid.innerHTML = xhttp.responseText; // Update the grid
    } else {
      booksGrid.innerHTML = "<p>Error fetching books. Please try again.</p>";
    }
  };

  xhttp.onerror = () => {
    booksGrid.innerHTML =
      "<p>Network error occurred. Please try again later.</p>";
  };

  xhttp.open(
    "GET",
    `../actions/fetch_search_results_action.php?query=${encodeURIComponent(
      query
    )}&filter=${encodeURIComponent(filter)}`,
    true
  );
  xhttp.send();

  // Optional: Add a loading indicator
  booksGrid.innerHTML = "<p>Loading...</p>";
}

// Add event listeners for the search input and filter dropdown
librarySearch.addEventListener("input", getSearchResults);
filterSelect.addEventListener("change", getSearchResults);
document.addEventListener("DOMContentLoaded", getSearchResults);
