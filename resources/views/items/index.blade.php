@extends('layout')

@section('content')
<h2>Items List</h2>

@can('create', App\Models\Item::class)
    <a href="{{ route('items.create') }}">+ Add Item</a>
@endcan

<ul>
@foreach ($items as $item)
    <li>{{ $item->title }}
        @can('update', $item)
            <a href="{{ route('items.edit', $item->id) }}">Edit</a>
        @endcan
        @can('delete', $item)
            <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button>Delete</button>
            </form>
        @endcan
    </li>
@endforeach
</ul>
@endsection
