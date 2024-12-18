function createAccount(data) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (xhttp.DONE == 4 && xhttp.status == 200) {
      Swal.fire({
        title: "Success",
        text: xhttp.responseText,
        icon: "success",
        confirmButtonText: "Ok",
      }).then(() => {
        document.location.href = "login.php";
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
  xhttp.open("POST", "../actions/register_action.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function validateform() {
  const username = document.getElementById("username").value;
  const useremail = document.getElementById("useremail").value;
  const userpassword = document.getElementById("userpassword").value;
  const confirmpassword = document.getElementById("confirmpassword").value;
  let isValid = true;

  function displayError(id, errorMessage) {
    const errorElement = document.getElementById(id);
    if (errorElement) {
      errorElement.textContent = errorMessage;
    }
  }

  // Clear all errors
  displayError("usernameError", "");
  displayError("passwordError", "");
  displayError("emailError", "");
  displayError("confirmError", "");

  // Validate username
  if (!username) {
    displayError("usernameError", "Please enter your username.");
    isValid = false;
  }

  // Validate password
  const passwordReq = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*?><])(?=.{8,}).*$/;
  if (!userpassword.match(passwordReq)) {
    displayError(
      "passwordError",
      `Please make sure your password contains:
        - At least 8 characters
        - At least one uppercase letter
        - At least one digit
        - At least one special character (!@#$%^&*)`
    );
    isValid = false;
  }

  // Validate email
  const emailReq = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!useremail.match(emailReq)) {
    displayError("emailError", "Please enter a valid email address.");
    isValid = false;
  }

  // Confirm password
  if (userpassword !== confirmpassword) {
    displayError("confirmError", "Your passwords do not match.");
    isValid = false;
  }

  // Alert any remaining issues
  if (!isValid) {
    alert("Please fix the errors and try again.");
  }

  if (isValid) {
    return createAccount(
      "username=" +
        username +
        "&useremail=" +
        useremail +
        "&userpassword=" +
        userpassword +
        "&confirmPassword=" +
        confirmpassword +
        "&signUpButton"
    );
  }

  return isValid;
}
