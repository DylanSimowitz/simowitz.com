<aside class="social-buttons">
  @php
    $sites = array(
      'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=',
      'twitter' => 'https://twitter.com/intent/tweet?source=',
      'google-plus' => 'https://plus.google.com/share?url=',
      'envelope' => 'mailto:?subject='
    )
  @endphp
  @foreach($sites as $name => $url)
    <a target="_blank" class="btn--social social-buttons__{{$name}}" href="{{$url}}{{urlencode(get_permalink())}}"><i class="fa fa-{{$name}}"></i></a>
  @endforeach
</aside>
