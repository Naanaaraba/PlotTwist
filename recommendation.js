document.addEventListener("DOMContentLoaded", function () {
  const refreshBtn = document.getElementById("refresh-btn");
  const recommendationsContent = document.getElementById(
    "recommendationsContent"
  );

  function refreshRecommendations() {
    // Show loading state
    const loadingDiv = document.createElement("div");
    loadingDiv.className = "loading";
    loadingDiv.innerHTML = `
      <div class="spinner"></div>
      <p>Refreshing your recommendations...</p>
    `;

    recommendationsContent.appendChild(loadingDiv);

    // Fetch recommendations
    fetch("../actions/recommendations_handler.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Network response was not ok: " + response.statusText
          );
        }
        return response.json(); // Directly parse JSON
      })
      .then((data) => {
        if (data.status === "success") {
          // Update the recommendation boxes
          console.log(document.querySelector(".recommendation-sections"));
          console.log(document.querySelector(".recommendation-box"));
          document.querySelector(
            ".recommendation-box:nth-child(1) > *:nth-child(n+3)"
          ).innerHTML = data.recommendations.personality.trim();

          document.querySelector(
            ".recommendation-box:nth-child(2) > *:nth-child(n+3)"
          ).innerHTML = data.recommendations.mood.trim();

          document.querySelector(
            ".recommendation-box:nth-child(3) > *:nth-child(n+3)"
          ).innerHTML = data.recommendations.reading_history.trim();

          document.querySelector(
            ".recommendation-box:nth-child(4) > *:nth-child(n+3)"
          ).innerHTML = data.recommendations.similar_books.trim();

          document.querySelector(
            ".recommendation-box:nth-child(5) > *:nth-child(n+3)"
          ).innerHTML = data.recommendations.collaborative.trim();

          loadingDiv.innerHTML = "";
        } else {
          throw new Error(data.message || "Unknown error occurred");
        }
      })
      .catch((error) => {
        // Create an error message element
        const errorMessage = document.createElement("div");
        errorMessage.className = "error-message";
        errorMessage.innerHTML = `
           <p>Failed to refresh recommendations</p>
           <small>${error.message}</small>
         `;
        recommendationsContent.appendChild(errorMessage); // Add error message

        console.error("Recommendation Refresh Error:", error);
      });
  }

  // Initial setup
  refreshBtn.addEventListener("click", refreshRecommendations);
});
