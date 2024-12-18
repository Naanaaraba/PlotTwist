const fontSizeSelector = document.getElementById("font-size");

// Font Size Customization
fontSizeSelector.addEventListener("change", (e) => {
  //   console.log(textContent);
  const iframe = document.querySelector(".text-content iframe");
  if (iframe) {
    const iframeDocument =
      iframe.contentDocument || iframe.contentWindow.document;
    if (iframeDocument) {
      const iframeBody = iframeDocument.body;
      iframeBody.style.fontSize = `${e.target.value}px`;
    }
  }
  //   textContent.style.fontSize = `${fontSizeSelector.value}px`;
});

// Night/Day Mode Toggle
// themeToggle.addEventListener("click", () => {
//   document.body.classList.toggle("night-mode");
//   themeToggle.textContent = document.body.classList.contains("night-mode")
//     ? "☀️ Day Mode"
//     : "🌙 Night Mode";
// });

const themeToggle = document.getElementById("theme-toggle");
const toolbar = document.querySelector(".reader-content");

// const iframe = document.querySelector(".text-content iframe");

themeToggle.addEventListener("click", () => {
  const iframe = document.querySelector(".text-content iframe");
  // Toggle night mode class
  document.body.classList.toggle("night-mode");
  themeToggle.textContent = document.body.classList.contains("night-mode")
    ? "☀️ Day Mode"
    : "🌙 Night Mode";

  // If iframe exists, change text color based on night mode
  if (iframe) {
    const iframeDocument =
      iframe.contentDocument || iframe.contentWindow.document;
    if (iframeDocument) {
      const iframeBody = iframeDocument.body;
      if (document.body.classList.contains("night-mode")) {
        iframeBody.style.backgroundColor = "black";
        iframeBody.style.color = "white";
      } else {
        iframeBody.style.backgroundColor = "";
        iframeBody.style.color = "";
      }
    }
  } else {
    console.error("Iframe element not found");
  }
});

function getQueryParams() {
  // Get the full URL of the current page
  const currentUrl = window.location.href;

  // Create a URL object
  const url = new URL(currentUrl);

  // Access query parameters using URLSearchParams
  const params = new URLSearchParams(url.search);

  // Get individual parameters
  const bookPath = params.get("book");
  const bookID = params.get("book_id");

  // Log the values
  console.log("Book ID:", bookID);

  // Check if a parameter exists
  if (!params.has("book")) {
    console.log("bookId exists!");
    return;
  }

  return { bookPath, bookID };
}

// Function to handle the reading progress (start or update)
function handleReadingProgress(
  bookId,
  action,
  current_page_location,
  progress
) {
  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Prepare the URL with query parameters
  var url =
    "../actions/record_reading_progress_action.php?book_id=" +
    bookId +
    "&action=" +
    action +
    "&location=" +
    current_page_location +
    "&progress=" +
    progress;

  // Configure the request
  xhr.open("GET", url, true);

  // Set up a function to handle the response
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      // When the request is complete
      if (xhr.status === 200) {
        // If the request was successful
        var data = JSON.parse(xhr.responseText); // Parse the JSON response
        if (data.status === "success") {
          console.log("started");
        } else {
          console.log(data.message); // Show error message
        }
      } else {
        console.log("An error occurred. Please try again."); // Handle any error from the server
      }
    }
  };

  // Send the request
  xhr.send();
}

