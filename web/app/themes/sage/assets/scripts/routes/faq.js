import Accordion from '../util/accordion';
import Sticky from '../util/sticky';

export default {
  init() {
    window.addEventListener('load', () => {
      new Accordion('.accordion').init();
    });
    new Sticky('#menu-practices', '.sidebar').init();
  },
};
