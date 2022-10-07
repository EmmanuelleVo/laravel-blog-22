<x-header></x-header>
<div class="flex items-center justify-between">
    <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Posts from {{ $user->name }}</h1>
</div>
@foreach ($user->posts as $post)
    <article class="mt-6">
        <div class="max-w-4xl px-10 py-6 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                                        <span class="font-light text-gray-600">
                                            {{ $post->published_at }}
                                        </span>
                @foreach ($post->categories as $category)
                    <a href="/categories/{{ $category->slug }}"
                       class="px-2 py-1 font-bold text-gray-100 bg-gray-600 rounded hover:bg-gray-500">
                        {{ ucwords($category->name) }}
                    </a>
                @endforeach
            </div>
            <h2 class="mt-2">
                <a href="/posts/{{ $post->slug }}"
                   class="text-2xl font-bold text-gray-700 hover:underline">
                    {{ $post->title }}
                </a>
                <p class="mt-2 text-gray-600">{{ $post->excerpt }}</p>
            </h2>
            <div class="flex items-center justify-between mt-4">
                <a href="/posts/{{ $post->slug }}"
                   class="text-blue-500 hover:underline">
                    Read more<span class="sr-only"> about {{ $post->title }}</span>
                </a>
                <div>
                    <a href="/authors/{{ $post->user->slug }}"
                       class="flex items-center">
                        <img src="{{ $post->user->avatar }}"
                             alt="{{ $post->user->name }}"
                             class="hidden object-cover w-10 h-10 mx-4 rounded-full sm:block">
                        <span class="font-bold text-gray-700 hover:underline">{{ ucwords($post->user->name) }}</span>
                    </a></div>
            </div>
        </div>
    </article>
@endforeach
<x-footer></x-footer>
</body>
</html>
