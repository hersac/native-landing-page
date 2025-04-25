import { NavbarComponent } from "../../components/navbar/navbar-component.js";
import { HomePage } from "../../views/home/home-page.js";
import { navbarTitles } from "../../constants/navbar-titles.js";

const isDarkMode = localStorage.getItem("isDarkMode") === "true";

if (isDarkMode) {
  document.body.classList.add("dark-theme");
} else {
  document.body.classList.remove("dark-theme");
}

customElements.define("navbar-component", NavbarComponent);
const navbar = document.createElement("navbar-component");
navbar.setAttribute("titles", JSON.stringify(navbarTitles));
navbar.setAttribute("isDarkMode", isDarkMode.toString());

navbar.addEventListener("darkModeChange", (event) => {
  const darkModeState = event.detail.isDarkMode;

  if (darkModeState) {
    document.body.classList.add("dark-theme");
  } else {
    document.body.classList.remove("dark-theme");
  }

  localStorage.setItem("isDarkMode", darkModeState);
  navbar.setAttribute("isDarkMode", darkModeState.toString());
});

const header = document.querySelector("#header");
header.appendChild(navbar);

customElements.define("home-page", HomePage);
const homePage = document.createElement("home-page");

const app = document.querySelector("#app");
app.appendChild(homePage);

app.addEventListener('scroll', () => {
  const scrollPosition = app.scrollTop;
  homePage.setAttribute('scroll-position', scrollPosition.toString());
});