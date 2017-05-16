function getElement(element) {
  if (element.nodeType) {
    return element;
  } else if (typeof element === 'string') {
    return document.querySelector(element);
  } else {
    return undefined;
  }
}

class Sticky {
  constructor(element, trigger = undefined, start = 0, end = 0, resize = () => {}) {
    this.resize = resize;
    this.start = start;
    this.end = end;
    this.element = getElement(element);
    this.trigger = getElement(trigger);
    this.onScroll = this.onScroll.bind(this);
  }
  init() {
    this.scrollTop = 0;
    this.trigger.style.position = 'relative';
    window.addEventListener('scroll', this.onScroll);
    window.addEventListener('resize', this.onResize.bind(this));
    this.resize();
    // window.addEventListener('load', this.onLoad.bind(this));
  }
  resizeElementWidth() {
    this.element.style.width = this.trigger.offsetWidth + 'px';
  }
  onResize() {
    this.resize()
  }
  onLoad() {
  }
  onScroll() {
    if (window.requestAnimationFrame) {
      requestAnimationFrame(this.makeSticky.bind(this));
    } else {
      setTimeout(this.makeSticky.bind(this), 250);
    }
  }
  remove() {
    window.removeEventListener('scroll', this.onScroll);
    this.removeStyles();
  }
  removeStyles() {
    this.element.style.position = '';
    this.element.style.top = '';
    this.element.style.bottom = '';
    this.trigger.style.position = '';
  }
  makeSticky() {
    const trigger = this.trigger.getBoundingClientRect();

    if (window.pageYOffset) {
      this.scrollTop = window.pageYOffset;
    } else {
      this.scrollTop = document.body.scrollTop;
    }
    if (trigger.top >= 0) {
      this.element.style.position = 'absolute';
      this.element.style.top = this.start + 'px';
      this.element.style.bottom = '';
    }
    if (trigger.top < 0) {
      this.element.style.position = 'fixed';
      this.element.style.top = this.start + 'px';
      this.element.style.bottom = '';
    }
    if (trigger.bottom - (this.start + this.end) - this.element.offsetHeight <= 0) {
      this.element.style.position = 'absolute';
      this.element.style.top = '';
      this.element.style.bottom = this.end + 'px';
    }
  }
}

export default Sticky;
