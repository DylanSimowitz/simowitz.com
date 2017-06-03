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
    const $article = document.querySelector('article');

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
      const width = 992;
      if (window.innerWidth >= width && stickySidebar.isActive) {
        recalculateWidth($posts, $sidebar);
      } else if (window.innerWidth >= width && !stickySidebar.isActive) {
        stickySidebar.init();
        recalculateWidth($posts, $sidebar);
      } else if (window.innerWidth < width && stickySidebar.isActive) {
        stickySidebar.remove();
        $posts.style.width = '';
      }
    }
  },
};
