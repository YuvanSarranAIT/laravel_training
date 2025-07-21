@extends('layout')

@section('content')
<h2>Edit Item</h2>

<form method="POST" action="{{ route('items.update', $item->id) }}">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $item->title }}"><br>
    <textarea name="description">{{ $item->description }}</textarea><br>
    <button type="submit">Update</button>
</form>
@endsection
