const hamburger = document.querySelector(".hamburger-menu");
const navBar = document.querySelector(".nav-menu");

//show menu and change hamburger style when clicked
hamburger.addEventListener("click", () => {
	hamburger.classList.toggle("clicked");
	navBar.classList.toggle("show");
});
