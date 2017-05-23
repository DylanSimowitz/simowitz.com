import {throttle} from 'lodash';
import {postCardTemplate, postsLoadingTemplate} from '../components/templates';

export function getElement(element) {
  if (element.nodeType) {
    return element;
  } else if (typeof element === 'string') {
    return document.querySelector(element);
  } else {
    return undefined;
  }
}

export function recalculateWidth(child, parent) {
    child.style.width = parent.offsetWidth + 'px';
}


export class MasonryGridPosts {
  constructor(grid) {
    this.grid = grid;
    this.element = grid.element;
    this.parent = grid.element.parentElement;
    this.postsCollection = new wp.api.collections.Posts();
    this.loaderElement = postsLoadingTemplate();
    this.per_page = 10;
    this.init();
  }

  init() {
    window.addEventListener('scroll', throttle(this.onScroll.bind(this), 500));
    window.addEventListener('load', this.onLoad.bind(this));
  }

  onLoad() {
    this.grid.layout();
  }

  appendPosts(posts) {
    this.loader = false;
    for(let i = 0; i < posts.length; i++) {
      let post = postCardTemplate(posts[i]);
      this.element.appendChild(post);
      this.grid.appended(post);
      this.grid.layout();
    }
  }

  fetchPosts() {
    const hasMorePost = this.postsCollection.hasMore();
    switch(hasMorePost) {
      case true:
        this.loader = true;
        this.postsCollection.more().then(posts => this.appendPosts(posts));
        break;
      case null:
        if (this.grid.getItemElements().length >= this.per_page) {
          this.loader = true;
          this.postsCollection.fetch({data: {per_page: this.per_page, page: 2, _embed: true}}).then(posts => this.appendPosts(posts));
        }
        break;
      case false:
        this.loader = false;
        break;
      default:
        this.loader = false;
        break;
    }
  }

  set loader(value) {
    if (value) {
      this.parent.appendChild(this.loaderElement);
    } else {
      this.parent.removeChild(this.loaderElement);
    }
  }

  onScroll() {
    if (this.parent.getBoundingClientRect().bottom - 200 <= window.innerHeight) {
      this.fetchPosts();
    }
  }

}
