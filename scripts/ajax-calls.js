// get buttons
const addPlayerButton = document.querySelectorAll(".add-player-btn");
const savePlayerButtons = document.querySelectorAll(".save-btn");
const deletePlayerButtons = document.querySelectorAll(".delete-btn");
const addTeamButton = document.querySelector(".add-team-btn");
const deleteTeamButtons = document.querySelectorAll(".remove-team-btn");

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
					form.parentElement.lastElementChild.after(newForm);
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

//handle update player fetch
savePlayerButtons.forEach((saveButton) => {
	saveButton.addEventListener("click", (e) => {
		updatePlayerFetch(e, saveButton);
	});
});

//handle delete player fetch
deletePlayerButtons.forEach((deleteButton) => {
	deleteButton.addEventListener("click", (e) => {
		deletePlayerFetch(e, deleteButton);
	});
});

// handle add team fetch
addTeamButton.addEventListener("click", (e) => {
	e.preventDefault();
	const form = addTeamButton.parentElement;
	const errorDisplay = addTeamButton.nextElementSibling;
	const data = new FormData(form);
	data.append(e.target.name, "clicked");
	fetch("./back-end/stats-back-end/ajax/ajax-add-team.php", {
		method: "POST",
		body: data,
	})
		.then((res) => {
			return res.json();
		})
		.then((res) => {
			const teamInput = addTeamButton.previousElementSibling;
			const teamDisplay = document.querySelector(".teams-container");
			if (res.errorMessage !== false) {
				errorDisplay.innerText = res.errorMessage;
			}
			if (res.success !== false) {
				//add message to display
				errorDisplay.innerHTML = res.errorMessage;
				//add team to list of teams.
				teamDisplay.insertAdjacentHTML("beforeend", res.success);
				//clear input from its text
				teamInput.value = "";
				//add delete event handler to new elements
				document
					.querySelectorAll(".remove-team-btn")
					.forEach((deleteButton) => {
						deleteButton.addEventListener("click", (e) => {
							deleteTeamFetch(e, deleteButton);
						});
					});
			}
		})
		.catch((err) => {
			console.error(err);
		});
});

// handle delete team fetch
deleteTeamButtons.forEach((deleteButton) => {
	deleteButton.addEventListener("click", (e) => {
		deleteTeamFetch(e, deleteButton);
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
				console.log(res.errorMessage);
				errorDisplay.textContent = res.errorMessage;
				const updateButton = form.querySelector(".update-btn");
				const inputs = form.querySelectorAll("input");
				disableInputs(inputs);
				resetUpdateButtons(saveButton, updateButton);
				deleteButton.removeAttribute("disabled");
			}
			if (res.success !== false) {
				updatePlayerDisplay(res.success, form);
				errorDisplay.innerHTML =
					'<span class="success-text">player Updated!</span>';
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
			return res.json();
		})
		.then((res) => {
			console.log(res);
			if (res.errorMessage !== false) {
				errorDisplay.innerHTML = res.errorMessage;
			}
			if (res.success !== false) {
				errorDisplay.innerHTML = res.success;
				formParent.removeChild(form);
			}
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
/**
 *
 * @param {Element} updateButtons
 */
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
/**
 *
 * @param {Object} e event of the click event
 * @param {Element} deleteButton the button which the team
 */
function deleteTeamFetch(e, deleteButton) {
	e.preventDefault();
	const form = deleteButton.parentElement.parentElement;
	const errorDisplay = form.nextElementSibling.lastElementChild;
	const data = new FormData(form);
	//append button value to the form
	data.append("remove-team", e.target.parentElement.value);
	fetch("./back-end/stats-back-end/ajax/delete-team.php", {
		method: "POST",
		body: data,
	})
		.then((res) => {
			return res.json();
		})
		.then((res) => {
			if (res.errorMessage !== false) {
				errorDisplay.innerText = res.errorMessage;
			}
			if (res.success !== false) {
				errorDisplay.innerHTML = res.success;
				deleteTeam(deleteButton);
			}
		})
		.catch((err) => {
			console.error(err);
		});
}
/**
 *
 * @param {Element} deleteButton
 */
function deleteTeam(deleteButton) {
	const teamName = deleteButton.previousElementSibling;
	const radioButton = teamName.previousElementSibling;
	teamName.remove();
	radioButton.remove();
	deleteButton.remove();
}
