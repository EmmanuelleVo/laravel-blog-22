<x-header></x-header>
<div class="flex items-center justify-between">
    <h1 class="text-xl font-bold text-gray-700 md:text-2xl">All authors</h1>
</div>
<ul>
    @foreach($users as $user)
        <li>
            <a href="/authors/{{$user->slug}}">{{ $user->name }}</a>
        </li>
    @endforeach
</ul>
<div class="mt-6">
    {{ $posts->links() }}
</div>
<x-footer></x-footer>
</body>
</html>
