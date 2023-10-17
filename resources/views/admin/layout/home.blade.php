<h2>admin home page</h2>
<form action="{{route('logout')}}" method="post">
    @csrf
    <button type="submit">
        logout
    </button>
</form>
