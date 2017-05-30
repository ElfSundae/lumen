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
  console.log('Hello, world!');
</script>
@endpush

@section('body')
<h3>{{ app()->version() }}</h3>
@endsection
