<form action="{{ url('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>