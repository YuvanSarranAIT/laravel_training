<!DOCTYPE html>
<html>
<head>
    <title>JWT Role Based Auth</title>
</head>
<body>
    <nav>
        <a href="/dashboard">Dashboard</a> |
        <a href="/items">Items</a> |
        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </nav>

    <hr>

    @yield('content')
</body>
</html>
