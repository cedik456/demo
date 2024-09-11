function formatFullName(firstName, middleName, lastName) {
  return `${firstName} ${middleName ? middleName + " " : ""}${lastName}`;
}

window.onload = function () {
  const fullNameElement = document.getElementById("full-name");
  const firstName = fullNameElement.getAttribute("data-first-name");
  const middleName = fullNameElement.getAttribute("data-middle-name");
  const lastName = fullNameElement.getAttribute("data-last-name");

  const fullName = formatFullName(firstName, middleName, lastName);
  fullNameElement.textContent = fullName;
};
