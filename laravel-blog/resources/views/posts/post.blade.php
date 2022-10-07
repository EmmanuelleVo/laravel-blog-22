<x-header></x-header>
<article class="w-full lg:w-10/12">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-700 md:text-2xl">{{ $post->title }}</h2>
    </div>
    <div class="mt-6">
        <div class="max-w-4xl px-10 py-6 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <a href="/authors/{{ $post->user->slug }}"
                   class="flex items-center justify-end"><img
                        src="{{ $post->user->avatar }}"
                        alt="avatar"
                        class="hidden object-cover w-10 h-10 mr-4 rounded-full sm:block">
                    <span
                        class="font-bold text-gray-700 hover:underline">{{ ucwords($post->user->name) }}</span>
                </a>
                @foreach ($post->categories as $category)
                    <a href="/categories/{{ strtolower($category->slug) }}"
                       class="px-2 py-1 font-bold text-gray-100 bg-gray-600 rounded hover:bg-gray-500">{{ ucwords($category->name) }}</a>
                @endforeach
            </div>
            <div class="my-4">
                <span class="font-light text-gray-600">
                    {{ $post->published_at }}
                </span>
            </div>
            <div class="mt-2 text-gray-600">
                {!! $post->body !!}
            </div>
        </div>
    </div>
    <div class="mt-6">
        <div class="max-w-4xl px-10 py-6 mx-auto bg-white rounded-lg shadow-md">
            <h3 class="text-l font-bold text-gray-700 md:text-2xl">Post comments : </h3>
            <ul>
                @foreach($post->comments as $comment)
                    <li>{{ $comment->body }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</article>
<x-footer></x-footer>
</div>

</body>
</html>
