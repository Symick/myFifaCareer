const eyeIcon = document.getElementById("eye");
eyeIcon.addEventListener("click", () => {
	//changes the icon depending on which icon is already showing.
	if (eyeIcon.classList.contains("fa-eye")) {
		eyeIcon.classList.remove("fa-eye");
		eyeIcon.classList.add("fa-eye-slash");
	} else {
		eyeIcon.classList.remove("fa-eye-slash");
		eyeIcon.classList.add("fa-eye");
	}

	const input = document.getElementById("password");
	const inputType = input.type;
	if (inputType === "password") {
		input.type = "text";
	} else {
		input.type = "password";
	}
});
