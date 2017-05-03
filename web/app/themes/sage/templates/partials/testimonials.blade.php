<div class="testimonials__container">
  <div class="testimonials">
    @if(have_rows('testimonials'))
      @while(have_rows('testimonials'))
        @php(the_row())
        @php($post_object = get_sub_field('testimonial'))
        @if($post_object)
          <?php
            global $post;
            $post = $post_object;
            setup_postdata($post)
          ?>
        <div class="testimonial__card card">
          @if(get_field('image'))
          <div class="testimonial__image">
            <img src="{{get_field('image')['url']}}" alt="">
          </div>
          @endif
          <div class="testimonial__content">
            <h4>{{$post -> post_title}}</h4>
            <p>{{$post -> post_content}}</p>
            <div class="testimonial__rating">
              @for($i=0; $i<get_field('rating'); $i++)
              <i class="fa fa-star rating--true"></i>
              @endfor
              @for($i=0; $i<5-get_field('rating'); $i++)
              <i class="fa fa-star rating--false"></i>
              @endfor
            </div>
          </div>
        </div>
          @php(wp_reset_postdata())
        @endif
      @endwhile
    @endif 
  </div>
</div>
