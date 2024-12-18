// document.addEventListener("DOMContentLoaded", () => {
//   // Chart.js Analytics Example
//   const ctx = document.getElementById("user-chart").getContext("2d");
//   new Chart(ctx, {
//     type: "bar",
//     data: {
//       labels: ["January", "February", "March", "April"],
//       datasets: [
//         {
//           label: "New Users",
//           data: [12, 19, 3, 5],
//           backgroundColor: "rgba(75, 192, 192, 0.6)",
//           borderWidth: 1,
//         },
//       ],
//     },
//   });
// });

document.addEventListener("DOMContentLoaded", () => {
  // Fetch user analytics data from the server
  fetch("../../actions/get_user_analytics_action.php")
    .then((response) => response.json())
    .then((data) => {
      // Extract the months and user counts from the fetched data
      const months = data.map((item) => item.month); // e.g., ["January", "February", "March", "April"]
      const newUserCounts = data.map((item) => item.new_users); // e.g., [12, 19, 3, 5]

      // Create the chart
      const ctx = document.getElementById("user-chart").getContext("2d");
      new Chart(ctx, {
        type: "bar",
        data: {
          labels: months, // Use the months from the fetched data
          datasets: [
            {
              label: "New Users",
              data: newUserCounts, // Use the new user data
              backgroundColor: "rgba(75, 192, 192, 0.6)",
              borderWidth: 1,
            },
          ],
        },
      });
    })
    .catch((error) => {
      console.error("Error fetching user analytics data:", error);
    });
});
