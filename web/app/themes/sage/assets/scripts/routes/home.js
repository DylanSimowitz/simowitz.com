import Flickity from 'flickity';
// import _ from 'lodash';

let heroSlider;
// let awardSlider;

export default {

  init() {
    // JavaScript to be fired on the home page
    heroSlider = new Flickity('.slider', {
      cellSelector: '.slider__slide',
      draggable: false,
      // dragThreshold: 10,
      // touchVerticalScroll: false,
      wrapAround: true,
      prevNextButtons: true,
    });
    // awardSlider = new Flickity('.awards', {
      // cellSelector: '.award',
      // draggable: false,
      // wrapAround: true,
      // prevNextButtons: false,
      // autoPlay: 3000,
      // friction: 0.5,
      // pageDots: false,
      // watchCSS: true,
    // });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
    jQuery(window).on('load', () => {
      heroSlider.resize();
      // awardSlider.resize();
      jQuery('.slider__slide').addClass('resizing');
    });
    jQuery(window).on('resize', () => {
      jQuery('.slider__slide').removeClass('resizing');
      heroSlider.resize();
      // awardSlider.resize();
      jQuery('.slider__slide').addClass('resizing');
    });
  },
};
