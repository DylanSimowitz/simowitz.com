<div class="featured-image">
  {{-- <div id="featured-image" style="background-image: url({{the_post_thumbnail_url()}})"></div> --}}
  
  @if(is_page('contact'))
  <img id="featured-image" src="https://maps.googleapis.com/maps/api/staticmap?&zoom=12&size=640x640&scale=2&maptype=roadmap&markers=color:red%7C{{urlencode(get_field('street', 'options'))}}&key={{get_field('google_maps_key', 'options')}}" alt="">
  @else
  <img id="featured-image" src="{{the_post_thumbnail_url()}}" alt="">
  @endif
    <div class="featured-image__meta">
      <h2 class="featured-image__page-title">{{the_title()}}</h2>
      @if(is_single())
      @php(setPostViews(get_the_ID()))
        <span class="meta__views">{{getPostViews(get_the_ID())}} views</span>
        <span class="meta__date">{{the_time('F j, Y')}}</span>
      @endif
    </div>
</div>
<div class="sticky--hide"></div>
