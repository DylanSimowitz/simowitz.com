import {getElement} from './helpers';

class Sticky {
  constructor(element, trigger = undefined, start = 0, end = 0, resize = () => {}) {
    this.resize = resize;
    this.start = start;
    this.end = end;
    this.element = getElement(element);
    this.trigger = getElement(trigger);
    this.onScroll = this.onScroll.bind(this);
    this.onResize = this.onResize.bind(this);
    this.onLoad = this.onLoad.bind(this);
    this.isActive = false;
  }
  init() {
    this.isActive = true;
    this.scrollTop = 0;
    this.trigger.style.position = 'relative';
    window.addEventListener('scroll', this.onScroll);
    window.addEventListener('resize', this.onResize);
    window.addEventListener('load', this.onLoad);
  }
  onResize() {
    this.resize();
  }
  onScroll() {
    if (window.requestAnimationFrame) {
      requestAnimationFrame(this.makeSticky.bind(this));
    } else {
      setTimeout(this.makeSticky.bind(this), 250);
    }
  }
  onLoad() {
    this.makeSticky();
  }
  remove() {
    this.isActive = false;
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
