<div class="process-container">
  {{-- <h2>The Legal Process</h2> --}}
  @if(have_rows('steps', 'options'))
    @while(have_rows('steps', 'options'))
      @php(the_row())
      
    <div class="process" style="background-image: url({{the_sub_field('background_image')}})">
      <div class="process__step {{get_row_index() % 2 ? 'process__step--left' : 'process__step--right'}}">
      {{-- <div class="process__step process__step--right"> --}}
        <h3>{{the_sub_field('title')}}</h3>
        <p>{{the_sub_field('description')}}</p>
      </div>
    </div>
    @endwhile
  @endif
</div>
