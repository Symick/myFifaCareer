const buttons = document.querySelectorAll(".show-form-btn");
buttons.forEach((button) => {
	button.addEventListener("click", () => {
		const otherForms = document.querySelectorAll(".create-form");
		otherForms.forEach((otherForm) => {
			otherForm.classList.remove("show");
		});
		const form = button.previousElementSibling;
		form.classList.add("show");
	});
});

let updateButtons = document.querySelectorAll(".update-btn");
updateButtons.forEach((updateButton) => {
	updateButton.addEventListener("click", () => {
		const showButton = updateButton.previousElementSibling;
		updateButton.nextElementSibling.setAttribute("disabled", true);
		showButton.classList.add("show");
		updateButton.style.setProperty("display", "none");
		const player = updateButton.getAttribute("data-player");
		const inputs = document.querySelectorAll("[disabled]");
		inputs.forEach((input) => {
			const inputOfPlayer = input.getAttribute("data-player");
			if (inputOfPlayer === player) {
				input.removeAttribute("disabled");
			}
		});
	});
});
