import Sticky from '../util/sticky';
import Parallax from '../util/parallax';
import {recalculateWidth} from '../util/helpers';
import {debounce} from 'lodash';

export default {
  init() {
    const $posts = document.querySelector('.related-posts');
    const $sidebar = document.querySelector('.sidebar--posts');
    const $socialButtons = document.querySelector('.social-buttons');
    const $main = document.querySelector('section.main');
    // const $article = document.querySelector('article');

    new Parallax('#featured-image').init();
    const stickySocialButtons = new Sticky($socialButtons, $main, 150, 50, debounce(removeSocialButtons, 250));
    const stickySidebar = new Sticky($posts, $sidebar, 0, 0, debounce(removeSidebar, 250));

    stickySidebar.init();
    stickySocialButtons.init();

    window.addEventListener('load', () => {
      removeSocialButtons();
      removeSidebar();
    });


    function removeSocialButtons() {
      if (window.innerWidth >= 992 && stickySocialButtons.isActive) {
        // recalculateWidth($posts, $sidebar);
      } else if (window.innerWidth >= 992 && !stickySocialButtons.isActive) {
        stickySocialButtons.init();
      } else if (window.innerWidth < 992 && stickySocialButtons.isActive) {
        stickySocialButtons.remove();
      }
    }

    function removeSidebar() {
      if (window.innerWidth >= 992 && stickySidebar.isActive) {
        recalculateWidth($posts, $sidebar);
      } else if (window.innerWidth >= 992 && !stickySidebar.isActive) {
        stickySidebar.init();
        recalculateWidth($posts, $sidebar);
      } else if (window.innerWidth < 992 && stickySidebar.isActive) {
        stickySidebar.remove();
        $posts.style.width = '';
      }
    }
  },
};
