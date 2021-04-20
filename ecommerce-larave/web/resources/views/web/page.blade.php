@extends('web.layout')
@section('content')

<section class="aboutus-content aboutus-content-one">
  <div class="container">
    <div class="heading">
      <h2>
      <?=$result['pages'][0]->name?>
      </h2>
      <hr style="margin-bottom: 10;">
    </div>
  <?=stripslashes($result['pages'][0]->description)?>     
  </div>

</section>

@endsection
