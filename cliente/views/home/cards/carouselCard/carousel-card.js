import { carouselCardSections } from "../../../../constants/carousel-card-sections.js";

export class CarouselCard extends HTMLElement {
  constructor() {
    super();
    this.attachShadow({ mode: "open" });

    this.selector = carouselCardSections.selector1;
  }

  connectedCallback() {
    this.render();
  }

  async render() {
    const carouselStyles = await fetch(
      "views/home/cards/carouselCard/carousel-card.css"
    ).then((response) => response.text());
    const carouselTemplate = await fetch(
      "views/home/cards/carouselCard/carousel-card.html"
    ).then((response) => response.text());

    this.shadowRoot.innerHTML = `
            <style>
              @import url("./assets/css/globals.css");
              @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css");
              ${carouselStyles}
            </style>
            ${carouselTemplate}
        `;

    const fondoTarjeta = this.shadowRoot.querySelector("#fondo_tarjeta");
    const selector1 = this.shadowRoot.querySelector("#selector1");
    const selector2 = this.shadowRoot.querySelector("#selector2");
    const selector3 = this.shadowRoot.querySelector("#selector3");
    const content1 = this.shadowRoot.querySelector("#content1");
    const content2 = this.shadowRoot.querySelector("#content2");
    const content3 = this.shadowRoot.querySelector("#content3");

    selector1.classList.add("active");
    selector2.classList.remove("active");
    selector3.classList.remove("active");
    content1.style.display = "flex";
    content2.style.display = "none";
    content3.style.display = "none";
    fondoTarjeta.setAttribute("src", "./assets/img/fondo_tarjeta.webp");

    selector1.addEventListener("click", () => {
      this.selector = carouselCardSections.selector1;
      selector1.classList.add("active");
      selector2.classList.remove("active");
      selector3.classList.remove("active");
      content1.style.display = "flex";
      content2.style.display = "none";
      content3.style.display = "none";
      fondoTarjeta.setAttribute("src", "./assets/img/fondo_tarjeta.webp");
    });

    selector2.addEventListener("click", () => {
      this.selector = carouselCardSections.selector2;
      selector2.classList.add("active");
      selector1.classList.remove("active");
      selector3.classList.remove("active");
      content1.style.display = "none";
      content2.style.display = "flex";
      content3.style.display = "none";
      fondoTarjeta.setAttribute("src", "./assets/img/desierto.webp");
    });

    selector3.addEventListener("click", () => {
      this.selector = carouselCardSections.selector3;
      selector3.classList.add("active");
      selector1.classList.remove("active");
      selector2.classList.remove("active");
      content1.style.display = "none";
      content2.style.display = "none";
      content3.style.display = "flex";
      fondoTarjeta.setAttribute("src", "./assets/img/playa.webp");
    });
  }
}
