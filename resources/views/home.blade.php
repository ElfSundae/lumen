@extends('layouts.master', ['title' => 'Home'])

@include('partials.api-token')

@push('css')
<style type="text/css">
  code {
    color: blue;
  }
  .red {
    color: red;
  }
</style>
@endpush

@push('js')
<script>
  $(function() {
    $.getJSON('/api/version', function(data) {
      $('.version').text(data.version);
    });

    $('.refresh-token-btn').click(function(e) {
      $.post('/api/token/refresh', function(data) {
        $(e.target).parent().find('code').text(JSON.stringify(data, null, 2));
      });
    }).trigger('click');
  })
</script>
@endpush

@section('body')
<center>
  <h3 class="version">...</h3>
  <hr>
  <p>Environment: <b class="red">{{ app()->environment() }}</b></p>
</center>
<div>
  <button class="refresh-token-btn">Refresh Api Token</button>
  <pre><code></code></pre>
</div>
@endsection
