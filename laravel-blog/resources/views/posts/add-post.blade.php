


<x-header></x-header>
<div class="px-6 py-8">
    <div class="container flex justify-between mx-auto">
        <div class="w-full">
            <h1 class="text-center font-extrabold lg:uppercase">Create Post</h1>
        </div>
    </div>
</div>
<main class="px-6 py-8">
    <div class="container flex justify-between mx-auto">
        <div class="w-full lg:w-8/12">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Create Post</h1>
            </div>
            <div class="mt-6">
                <form action="/posts/create"
                      method="post">

                    @csrf

                    <label for="title"
                           class="block mb-2 @error('title') text-red-600 @enderror">Post Title</label>
                    @error('title')
                    <div class="text-red-600 py-1">{{ $message }}</div>
                    @enderror
                    <input id="title"
                           type="text"
                           name="title"
                           class="p-4 w-full rounded-md shadow-sm @error('title') outline outline-red-400 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           value="{{old('title')}}">

                    <label for="excerpt"
                           class="block mb-2 mt-8 @error('excerpt') text-red-600 @enderror">Post Excerpt</label>
                    @error('excerpt')
                    <div class="text-red-600 py-1">{{ $message }}</div>
                    @enderror
                    <textarea id="excerpt"
                              name="excerpt"
                              rows="5"
                              class="p-4 w-full rounded-md shadow-sm @error('excerpt') outline outline-red-400 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{old('excerpt')}}</textarea>

                    <label for="body"
                           class="block mb-2 mt-8 @error('body') text-red-600 @enderror">Post Body</label>
                    @error('body')
                    <div class="text-red-600 py-1">{{ $message }}</div>
                    @enderror
                    <textarea id="body"
                              name="body"
                              rows="5"
                              class="p-4 w-full rounded-md shadow-sm @error('body') outline outline-red-400 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{old('body')}}</textarea>

                    <x-form.select></x-form.select>

                    <button type="submit"
                            class=" mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                        Create new post
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
<x-footer></x-footer>
</div>
</body>
</html>
