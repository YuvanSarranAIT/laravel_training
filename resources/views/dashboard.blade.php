<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Dashboard</h2>
    <p>Welcome to your dashboard</p>
    <a href="{{ route('logout') }}">Logout</a>

    <hr>

    <h3>Items</h3>
    @if(count($items))
        <ul>
            @foreach($items as $item)
                <li>
                    <strong>{{ $item['title'] }}</strong><br>
                    {{ $item['description'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No items found.</p>
    @endif
</body>
</html>
