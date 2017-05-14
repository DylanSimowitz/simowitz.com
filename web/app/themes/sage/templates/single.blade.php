@extends('layouts.base')

@section('content')
  @include('partials.featured-image')
  @while(have_posts()) @php(the_post())
    @include('partials/content-single-'.get_post_type())
  @endwhile
@endsection

