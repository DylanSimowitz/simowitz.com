// import external dependencies
import 'jquery';

// import local dependencies
import Router from './util/router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import faq from './routes/faq';
import pageTemplatePracticeareaBlade from './routes/practicearea';
import blog from './routes/news';
import singlePost from './routes/single-post';
import archive from './routes/archive';
import contact from './routes/contact';

// Use this variable to set up the common and page specific functions. If you
// rename this variable, you will also need to rename the namespace below.
const routes = {
  // All pages
  common,
  // Home page
  home,
  // About us page, note the change from about-us to aboutUs.
  aboutUs,
  // FAQ page
  faq,
  // News page
  blog,
  // Practice pages
  pageTemplatePracticeareaBlade,
  // Single post page
  singlePost,
  // Archive page
  archive,
  // Contact page
  contact,
};

// Load Events
jQuery(document).ready(() => {
  new Router(routes).loadEvents();
});
