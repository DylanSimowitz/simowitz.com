class Parallax {
  constructor(element, distance = 3) {
    if (element.nodeType) {
      this.element = element;
    } else {
      this.element = document.querySelector(element);
    }
    this.distance = distance;
  }
  init() {
    this.scrollTop = 0;
    window.addEventListener('scroll', this.onScroll.bind(this));
  }
  onScroll() {
    if (window.pageYOffset) {
      this.scrollTop = window.pageYOffset;
    } else {
      this.scrollTop = document.body.scrollTop;
    }
    this.element.style.transform = `translate3d(0px, ${Math.floor(this.scrollTop/this.distance)}px, 0px)`;
  }
}


export default Parallax;
