<figure class="post-card">
  <!-- <img class="post-card__image" src="{{the_post_thumbnail_url()}}" alt=""> -->
  {{the_post_thumbnail('medium', ['class' => 'post-card__image'])}}
  <div class="post-card__date"><span class="post-card__day">{{the_time('d')}}</span><span class="post-card__month">{{the_time('M')}}</span></div>
  <figcaption>
    <h3 class="post-card__title">{{the_title()}}</h3>
    <p class="post-card__excerpt">
      @if(isset($short))
        {{mb_strimwidth(get_the_content(), 0, 150, '&hellip;')}}
      @else
        {{the_excerpt()}}
      @endif
    </p>
    <button>Read More</button>
  </figcaption><a href="{{the_permalink()}}"></a>
</figure>
