export class NavbarComponent extends HTMLElement {
  static get observedAttributes() {
    return ["titles", "isDarkMode"];
  }

  constructor() {
    super();
    this.attachShadow({ mode: "open" });

    this.titles = [];
    this.isDarkMode = false;
  }

  connectedCallback() {
    this.render();
  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name === "titles") {
      this.titles = JSON.parse(newValue);
    }
    if (name === "isDarkMode") {
      this.isDarkMode = newValue === "true";
    }
    this.render();
  }

  async render() {
    const css = await fetch("./components/navbar/navbar-component.css").then(
      (response) => response.text()
    );
    const originalHtml = await fetch(
      "./components/navbar/navbar-component.html"
    ).then((response) => response.text());

    const html = this.iterationTitles(originalHtml);

    this.shadowRoot.innerHTML = `
        <style>
          @import url("./assets/css/globals.css");
          @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css");
          ${css}
        </style>
        ${html}
      `;

    const btnDarkMode = this.shadowRoot.querySelector("#btnDarkMode");

    btnDarkMode.addEventListener("click", () => {
      this.isDarkMode = !this.isDarkMode;

      const event = new CustomEvent("darkModeChange", {
        detail: { isDarkMode: this.isDarkMode },
        bubbles: true,
        composed: true,
      });

      this.dispatchEvent(event);
    });
  }

  iterationTitles(originalHtml) {
    const titles = this.titles.map((element) => {
      return `
        <li class="navbar__list__element">
          <a href="${element.path}" class="navbar__list__element__path">
            ${element.title}
          </a>
        </li>`;
    });

    return originalHtml.replace("{{ elements }}", titles.join(""));
  }
}
