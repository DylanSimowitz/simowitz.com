<div class="awards">
  @if(have_rows('awards'))
    @while(have_rows('awards'))
      @php(the_row())
      @php($post_object = get_sub_field('award'))
      @if($post_object)
        <?php
          global $post;
          $post = $post_object;
          setup_postdata($post)
        ?>
        <div class="award">
            <img src="{{get_field('image')['url']}}" alt="{{get_field('image')['alt']}}">
        </div>
        @php(wp_reset_postdata())
      @endif
    @endwhile
  @endif
</div>
