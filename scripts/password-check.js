const input = document.getElementById("password");
//create an array with all checks
const requirements = [
	{
		type: "length",
		check: (value) => value.length >= 8,
	},
	{
		type: "lower",
		check: (value) => value.match(/[a-z]+/) !== null,
	},
	{
		type: "upper",
		check: (value) => value.match(/[A-Z]+/) !== null,
	},
	{
		type: "number",
		check: (value) => value.match(/[0-9]+/) !== null,
	},
	{
		type: "symbol",
		check: (value) => value.match(/[!@#$%^&*?.,+_-]+/) !== null,
	},
];

//check password on input of the a password
input.addEventListener("input", () => {
	const value = input.value;
	requirements.forEach(({ type, check }) => {
		const listItem = document.querySelector(`[data-check="${type}"]`);
		if (check(value)) {
			updateListItem(listItem, "green");
		} else {
			updateListItem(listItem, "red");
		}
	});
});

/**
 * update the item on the list when depending on wether the check is matched or not
 * @param {HTMLLIElement} item
 * @param {string} color name of a color
 */
function updateListItem(item, color) {
	const { greenColor, redColor } = getColorValues();
	item.style.setProperty("color", color === "green" ? greenColor : redColor);
	item.firstElementChild.classList.toggle("fa-check", color === "green");
	item.firstElementChild.classList.toggle("fa-circle-xmark", color === "red");
}

/**
 * create an object containing the values of the a green and a red color
 * @returns object with color values.
 */
function getColorValues() {
	return {
		greenColor: getComputedStyle(document.body).getPropertyValue("--color-green"),
		redColor: getComputedStyle(document.body).getPropertyValue("--color-red"),
	};
}
