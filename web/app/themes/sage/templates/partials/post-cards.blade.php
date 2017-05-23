@if (!have_posts())
  <div class="alert alert-warning">
    {{ __('Sorry, no results were found.', 'sage') }}
  </div>
  {!! get_search_form(false) !!}
@endif
@php
  $args = array(
    'posts_per_page' => 10
  )
@endphp
<div class="post-cards-container">
  <div class="post-cards">
    @query($args)
      @include('partials.post-card')
    @endquery
  </div>
</div>
