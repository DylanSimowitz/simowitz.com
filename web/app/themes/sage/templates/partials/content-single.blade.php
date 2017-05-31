<section class="main">
  @if(has_term('','wplawyer-practice-area'))
    @include('partials.related-posts')
  @endif
  <article @php(post_class())>
    <span class="post__author">
      By {{the_author_posts_link()}}
    </span>
    <div class="entry-content">
      @php(the_content())
    </div>
    @php(comments_template('/templates/partials/comments.blade.php'))
  </article>
  @include('partials.social-buttons')
</section>
