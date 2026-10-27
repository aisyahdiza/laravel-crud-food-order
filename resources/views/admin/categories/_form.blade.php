<div>
    <label for="name" class="mb-2 block text-sm font-medium text-terracotta">Category name</label>
    <input id="name" name="name" type="text"
            value="{{ old('name', $category->name ?? '') }}"
            placeholder="Example: Main Course"
            class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown"
            required autofocus>
    @error('name')
        <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
    @enderror
</div>