// get buttons
const addPlayerButton = document.querySelectorAll(".add-player-btn");
const savePlayerButtons = document.querySelectorAll(".save-btn");
const deletePlayerButtons = document.querySelectorAll(".delete-btn");

//handle add player fetch
addPlayerButton.forEach((addButton) => {
	addButton.addEventListener("click", (e) => {
		e.preventDefault();
		const form = addButton.parentElement;
		const dataForm = new FormData(form);
		const errorDisplay = form.parentElement.nextElementSibling;
		dataForm.append(e.target.name, "clicked");
		fetch("./back-end/stats-back-end/ajax/ajax-add-player.php", {
			method: "POST",
			body: dataForm,
		})
			.then((res) => {
				return res.json();
			})
			.then((res) => {
				//errorMessage is an array
				if (res.errorMessage !== false) {
					errorDisplay.innerHTML = res.errorMessage
						.toString()
						.replaceAll(",", "<br>")
						.replaceAll(".", ",");
				}
				if (res.success !== false) {
					const newForm = document.createElement("form");
					addFormAttributes(newForm);
					newForm.innerHTML = res.success;
					form.parentElement.insertBefore(
						newForm,
						form.parentElement.firstElementChild
					);
					form.classList.remove("show");
					const inputs = form.querySelectorAll("input");
					inputs.forEach((input) => {
						input.value = "";
					});
					//variable from show-player-form.js,
					//needs to be updated to make update buttons function
					updateButtons = document.querySelectorAll(".update-btn");
					handleUpdateButtonLogic(updateButtons);
					const saveButton = newForm.querySelector(".save-btn");
					const deleteButton = newForm.querySelector(".delete-btn");
					saveButton.addEventListener("click", (e) => {
						updatePlayerFetch(e, saveButton);
					});
					deleteButton.addEventListener("click", (e) => {
						deletePlayerFetch(e, deleteButton);
					});
				}
			})
			.catch((err) => {
				console.error(err);
			});
	});
});

//handle updateFetch
savePlayerButtons.forEach((saveButton) => {
	saveButton.addEventListener("click", (e) => {
		updatePlayerFetch(e, saveButton);
	});
});

//handle delete fetch
deletePlayerButtons.forEach((deleteButton) => {
	deleteButton.addEventListener("click", (e) => {
		deletePlayerFetch(e, deleteButton);
	});
});

function updatePlayerFetch(e, saveButton) {
	e.preventDefault();
	const buttonValue = e.target.value;
	const form = saveButton.parentElement;
	const errorDisplay = form.parentElement.nextElementSibling;
	const dataForm = new FormData(form);
	dataForm.append("update", buttonValue);
	fetch("./back-end/stats-back-end/ajax/update-player.php", {
		method: "POST",
		body: dataForm,
	})
		.then((res) => {
			return res.json();
		})
		.then((res) => {
			const deleteButton = form.querySelector(".delete-btn");
			if (res.errorMessage !== false) {
				errorDisplay.textContent = res.errorMessage;
				const updateButton = form.querySelector(".update-btn");
				const inputs = form.querySelectorAll("input");
				disableInputs(inputs);
				resetUpdateButtons(saveButton, updateButton);
				deleteButton.removeAttribute("disabled");
			}
			if (res.success !== false) {
				updatePlayerDisplay(res.success, form);
				errorDisplay.textContent = "player Updated!";
				deleteButton.removeAttribute("disabled");
			}
		})
		.catch((err) => console.error(err));
}

function deletePlayerFetch(e, deleteButton) {
	e.preventDefault();
	const buttonValue = e.target.value;
	const form = deleteButton.parentElement;
	const formParent = form.parentElement;
	const errorDisplay = form.parentElement.nextElementSibling;
	const dataForm = new FormData(form);
	dataForm.append("delete", buttonValue);
	fetch("./back-end/stats-back-end/ajax/delete-player.php", {
		method: "POST",
		body: dataForm,
	})
		.then((res) => {
			return res.text();
		})
		.then((res) => {
			errorDisplay.textContent = res;
			formParent.removeChild(form);
		})
		.catch((err) => console.error(err));
}

/** updates the display of the player when stats are updated
 *
 * object --> object containing player info
 *
 * parent --> parent element of the display that needs to be updated.
 */
function updatePlayerDisplay(object, parent) {
	//get values from the json response
	const playedGames = parseInt(object.playedGames);
	const assists = parseInt(object.assists);
	const goals = parseInt(object.goals);
	const positionGroup = object.positionGroup;
	//update input values
	const inputs = parent.querySelectorAll("input");
	disableInputs(inputs);
	const playedGamesInput = parent.querySelector('[name="games-played"]');
	playedGamesInput.value = playedGames;
	if (positionGroup !== "keeper") {
		const assistsInput = parent.querySelector('[name="assists"]');
		const goalsInput = parent.querySelector('[name="goals"]');
		assistsInput.value = assists;
		goalsInput.value = goals;
	}

	//update buttons
	const saveButton = parent.querySelector(".save-btn");
	const updateButton = parent.querySelector(".update-btn");
	resetUpdateButtons(saveButton, updateButton);
}

/**
 *styles all inputs to be disabled
 *
 * inputNodeList --> Node list of all inputs
 */
function disableInputs(inputNodeList) {
	inputNodeList.forEach((input) => {
		input.setAttribute("disabled", true);
	});
}
/**
 *reset the button to default settings,
 *
 * input: buttons to be reset
 */
function resetUpdateButtons(saveButton, updateButton) {
	saveButton.classList.remove("show");
	updateButton.style.setProperty("display", "block");
}
/**
 * add the the create-player form attributes to given form
 * form--> form to add attributes to
 */
function addFormAttributes(form) {
	form.action = "back-end/stats-back-end/manage-players.php";
	form.method = "post";
	form.classList.add("manage-players-form");
}

function handleUpdateButtonLogic(updateButtons) {
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
}
