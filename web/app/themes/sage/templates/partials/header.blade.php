<header class="banner">
  <div class="container">
    <nav class="header Fixed">
      <button class="nav-button"></button>
      {{-- <div class="phone"> --}}
        {{-- <i class="fa fa-phone"></i> --}}
        {{-- <a href="tel:{{the_field('phone', 'options')}}">{{the_field('phone', 'options')}}</a> --}}
      {{-- </div> --}}
      <div class="brand">
        {{-- <a class="brand" href="{{ home_url('/') }}"> --}}
          {{-- @if(get_field('logo', 'options')) --}}
            {{-- <img class="brand__logo" src=" --}}
            {{-- {{get_field('logo', 'options')['url']}}" --}}
            {{-- alt="{{get_field('logo', 'options')['alt']}}"> --}}
          {{-- @else --}}
            {{-- <img class="brand__logo inject-svg" src=" --}}
            {{-- {{get_template_directory_uri().'/assets/images/logo.svg'}}" --}}
            {{-- alt="logo"> --}}
          {{-- @endif --}}
          <div class="brand__text">
            <span class="brand__name">
            @if (get_field('company_name', 'options'))
              {{ the_field('company_name', 'options') }}
            @else
              {{ get_bloginfo('name', 'display') }}
            @endif
            </span>
            {{-- <p class="brand__slogan">{{the_field('company_slogan', 'options')}}</p> --}}
          </div>
        {{-- </a> --}}
      </div>
      <nav class="nav-primary">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
    </nav>
  </div>
</header>
