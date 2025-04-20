import { NavbarComponent } from "../../components/navbar/navbar-component.js";
import { navbarTitles } from "../../constants/navbar-titles.js";

customElements.define("navbar-component", NavbarComponent);
const navbar = document.createElement("navbar-component");
navbar.setAttribute("titles", JSON.stringify(navbarTitles));

const header = document.querySelector("#header");
header.appendChild(navbar);
