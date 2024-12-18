function fetchQuizStatus() {
  const xhttp = new XMLHttpRequest();

  xhttp.onload = () => {
    if (xhttp.DONE) {
      if (xhttp.responseText.trim() === "0") {
        console.log(xhttp.response);
        handlePopupQuiz();
      }
    }
  };

  xhttp.open("POST", "../actions/save_user_preferences_action.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send("fetchQuizStatus");
}

document.addEventListener("DOMContentLoaded", () => {
  fetchQuizStatus();
});

function handlePopupQuiz() {
  //   document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("quiz-modal");
  const closeModalBtn = document.querySelector(".close-modal");
  const startQuizBtn = document.getElementById("start-quiz");
  const quizIntro = document.querySelector(".quiz-intro");
  const quizSection = document.getElementById("quiz-section");
  const resultsSection = document.getElementById("results-section");
  const restartQuizBtn = document.getElementById("restart-quiz");

  // Function to open modal
  function openModal() {
    modal.style.display = "block";
  }

  // Function to close modal
  function closeModal() {
    modal.style.display = "none";
    // Reset quiz to initial state
    quizIntro.style.display = "block";
    quizSection.style.display = "none";
    resultsSection.style.display = "none";
  }

  // Event Listeners
  closeModalBtn.addEventListener("click", closeModal);

  // Existing quiz logic with modal integration
  startQuizBtn.addEventListener("click", () => {
    quizIntro.style.display = "none";
    quizSection.style.display = "block";
  });

  document.getElementById("quiz-form").addEventListener("submit", (e) => {
    e.preventDefault();

    const answers = {
      q1: document.querySelector('input[name="q1"]:checked'),
      q2: document.querySelector('input[name="q2"]:checked'),
      q3: document.querySelector('input[name="q3"]:checked'),
    };

    let personality = "The Explorer";
    let personality_value = 1;
    if (answers.q1 && answers.q2 && answers.q3) {
      if (answers.q1.value === "Thriller" && answers.q2.value === "Excited") {
        personality = "The Adventurer";
        personality_value = 2;
      } else if (answers.q1.value === "Romance") {
        personality = "The Dreamer";
        personality_value = 3;
      } else if (answers.q3.value === "Library") {
        personality = "The Scholar";
        personality_value = 4;
      } else {
        personality = "The Free Spirit";
        personality_value = 5;
      }

      document.getElementById(
        "personality-result"
      ).innerText = `You are ${personality}!`;
      quizSection.style.display = "none";
      resultsSection.style.display = "block";
    }

    savePreferences(personality_value);
  });

  restartQuizBtn.addEventListener("click", () => {
    resultsSection.style.display = "none";
    quizSection.style.display = "block";
  });

  // Optional: If you want to automatically open the modal on first login
  // You can call openModal() when needed
  openModal();
  //   });
}

function savePreferences(data) {
  const xhttp = new XMLHttpRequest();

  xhttp.onload = () => {
    if (xhttp.DONE) {
      console.log(xhttp.response);
    }
  };

  xhttp.open("POST", "../actions/save_user_preferences_action.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send("personality=" + data + "&submitQuiz");
}
