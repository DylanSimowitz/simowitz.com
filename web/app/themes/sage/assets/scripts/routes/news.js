import Masonry from 'masonry-layout';
import {MasonryGridPosts} from '../util/helpers';


export default {
  init() {
    const $gridElement = document.querySelector('.post-cards');
    window.addEventListener('load', () => {
      const msnry = new Masonry($gridElement, {
        itemSelector: '.post-card',
        columnWidth: '.post-card',
        gutter: 20,
        horizontalOrder: true,
        fitWidth: true,
      });
      new MasonryGridPosts(msnry);
    });
  },
};
