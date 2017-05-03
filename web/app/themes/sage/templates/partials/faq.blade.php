<section class="faq-section">
<aside class="sidebar">
  @php(dynamic_sidebar('sidebar-practices'))
</aside>
<div class="faq-container">
  <div class="accordion">
    @if(have_rows('questions'))
      @while(have_rows('questions'))
        @php(the_row())
        <div class="faq-question">
          <div>
            <h4>{{the_sub_field('question')}}</h4>
          </div>
          <div>
            {{the_sub_field('answer')}}
          </div>
        </div>
      @endwhile
    @endif
    <div class="faq-question">
      <div>
        <h4>What is the entire process?</h4>
      </div>
      <div>
        @include('partials.legal-process')
      </div>
    </div>
  </div>
</div>
</section>
