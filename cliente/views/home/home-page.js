import { CarouselCard } from "./cards/carouselCard/carousel-card.js";

export class HomePage extends HTMLElement {
  static get observedAttributes() {
    return ['scroll-position']
  } 

  constructor() {
    super();
    this.attachShadow({ mode: "open" });

    this.scrollPosition = 0;
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


  }

  attributeChangedCallback(name, oldValue, newValue) {
    if (name === 'scroll-position') {
      this.scrollPosition = parseFloat(newValue);
      this.smoothEffect();
    }
  }

  smoothEffect() {
    const homeContenidoImage = this.shadowRoot.querySelector('.home__contenido__imagen');
    const homeContenidoMensaje = this.shadowRoot.querySelector('.home__contenido__mensaje');

    homeContenidoImage.style.transform = `translateY(-${this.scrollPosition * 0.08}px)`;
    homeContenidoMensaje.style.transform = `translateY(-${this.scrollPosition * 0.08}px)`;
  }
}