document.addEventListener("DOMContentLoaded", () => {
  // getQueryParams();
  // const filePath = "../assets/book_uploads/white-spiral-staircase.epub";
  const filePath = getQueryParams();
  console.log(filePath);
  // Book and Rendition Setup
  const book = ePub(filePath.bookPath);
  const rendition = book.renderTo("text-content", {
    width: "100%",
    height: "100%",
  });

  // Navigation Buttons
  const prevButton = document.getElementById("prev-page");
  const nextButton = document.getElementById("next-page");
  const tocList = document.getElementById("chapter-list");
  const bookmarksList = document.getElementById("bookmarks-list");
  const addBookmarkButton = document.getElementById("add-bookmark");
  const progressBar = document.getElementById("progress-bar");
  const pageNumber = document.getElementById("page-number");

  // Bookmarks Management
  const bookmarks = JSON.parse(localStorage.getItem("epub-bookmarks") || "[]");

  function saveBookmarks() {
    localStorage.setItem("epub-bookmarks", JSON.stringify(bookmarks));
    renderBookmarks();
  }

  function renderBookmarks() {
    bookmarksList.innerHTML = "";
    bookmarks.forEach((bookmark, index) => {
      const li = document.createElement("li");
      li.innerHTML = `
                <span>${bookmark.title}</span>
                <button onclick="goToBookmark(${index})">Go</button>
                <button onclick="removeBookmark(${index})">Remove</button>
            `;
      bookmarksList.appendChild(li);
    });
  }

  // Global functions for bookmark interactions
  window.goToBookmark = (index) => {
    const bookmark = bookmarks[index];
    console.log(bookmark);
    rendition.display(bookmark.cfi);
  };

  window.removeBookmark = (index) => {
    bookmarks.splice(index, 1);
    saveBookmarks();
  };

  let isStarted = false;

  // Book Loading and Setup
  book.ready.then(() => {
    // Table of Contents
    book.loaded.navigation.then((navigation) => {
      navigation.toc.forEach((chapter) => {
        const li = document.createElement("li");
        li.textContent = chapter.label;
        li.onclick = (e) => {
          const allItems = tocList.querySelectorAll("li");
          allItems.forEach((item) => item.classList.remove("active"));
          rendition.display(chapter.href);
          e.target.classList.add("active");
        };

        tocList.appendChild(li);
      });
    });

    rendition.on("relocated", (location) => {
      console.log({ location });
      pageNumber.innerText = `Page ${
        location.start.location < 0 ? 0 : location.start.location
      }`;
      updateProgress();
      // change status of book to currently reading
    });

    book.locations
      .generate(1600)
      .then(() => {
        console.log("Locations generated successfully:", book.locations);

        rendition.on("relocated", (location) => {
          console.log("Relocated event triggered:", location);

          // Calculate progress
          const progress =
            book.locations.percentageFromCfi(location.start.cfi) || 0;
          const progressPercent = Math.round(progress * 100);
          // console.log("Progress Percent:", progressPercent);

          // Trigger the "start" action only once
          if (!isStarted) {
            handleReadingProgress(
              filePath.bookID,
              "start",
              location.start.cfi,
              progressPercent
            );
            isStarted = true; // Set flag to true after the first "start" action
          }

          // Update UI
          progressBar.value = progressPercent;
          document.getElementById(
            "progress-percent"
          ).textContent = `${progressPercent}%`;
        });
      })
      .catch((err) => {
        console.error("Error generating locations:", err);
      });

    // Initial Display
    rendition.display();
  });

  // Navigation Event Listeners
  prevButton.addEventListener("click", () => rendition.prev());
  nextButton.addEventListener("click", () => {
    rendition.next();
    updateProgress();
  });

  // Bookmark Functionality
  addBookmarkButton.addEventListener("click", () => {
    console.log(rendition.location);
    bookmarks.push({
      title: `Page ${rendition.location.start.location}`,
      cfi: rendition.location.start.cfi,
      pageNum: rendition.location.start.index,
    });
    saveBookmarks();
  });

  // Error Handling
  rendition.on("error", (error) => {
    console.error("Rendering error:", error);
  });

  // Initial Render
  renderBookmarks();

  function updateProgress() {
    // Get the current location after moving to the next page
    const location = rendition.currentLocation();

    // Calculate progress
    const progress = book.locations.percentageFromCfi(location.start.cfi) || 0;
    const progressPercent = Math.round(progress * 100);

    // Trigger the "update" action for reading progress
    handleReadingProgress(
      filePath.bookID,
      "update",
      location.start.cfi,
      progressPercent
    );
  }
});
