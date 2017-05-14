@extends('layouts.base')

@section('content')
  @include('partials.featured-image')
  <section class="main">
    <aside class="sidebar">
      @php(dynamic_sidebar('sidebar-practices'))
    </aside>
    {{-- <aside class="sidebar--contact"> --}}
      {{-- <ul> --}}
        {{-- <li><a href="tel:{{the_field('phone', 'options')}}">{{the_field('phone', 'options')}}</a></li> --}}
        {{-- <li><a href="mailto:{{get_option('admin_email')}}">{{get_option('admin_email')}}</a></li> --}}
      {{-- </ul> --}}
    {{-- </aside> --}}
    <article>
      @if(have_posts()) @while(have_posts()) @php(the_post())
      {{the_content()}}
      @endwhile @endif
    </article>
  </section>
@endsection
