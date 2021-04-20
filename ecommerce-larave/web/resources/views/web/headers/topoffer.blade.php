@if($result['commonContent']['top_offers'])
  @if($result['commonContent']['top_offers']->top_offers_text)
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <div class="container">
        <div class="pro-description">
          <div class="pro-info">
            @php echo stripslashes($result['commonContent']['top_offers']->top_offers_text); @endphp
          </div>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
        </div>

    </div>
  </div>
  @endif
@endif
