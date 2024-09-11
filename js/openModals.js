function openModal() {
  document.getElementById("addStudentModal").style.display = "block";
}

function closeModal() {
  document.getElementById("addStudentModal").style.display = "none";
}

window.onclick() = function(event) {
    var modal = document.getElementById("addStudentModal");
    if(event.target == modal) {
        modal.style.display = "none";
    }
}


 