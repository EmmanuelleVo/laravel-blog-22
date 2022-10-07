<section class="px-8 mt-10">
    <h3 class="mb-4 text-xl font-bold text-gray-700">Recent Post</h3>
    <div class="flex flex-col max-w-sm px-8 py-6 mx-auto bg-white rounded-lg shadow-md">
        <div class="flex items-center justify-center">
            @foreach($post->categories as $category)
                <a href="/categories/{{ $category->slug }}"
                   class="px-2 py-1 text-sm text-green-100 bg-gray-600 rounded hover:bg-gray-500">
                    {{ ucwords($category->name) }}
                </a>
            @endforeach
        </div>
        <div class="mt-4">
            <a href="/posts/{{ $post->slug }}"
               class="font-bold text-lg font-medium text-gray-700 hover:underline">{{ $post->title }}</a>
        </div>
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center"><img
                    src="{{ $post->user->avatar }}"
                    alt="avatar"
                    class="object-cover w-8 h-8 rounded-full">
                <a href="/authors/{{ $post->user->slug }}"
                   class="font-bold mx-3 text-sm text-gray-700 hover:underline">{{ ucwords($post->user->name) }}</a>
            </div>
            <span class="text-sm font-light text-gray-600">{{ $post->published_at }}</span>
        </div>
    </div>
</section>
