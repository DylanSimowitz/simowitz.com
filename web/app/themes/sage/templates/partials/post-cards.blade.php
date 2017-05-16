@if (!have_posts())
  <div class="alert alert-warning">
    {{ __('Sorry, no results were found.', 'sage') }}
  </div>
  {!! get_search_form(false) !!}
@endif
<div class="post-cards-container">
  <div class="post-cards">
    @posts
      @include('partials.post-card')
    @endposts
  </div>
</div>
