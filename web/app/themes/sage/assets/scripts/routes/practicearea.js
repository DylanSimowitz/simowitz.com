import Sticky from '../util/sticky';
import Parallax from '../util/parallax';
import {recalculateWidth} from '../util/helpers';
import {debounce} from 'lodash';

export default {
  init() {
    const $menu = document.querySelector('#menu-practices');
    const $sidebar = document.querySelector('.sidebar--practices');
    const $socialButtons = document.querySelector('.social-buttons');
    const $main = document.querySelector('section.main');
    const $article = document.querySelector('article');

    new Parallax('#featured-image').init();
    const stickySidebar = new Sticky($menu, $sidebar, 0, 0, debounce(removeSidebar, 250));
    const stickySocialButtons = new Sticky($socialButtons, $main, 150, 50, debounce(removeSocialButtons, 250));

    stickySidebar.init();
    stickySocialButtons.init();

    window.addEventListener('load', () => recalculateWidth($menu, $sidebar));

    function removeSocialButtons() {
      const width = 1200;
      if (window.innerWidth >= width && stickySocialButtons.isActive) {
        // recalculateWidth($posts, $sidebar);
      } else if (window.innerWidth >= width && !stickySocialButtons.isActive) {
        stickySocialButtons.init();
        $main.appendChild($socialButtons);
      } else if (window.innerWidth < width && stickySocialButtons.isActive) {
        stickySocialButtons.remove();
        $article.appendChild($socialButtons);
      }
    }

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
