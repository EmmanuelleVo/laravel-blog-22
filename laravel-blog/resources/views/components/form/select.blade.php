<label for="post-category"
       class="block mt-8 mb-2 @error('post-category') text-red-600 @enderror">Post Category</label>
@error('post-category')
<div class="text-red-600 py-1">{{ $message }}</div>
@enderror
<select name="post-category[]"
        id="post-category"
        multiple
        class="w-full @error('post-category') outline outline-red-400 @enderror border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    @foreach($categories as $category)
        <option value="{{ $category->id }}">
            {{ $category->name }}
        </option>
    @endforeach
</select>
