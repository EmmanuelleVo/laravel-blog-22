<x-header></x-header>
<div class="px-6 py-8">
    <div class="container flex justify-between mx-auto">
        <div class="w-full">
            <h1 class="text-center font-extrabold lg:uppercase">Register</h1>
        </div>
    </div>
</div>
<main class="px-6 py-8">
    <div class="container flex justify-between mx-auto">
        <div class="w-full lg:w-8/12">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold text-gray-700 md:text-2xl">Register to the blog</h1>
            </div>
            <div class="mt-6">
                <form action="/register"
                      method="post">

                    @csrf

                    <label for="name"
                           class="block mb-2 @error('name') text-red-600 @enderror">Name</label>
                    @error('name')
                    <div class="text-red-600 py-1">{{ $message }}</div>
                    @enderror
                    <input id="name"
                           type="text"
                           name="name"
                           class="p-4 w-full rounded-md shadow-sm @error('name') outline outline-red-400 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           value="{{old('name')}}">

                    <label for="email"
                           class="block mt-8 mb-2 @error('email') text-red-600 @enderror">Email</label>
                    @error('email')
                    <div class="text-red-600 py-1">{{ $message }}</div>
                    @enderror
                    <input id="email"
                           type="text"
                           name="email"
                           class="p-4 w-full rounded-md shadow-sm @error('email') outline outline-red-400 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           value="{{old('email')}}">

                    <label for="password"
                           class="block mt-8 mb-2 @error('password') text-red-600 @enderror">Password</label>
                    @error('password')
                    <div class="text-red-600 py-1">{{ $message }}</div>
                    @enderror
                    <input name="password"
                           type="password"
                           id="password"
                           rows="5"
                           class="p-4 w-full rounded-md border-gray-300 shadow-sm @error('password') outline outline-red-400 @enderror focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           value="{{old('password')}}">
                    <button type="submit"
                            class="float-right mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                        Login
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
