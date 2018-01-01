@extends('layouts.app')

@section('title','- Sites')
@section('content')
<h3>Campaign Images and Links</h3>
@foreach($media as $row)
<div class="image">
{{ $img }}
</div>
@endforeach
<h3>Links</h3>
@foreach($links as $link)
<div class="link-block">
    {{ $link }}
</div>
@endforeach
@endsection