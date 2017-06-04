@extends('layouts.master', ['title' => 'Home'])

@include('partials.api-token')

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
    $.getJSON('/api/version', function(data) {
      $('.version').html(data.version);
    });
  })
</script>
@endpush

@section('body')
<h3 class="version">...</h3>
<hr>
Environment: <b>{{ app()->environment() }}</b>
@endsection
