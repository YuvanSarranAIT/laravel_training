@extends('layout')

@section('content')
<h2>Create Item</h2>

<form method="POST" action="{{ route('items.store') }}">
    @csrf
    <input type="text" name="title" placeholder="Title"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <button type="submit">Create</button>
</form>
@endsection
