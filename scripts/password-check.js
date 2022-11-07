const input = document.getElementById("password");
input.addEventListener("input", () => {
	const value = input.value;
	const Object = checkRequirements(value);
	if (Object.lengthCheck) {
		const listItem = document.querySelector('[data-check="length"]');
		styleCheckTrue(listItem);
	} else {
		const listItem = document.querySelector('[data-check="length"]');
		resetItem(listItem);
	}
	if (Object.lowerCheck) {
		const listItem = document.querySelector('[data-check="lower"]');
		styleCheckTrue(listItem);
	} else {
		const listItem = document.querySelector('[data-check="lower"]');
		resetItem(listItem);
	}
	if (Object.upperCheck) {
		const listItem = document.querySelector('[data-check="upper"]');
		styleCheckTrue(listItem);
	} else {
		const listItem = document.querySelector('[data-check="upper"]');
		resetItem(listItem);
	}
	if (Object.numberCheck) {
		const listItem = document.querySelector('[data-check="number"]');
		styleCheckTrue(listItem);
	} else {
		const listItem = document.querySelector('[data-check="number"]');
		resetItem(listItem);
	}
	if (Object.symbolCheck) {
		const listItem = document.querySelector('[data-check="symbol"]');
		styleCheckTrue(listItem);
	} else {
		const listItem = document.querySelector('[data-check="symbol"]');
		resetItem(listItem);
	}
});

function checkRequirements(value) {
	let passwordChecks = {
		lengthCheck: false,
		lowerCheck: false,
		upperCheck: false,
		numberCheck: false,
		symbolCheck: false,
	};
	if (value.length >= 8) {
		passwordChecks.lengthCheck = true;
	}
	if (value.match(/[a-z]+/) !== null) {
		passwordChecks.lowerCheck = true;
	}
	if (value.match(/[A-Z]+/) !== null) {
		passwordChecks.upperCheck = true;
	}
	if (value.match(/[0-9]+/) !== null) {
		passwordChecks.numberCheck = true;
	}
	if (value.match(/[!@#$%^&*?.,+_-]+/) !== null) {
		passwordChecks.symbolCheck = true;
	}
	return passwordChecks;
}
function getColorValue(prop) {
	const colors = {
		greenColor: prop.getPropertyValue("--color-green"),
		redColor: prop.getPropertyValue("--color-red"),
	};
	return colors;
}
function resetItem(item) {
	const colors = getColorValue(getComputedStyle(document.body));
	item.style.setProperty("color", colors.redColor);
	item.firstElementChild.classList.remove("fa-check");
	item.firstElementChild.classList.add("fa-circle-xmark");
}

function styleCheckTrue(item) {
	const colors = getColorValue(getComputedStyle(document.body));
	item.style.setProperty("color", colors.greenColor);
	item.firstElementChild.classList.add("fa-check");
	item.firstElementChild.classList.remove("fa-circle-xmark");
}
