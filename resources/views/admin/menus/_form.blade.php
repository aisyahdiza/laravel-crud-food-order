@php $menu = $menu ?? null; @endphp

<div class="grid items-start gap-6 lg:grid-cols-3" x-data="{ preview: @js($menu?->image_url) }">

    {{-- LEFT: DETAILS --}}
    <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg lg:col-span-2">
        <div class="space-y-5">

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

            {{-- Category and price --}}
            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-medium text-terracotta">Category</label>
                    <x-custom-select name="category_id"
                        :options="$categories->map(fn ($c) => ['value' => (string) $c->id, 'label' => $c->name])->values()"
                        :selected="old('category_id', $menu?->category_id)"
                        :error="$errors->has('category_id')"
                        placeholder="Choose a category" />
                    @error('category_id')
                        <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
                    @enderror
                </div>

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
            </div>

            {{-- Description --}}
            <div x-data="{ count: @js(mb_strlen((string) old('description', $menu?->description))), max: 255 }">
                <div class="mb-2 flex items-center justify-between">
                    <label for="description" class="text-sm font-medium text-terracotta">Description</label>
                    <span x-text="count + ' / ' + max" aria-live="polite"
                        class="text-xs font-semibold transition-colors"
                        :class="count >= max ? 'text-terracotta-dark' : (count >= max * 0.9 ? 'text-terracotta' : 'text-brown/60')"></span>
                </div>

                <textarea id="description" name="description" rows="5" maxlength="255"
                        @input="count = $event.target.value.length"
                        placeholder="Short description of the dish..."
                        class="w-full rounded-xl border border-brown/30 bg-white px-4 py-3 outline-none transition focus:border-brown focus:ring-2 focus:ring-brown">{{ old('description', $menu?->description) }}</textarea>

                @error('description')
                    <p class="mt-2 text-sm font-medium text-terracotta-dark">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- RIGHT: PHOTO AND STATUS --}}
    <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg">
        <div class="space-y-5">

            {{-- Photo --}}
            <div>
                <label for="image" class="mb-2 block text-sm font-medium text-terracotta">Photo (JPG, PNG, or WEBP, max 2 MB)</label>

                <div class="mb-3 flex aspect-[4/3] items-center justify-center overflow-hidden rounded-xl border border-brown/30 bg-white">
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
            <div class="border-t border-brown/20 pt-5">
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
    </div>
</div>