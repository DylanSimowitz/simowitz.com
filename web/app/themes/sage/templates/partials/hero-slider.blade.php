<div class="slider__container">
  <div class="slider"> 
  @if(have_rows('create_slider', 'option'))
    @while(have_rows('create_slider', 'option'))
      @php(the_row())
      @if(get_sub_field('slider_name') == get_field('select_slider'))
        @while(have_rows('slider', 'option'))
        @php(the_row())
          <div class="slider__slide" style="background-image: url({{the_sub_field('background_image')}}); flex-direction: {{the_sub_field('image_position')}}">
            <div class="slider__info-text">
              <h2>{{the_sub_field('heading')}}</h2>
              {{the_sub_field('tagline')}}
              @if(get_sub_field('label'))
              <div class="slider__CAB">
                <a href="@php get_sub_field('link_type') == 'page' ? the_sub_field('link') : the_sub_field('url') @endphp" class="btn--action">{{the_sub_field('label')}}</a>
              </div>
              @endif
            </div>
            <div class="slider__image">
              @if(get_sub_field('image'))
                <img src="{{get_sub_field('image')['url']}}" alt="{{get_sub_field('image')['alt']}}">
              @endif
            </div>
          </div>
        @endwhile
      @endif
    @endwhile
  @endif
  </div>
</div>
