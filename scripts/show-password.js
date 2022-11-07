const eyeIcons = document.querySelectorAll("[data-eye]");
eyeIcons.forEach((icon) => {
	const input = icon.previousElementSibling;
	icon.addEventListener("click", () => {
		icon.classList.toggle("fa-eye");
		icon.classList.toggle("fa-eye-slash");

		//when fa-eye-slash is visible the placeholder and input need to be visible
		icon.classList.contains("fa-eye-slash")
			? (input.type = "text")
			: (input.type = "password");
	});
});
