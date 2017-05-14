import Accordion from '../util/accordion';
import Sticky from '../util/sticky';
import Parallax from '../util/parallax';

export default {
  init() {
    window.addEventListener('load', () => {
      new Accordion('.accordion').init();
    });
    new Parallax('#featured-image').init();
    new Sticky('#menu-practices', '.sidebar').init();
  },
};
