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
    const contenidoImagen = this.shadowRoot.querySelector('.home__contenido__imagen');
    const tituloUno = this.shadowRoot.querySelector('.home__contenido__mensaje__titulo__uno');
    const tituloDos = this.shadowRoot.querySelector('.home__contenido__mensaje__titulo__dos');
    const mensajeTexto = this.shadowRoot.querySelector('.home__contenido__mensaje__texto');

    contenidoImagen.style.transform = `translateY(-${this.scrollPosition * 0.08}px)`;
    tituloUno.style.transform = `translateY(-${this.scrollPosition * 0.04}px)`;
    tituloDos.style.transform = `translateX(-${this.scrollPosition * 0.02}px)`;
    mensajeTexto.style.transform = `translateX(${this.scrollPosition * 0.06}px)`;
  }
}
