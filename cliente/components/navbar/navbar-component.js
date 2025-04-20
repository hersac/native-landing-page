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
        <style>${css}</style>
        ${html}
      `;
  }

  iterationTitles(originalHtml) {
    return this.titles.map((navbarTitle) => {
      const { title, icon, path } = navbarTitle;
      return originalHtml
        .replace("{{ navbar.title }}", title)
        .replace("{{ navbar.icon }}", icon)
        .replace("{{ navbar.path }}", path);
    });
  }
}
