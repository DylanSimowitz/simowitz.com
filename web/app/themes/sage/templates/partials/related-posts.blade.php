  @php
    $terms = get_the_terms( $post->ID , 'wplawyer-practice-area', 'string');
    $term_ids = wp_list_pluck($terms,'term_id');
    $args = array(
      'post__not_in' => array($post->ID),
      'posts_per_page' => 2,
      'tax_query' => array(
        array(
          'taxonomy' => 'wplawyer-practice-area',
          'field' => 'id',
          'terms' => $term_ids
        )
      )
    )
  @endphp
  <aside class="sidebar--posts">
    <h3 class="sidebar--posts__header">Related Posts</h3>
    <div class="related-posts">
      @query($args)
        @include('partials.post-card', ['short' => 'true'])
      @endquery
      @php(wp_reset_postdata())
    </div>
  </aside>
