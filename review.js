const stars = document.querySelector(".star-rating");
let selectedRating = 0;

stars.addEventListener("click", (e) => {
    const starElements = stars.textContent.split("").map((char, index) => {
        return index <= e.target.dataset.index ? "★" : "☆";
    });
    stars.textContent = starElements.join("");
    document.getElementById("rating").value = starElements.filter((star) => star === "★").length;
});

// Helpful/Unhelpful Vote System
document.querySelectorAll(".vote-btn").forEach((button) => {
    button.addEventListener("click", () => {
        const voteType = button.dataset.vote;
        let count = parseInt(button.textContent.match(/\d+/)[0]) || 0;
        count++;
        button.textContent = voteType === "helpful" ? `👍 Helpful (${count})` : `👎 Unhelpful (${count})`;
    });
});

// Handle form submission
document.getElementById("review-form").addEventListener("submit", (e) => {
    e.preventDefault();
    const name = document.getElementById("name").value;
    const rating = document.getElementById("rating").value;
    const reviewText = document.getElementById("review-text").value;
    alert(`Thank you, ${name}! Your rating: ${rating} stars\nReview: ${reviewText}`);
});
