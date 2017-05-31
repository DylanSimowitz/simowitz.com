import Masonry from 'masonry-layout';

export default {
  init() {
    window.addEventListener('load', () => {
      new Masonry('.post-cards', {
        itemSelector: '.post-card',
        columnWidth: '.post-card',
        gutter: 30,
        horizontalOrder: true,
        isFitWidth: true,
      });
    });
  },
};
