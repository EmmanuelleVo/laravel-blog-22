<x-header></x-header>
<div class="flex items-center justify-between">
    <h1 class="text-xl font-bold text-gray-700 md:text-2xl">All categories</h1>
</div><ul>
    @foreach($categories as $category)
        <li>
            <a href="/categories/{{$category->slug}}">{{ $category->name }}</a>
        </li>
    @endforeach
</ul>

<x-footer></x-footer>
</body>
</html>
