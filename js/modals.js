// Example JavaScript for modals
function openModal() {
  document.getElementById("addStudentModal").style.display = "block";
}

function closeModal() {
  document.getElementById("addStudentModal").style.display = "none";
}

function openEditModal(
  student_id,
  name,
  school_id,
  bday,
  age,
  course,
  year_level
) {
  // Populate the form fields in the edit modal
  document.getElementById("editStudentId").value = student_id;
  document.getElementById("editName").value = name;
  document.getElementById("editSchoolId").value = school_id;
  document.getElementById("editBday").value = bday;
  document.getElementById("editAge").value = age;
  document.getElementById("editCourse").value = course;
  document.getElementById("editYearLevel").value = year_level;

  // Display the edit modal
  document.getElementById("editStudentModal").style.display = "block";
}

function closeEditModal() {
  document.getElementById("editStudentModal").style.display = "none";
}
