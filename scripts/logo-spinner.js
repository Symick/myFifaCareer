/*
 *if clicked on the logo, it will spin.
 */
const logo = document.querySelector(".logo");

let rotateValue = getComputedStyle(logo).getPropertyValue("--rotate");
document
	.querySelector('img[src="img/logo.png"]')
	.addEventListener("click", () => {
		rotateValue = parseInt(rotateValue + 360);
		logo.style.setProperty("--rotate", rotateValue);
	});
