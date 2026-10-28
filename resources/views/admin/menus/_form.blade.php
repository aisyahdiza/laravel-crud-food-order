@php $menu = $menu ?? null; @endphp

<div class="space-y-5" x-data="{ preview: @js($menu?->image_url) }">

    {{-- Category --}}
    <div>
        <label for="category_id" class="mb-2 block text-sm font-medium text-terracotta">Category</label>
        <select id="category_id" name="category_id" required
                class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">
            <option value="">Choose a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $menu?->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
        @enderror
    </div>

    {{-- Name --}}
    <div>
        <label for="name" class="mb-2 block text-sm font-medium text-terracotta">Menu name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $menu?->name) }}"
                placeholder="Example: Special Fried Rice" required
                class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">
        @error('name')
            <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label for="description" class="mb-2 block text-sm font-medium text-terracotta">Description</label>
        <textarea id="description" name="description" rows="3" maxlength="255"
                    placeholder="Short description of the dish..."
                    class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">{{ old('description', $menu?->description) }}</textarea>
        @error('description')
            <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
        @enderror
    </div>

    {{-- Price --}}
    <div>
        <label for="price" class="mb-2 block text-sm font-medium text-terracotta">Price (Rp)</label>
        <input id="price" name="price" type="number" min="0" step="1"
                value="{{ old('price', $menu ? (int) $menu->price : '') }}"
                placeholder="25000" required
                class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">
        @error('price')
            <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
        @enderror
    </div>

    {{-- Photo --}}
    <div>
        <label for="image" class="mb-2 block text-sm font-medium text-terracotta">Photo (JPG, PNG, or WEBP, max 2 MB)</label>

        <div class="mb-3 flex h-44 items-center justify-center overflow-hidden rounded-xl border border-brown/30 bg-white">
            <img x-show="preview" :src="preview" alt="Menu photo preview" class="h-full w-full object-cover">
            <span x-show="!preview" class="text-sm text-brown/60">No photo yet</span>
        </div>

        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
                @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : @js($menu?->image_url)"
                class="w-full rounded-xl border border-brown/30 bg-white px-4 py-2.5 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-brown file:px-4 file:py-2 file:text-sm file:font-semibold file:text-cream">
        @error('image')
            <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
        @enderror

        @if ($menu?->image_link)
            <label class="mt-3 flex cursor-pointer items-center gap-3 text-sm font-medium">
                <input type="checkbox" name="remove_image" value="1"
                    class="size-5 cursor-pointer rounded accent-terracotta">
                Remove current photo
            </label>
        @endif
    </div>

    {{-- Availability --}}
    <div>
        <input type="hidden" name="is_available" value="0">
        <label class="flex cursor-pointer items-center gap-3 text-sm font-medium">
            <input type="checkbox" name="is_available" value="1"
                @checked(old('is_available', $menu?->is_available ?? true))
                class="size-5 cursor-pointer rounded accent-terracotta">
            Available for order
        </label>
        <p class="mt-1 text-xs text-brown/60">Uncheck this when the dish is sold out.</p>
    </div>
</div>