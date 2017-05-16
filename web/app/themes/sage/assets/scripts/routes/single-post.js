import Sticky from '../util/sticky';
import Parallax from '../util/parallax';
import {recalculateWidth} from '../util/helpers';
import _ from 'lodash';

export default {
  init() {
    const $posts = document.querySelector('.related-posts');
    const $sidebar = document.querySelector('.sidebar--posts');

    new Parallax('#featured-image').init();
    new Sticky('.social-buttons', 'section.main', 100, 50).init();
    const stickySidebar = new Sticky($posts, $sidebar, 0, 0, _.debounce(removeSidebar, 250));
    stickySidebar.init();

    function removeSidebar() {
      if (window.innerWidth < 992) {
        stickySidebar.remove();
        $posts.style.width = '';
      }
      else {
        stickySidebar.init();
        recalculateWidth($posts, $sidebar);
      }
    }
  },
};
