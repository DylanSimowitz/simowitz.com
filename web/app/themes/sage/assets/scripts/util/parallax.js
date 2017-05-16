class Parallax {
  constructor(element) {
    if (element.nodeType) {
      this.element = element;
    } else {
      this.element = document.querySelector(element);
    }
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
    this.element.style.transform = `translate3d(0px, ${Math.floor(this.scrollTop/3)}px, 0px)`;
  }
}


export default Parallax;
