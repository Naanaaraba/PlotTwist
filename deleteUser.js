function deleteUser(userId) {
  if (confirm("Are you sure you want to delete this user?")) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../actions/delete_user_action.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        alert(xhr.responseText); // Show the response message
        if (xhr.responseText.includes("successfully")) {
          // Optionally, remove the user's row from the table
          var row = document.getElementById("userRow" + userId);
          if (row) {
            row.parentNode.removeChild(row); // Remove the row from the table
            // window.location.reload();
          }

          setTimeout(function () {
            window.location.reload();
          }, 500);
        }
      }
    };

    // Send the request with the user ID
    xhr.send("user_id=" + userId);
  }
}
