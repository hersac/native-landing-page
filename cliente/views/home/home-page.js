import { CarouselCard } from "./cards/carouselCard/carousel-card.js";

export class HomePage extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });
  }

  connectedCallback() {
    this.render();
  }

  async render() {
    const styles = await fetch("views/home/home-page.css").then((response) =>
      response.text()
    );
    const homeTempalte = await fetch("views/home/home-page.html").then(
      (response) => response.text()
    );

    this.shadowRoot.innerHTML = `
        <style>${styles}</style>
        ${homeTempalte}
      `;

    customElements.define("carousel-card", CarouselCard);
    const carouselCard = this.shadowRoot.querySelector("carousel-card");
  }
}
