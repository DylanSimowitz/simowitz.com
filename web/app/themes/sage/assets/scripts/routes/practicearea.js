import Sticky from '../util/sticky';
import Parallax from '../util/parallax';
import {recalculateWidth} from '../util/helpers';

export default {
  init() {
    const $menu = document.querySelector('#menu-practices');
    const $sidebar = document.querySelector('.sidebar--practices');

    new Parallax('#featured-image').init();
    new Sticky($menu, $sidebar).init();
      new Sticky('.social-buttons', 'section.main', 100, 50, () => recalculateWidth($menu, $sidebar)).init();
  },
};
