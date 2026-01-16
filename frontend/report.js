// Read data from localStorage
const data = JSON.parse(localStorage.getItem("report"));

if (data) {

  document.getElementById("name").innerText = data.name;
  document.getElementById("role").innerText = data.role;
  document.getElementById("project").innerText = data.project;

  const commentDiv = document.getElementById("comments");
  commentDiv.innerHTML = "";
  data.comments.forEach(c => {
    commentDiv.innerHTML += `
      <div class="timeline-item">
        <b>${c.author}:</b> ${c.text}<br>
        <span>${c.date}</span>
      </div>
    `;
  });

  document.getElementById("status").innerText = data.status;

} else {
  alert("No report data found");
}
