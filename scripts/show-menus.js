// shows/hide our sidebar
const hamburger = document.querySelector(".hamburger-menu");
const sidebar = document.querySelector(".sidebar");
hamburger.addEventListener("click", () => {
	hamburger.classList.toggle("clicked");
	sidebar.classList.toggle("show");
	sidebar.classList.remove("show-immediately");
});

// shows/hide fifa bar
const chooseYourFifaBar = document.querySelector(".fifa-bar");
document.getElementById("chooseYourFifa").addEventListener("click", () => {
	chooseYourFifaBar.classList.toggle("show");
	chooseYourFifaBar.classList.remove("show-immediately");
});

//keep fifa bar visible when choosing your version
let hash = location.hash.substring(1);
if (hash === "show-fifa-bar") {
	chooseYourFifaBar.classList.add("show-immediately");
	chooseYourFifaBar.classList.add("show");
}
if (hash === "sidebar") {
	hamburger.classList.add("clicked");
	sidebar.classList.add("show-immediately");
	sidebar.classList.add("show");
}
