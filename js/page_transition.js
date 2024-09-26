window.addEventListener("load", () => {
  document.body.classList.add("visible");
});

const links = document.querySelectorAll("a");

links.forEach((link) => {
  link.addEventListener("click", (event) => {
    event.preventDefault();
    document.body.classList.remove("visible");

    setTimeout(() => {
      window.location = link.href;
    }, 500);
  });
});
