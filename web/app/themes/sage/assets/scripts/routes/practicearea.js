import Sticky from '../util/sticky';
import Parallax from '../util/parallax';
import {recalculateWidth} from '../util/helpers';
import {debounce} from 'lodash';

export default {
  init() {
    const $menu = document.querySelector('#menu-practices');
    const $sidebar = document.querySelector('.sidebar--practices');

    new Parallax('#featured-image').init();
    new Sticky($menu, $sidebar).init();
    const stickySidebar = new Sticky('.social-buttons', 'section.main', 100, 50, debounce(removeSidebar, 250));

    stickySidebar.init();

    function removeSidebar() {
      if (window.innerWidth >= 992 && stickySidebar.isActive) {
        recalculateWidth($menu, $sidebar);
      } else if (window.innerWidth >= 992 && !stickySidebar.isActive) {
        stickySidebar.init();
        recalculateWidth($menu, $sidebar);
      } else if (window.innerWidth < 992 && stickySidebar.isActive) {
        stickySidebar.remove();
      }
    }
  },
};
