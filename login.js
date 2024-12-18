function loginAccount(data) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    if (xhttp.DONE == 4 && xhttp.status == 200) {
      const res = JSON.parse(xhttp.responseText);
      console.log(res["user_role"]);
      if (res["user_role"] === "1") {
        document.location.href = "./admin/admin.php";
        return;
      }
      document.location.href = "home.php";
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
  xhttp.open("POST", "../actions/login_action.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}

function validateform() {
  const useremail = document.getElementById("useremail").value;
  const userpassword = document.getElementById("userpassword").value;

  let isValid = true;

  function displayError(id, errormessage) {
    const errorElement = document.getElementById(id);
    if (errorElement) {
      errorElement.textContent = errormessage;
    }
  }

  // Clear all errors
  displayError("emailError", "");
  displayError("passwordError", "");

  // Validate username
  if (!useremail) {
    displayError("emailError", "Please enter your email.");
    isValid = false;
  }
  //password validation
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
  //email validation
  const emailReq = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!useremail.match(emailReq)) {
    displayError("emailError", "Please enter a valid email address.");
    isValid = false;
  }
  if (!isValid) {
    alert("Please fix the errors and try again.");
  }

  if (isValid) {
    return loginAccount(
      "useremail=" +
        useremail +
        "&userpassword=" +
        userpassword +
        "&loginButton"
    );
  }
  return isValid;
}
