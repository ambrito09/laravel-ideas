<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="/">
                <x-logo-svg />
            </a>
        </div>

        <div class="flex gap-5 items-center">
            @guest
                <a href="/login">Sign in</a>
                <a href="/register" class="btn">Register</a>
            @endguest
            @auth
                <a href="{{ route('profile.edit') }}">My Profile</a>
                <form action="/logout" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-red" data-test="logout-button">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>
