function saveReport() {

  const reportData = {
    name: document.getElementById("name").value,
    role: document.getElementById("role").value,
    project: document.getElementById("project").value,
    comments: [
      {
        author: document.getElementById("name").value,
        text: document.getElementById("comment").value,
        date: new Date().toLocaleDateString()
      }
    ],
    status: document.getElementById("status").value
  };

  // Store in browser (acts like database)
  localStorage.setItem("report", JSON.stringify(reportData));

  alert("Project saved successfully");
}
