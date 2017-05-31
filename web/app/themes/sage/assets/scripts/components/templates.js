import moment from 'moment'

export function postCardTemplate(postObject) {
  const element = document.createElement('figure');
  element.classList.add('post-card')
  element.innerHTML = `
      <img class="post-card__image wp-post-image" width="300" height="200" src="${postObject._embedded['wp:featuredmedia'][0].source_url}"/>
      <div class="post-card__date">
        <span class="post-card__day">${moment(postObject.date).format('DD')}</span>
        <span class="post-card__month">${moment(postObject.date).format('MMM')}</span>
      </div>
      <figcaption>
        <h3 class="post-card__title">${postObject.title.rendered}</h3>
        <p class="post-card__excerpt">
          ${postObject.excerpt.rendered}
        </p>
        <button>Read More</button>
      </figcaption><a href="${postObject.link.replace(/https?:\/\/[^\/]+/i, "")}"></a>
  `
  return element;
}

export function postsLoadingTemplate() {
  const element = document.createElement('div');
  element.classList.add('post-cards__loading')
  element.innerHTML = `
    <i class="fa fa-circle-o-notch fa-spin"></i><span> Loading</span>
  `
  return element;
}
