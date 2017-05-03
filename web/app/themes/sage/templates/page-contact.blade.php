@extends('layouts.base')

@section('content')
  <div class="featured-image" style="background-position: center 30%; background-image: url(https://maps.googleapis.com/maps/api/staticmap?&zoom=12&size=640x640&scale=2&maptype=roadmap&markers=color:red%7C{{urlencode(get_field('street', 'options'))}}&key={{get_field('google_maps_key', 'options')}})">
    <h2 class="page-title">{{the_title()}}</h2>
  </div>
  <div class="sticky--hide"></div>
  <section class="main">
    <aside class="sidebar">
      @php(dynamic_sidebar('sidebar-practices'))
    </aside>
    <aside class="sidebar--contact">
      <ul>
        <li><a href="tel:{{the_field('phone', 'options')}}">{{the_field('phone', 'options')}}</a></li>
        <li><a href="mailto:{{get_option('admin_email')}}">{{get_option('admin_email')}}</a></li>
      </ul>
    </aside>
    <article>
      @if(have_posts()) @while(have_posts()) @php(the_post())
      {{the_content()}}
      @endwhile @endif
    </article>
  </section>
@endsection
