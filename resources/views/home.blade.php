@extends('layouts.master', ['title' => 'Home'])

@push('head')
@include('partials.api-token-meta')
@endpush

@push('js')
@include('partials.api-token-ajax')
@endpush

@push('css')
<style type="text/css">
  body {
    text-align: center;
  }
</style>
@endpush

@push('js')
<script>
  $(function() {
    $.getJSON('/api/version', null, function(data) {
      $('.version').html(data.version);
    })
  })
</script>
@endpush

@section('body')
<h3 class="version">...</h3>
<hr>
Environment: <b>{{ app()->environment() }}</b>
@endsection
