/*
  code for about Us observer, observer checks if the window is intersecting the about-us page,
  if about us is 95 percent of the screen, the nav-style will change.
*/
const aboutUs = document.querySelector(".about-us");
const header = document.querySelector(".header");
//precentage of the screen taken by the header
const sizeTakenByHeader = header.clientHeight / window.innerHeight;

const aboutUsObserver = new IntersectionObserver(
	function (entries, aboutUsObserver) {
		let scrollbarColor = "--scrollbar-color";

		entries.forEach((entry) => {
			if (!entry.isIntersecting) {
				header.classList.remove("nav-at--about-us");
				document.documentElement.style.setProperty(scrollbarColor, "#030564");
			} else {
				header.classList.add("nav-at--about-us");
				document.documentElement.style.setProperty(scrollbarColor, "#640305");
			}
		});
	},
	{
		threshold: 1 - sizeTakenByHeader,
	}
);

aboutUsObserver.observe(aboutUs);
