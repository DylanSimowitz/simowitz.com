import Sticky from '../util/sticky';
import Parallax from '../util/parallax';

export default {
  init() {
    new Parallax('#featured-image').init();
    new Sticky('#menu-practices', '.sidebar').init();
  },
};
