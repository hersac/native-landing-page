import { carouselCardSections } from "../../../../constants/carousel-card-sections.js";

export class CarouselCard extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });
    this.activeSection = 1;

    this.sectionConfig = {
      1: { background: "./assets/img/fondo_tarjeta.webp" },
      2: { background: "./assets/img/desierto.webp" },
      3: { background: "./assets/img/playa.webp" },
    };
  }

  connectedCallback() {
    this.render();
  }

  async render() {
    await this.loadResources();
    this.setupEventListeners();
    this.activateSection(this.activeSection);
  }

  async loadResources() {
    try {
      const [carouselStyles, carouselTemplate] = await Promise.all([
        fetch("views/home/cards/carouselCard/carousel-card.css").then(
          (response) => response.text()
        ),
        fetch("views/home/cards/carouselCard/carousel-card.html").then(
          (response) => response.text()
        ),
      ]);

      this.shadowRoot.innerHTML = `
        <style>
          @import url("./assets/css/globals.css");
          @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css");
          ${carouselStyles}
        </style>
        ${carouselTemplate}
      `;
    } catch (error) {
      console.error("Error cargando recursos:", error);
    }
  }

  setupEventListeners() {
    const selectors = Array.from(
      this.shadowRoot.querySelectorAll("[data-section]")
    );

    selectors.forEach((selector) => {
      const sectionId = parseInt(selector.dataset.section);

      if (selector.id.startsWith("selector")) {
        selector.addEventListener("click", () =>
          this.activateSection(sectionId)
        );
      }
    });
  }

  activateSection(sectionId) {
    if (!this.sectionConfig[sectionId]) return;

    this.activeSection = sectionId;

    const selectors = Array.from(
      this.shadowRoot.querySelectorAll(
        ".carouselCard__container__buttons__selectors__selector"
      )
    );
    selectors.forEach((selector) => {
      const id = parseInt(selector.dataset.section);
      selector.classList.toggle("active", id === sectionId);
    });

    const contents = Array.from(
      this.shadowRoot.querySelectorAll(".carouselCard__container__content")
    );
    contents.forEach((content) => {
      const id = parseInt(content.dataset.section);
      content.style.display = id === sectionId ? "flex" : "none";
    });

    const fondoTarjeta = this.shadowRoot.querySelector("#fondo_tarjeta");
    fondoTarjeta.setAttribute("src", this.sectionConfig[sectionId].background);
  }
}
