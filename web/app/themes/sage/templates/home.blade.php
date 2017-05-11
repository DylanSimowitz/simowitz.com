@extends('layouts.base')

@section('content')
  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif
  <div class="post-cards-container">
    <div class="post-cards">
      @while (have_posts()) @php(the_post())
        <figure class="post-card">
        {{the_post_thumbnail('medium', array('class' => 'post-card__image'))}}
          <div class="post-card__date"><span class="post-card__day">{{the_time('d')}}</span><span class="post-card__month">{{the_time('M')}}</span></div>
          <figcaption>
            <h3 class="post-card__title">{{the_title()}}</h3>
            <p class="post-card__excerpt">
              {{mb_strimwidth(get_the_content(), 0, 150, '&hellip;')}}
            </p>
            <button>Read More</button>
          </figcaption><a href="{{the_permalink()}}"></a>
        </figure>
      @endwhile
    </div>
  </div>

  {!! get_the_posts_navigation() !!}
@endsection
