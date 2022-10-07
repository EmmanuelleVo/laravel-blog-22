<section class="px-8">
    <h3 class="mb-4 text-xl font-bold text-gray-700">Authors</h3>
    <div class="flex flex-col max-w-sm px-6 py-4 mx-auto bg-white rounded-lg shadow-md">
        <ul class="-mx-4">
            @foreach ($users as $user)
                <li class="flex items-center mb-3"><img
                        src="<?= $user->avatar ?>"
                        alt="avatar"
                        class="object-cover w-10 h-10 mx-4 rounded-full">
                    <p><a href="/authors/{{ $user->slug }}"
                          class="mx-1 font-bold text-gray-700 hover:underline">{{ ucwords($user->name) }}</a>
                        <span class="text-sm font-light text-gray-700">Created {{ $user->posts_count }} posts</span> and
                        <span class="text-sm font-light text-gray-700">as posted {{ $user->comments_count }} comments</span>
                    </p>
                </li>
            @endforeach
        </ul>
        @if(request()->has('authors'))
            <a href="posts" class="text-blue-500 hover:underline">Show less >></a>
        @else
            <a href="?authors" class="text-blue-500 hover:underline">Show more >></a>
        @endif
    </div>
</section>
