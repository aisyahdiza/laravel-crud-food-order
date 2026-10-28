@props(['name', 'options', 'selected' => null, 'placeholder' => 'Choose an option', 'error' => false])

<div class="relative"
    x-data="{
        open: false,
        value: @js($selected !== null ? (string) $selected : ''),
        options: @js($options),
        active: -1,
        get label() {
            const found = this.options.find(o => o.value === this.value);
            return found ? found.label : '';
        },
        toggle() {
            this.open = ! this.open;
            if (this.open) {
                this.active = Math.max(0, this.options.findIndex(o => o.value === this.value));
            }
        },
        choose(option) {
            this.value = option.value;
            this.open = false;
            this.$refs.button.focus();
        },
        move(step) {
            if (! this.open) { this.toggle(); return; }
            this.active = (this.active + step + this.options.length) % this.options.length;
        },
        pick() {
            if (this.open && this.active >= 0) { this.choose(this.options[this.active]); }
            else { this.toggle(); }
        }
    }"
    @click.outside="open = false"
    @keydown.escape="open = false">

    <input type="hidden" name="{{ $name }}" :value="value">

    <button type="button" x-ref="button" @click="toggle()"
            @keydown.arrow-down.prevent="move(1)"
            @keydown.arrow-up.prevent="move(-1)"
            @keydown.enter.prevent="pick()"
            :aria-expanded="open" aria-haspopup="listbox"
            class="flex w-full items-center justify-between rounded-xl border bg-white px-4 py-3 text-left outline-none transition focus:border-brown focus:ring-2 focus:ring-brown
                {{ $error ? 'border-terracotta-dark' : 'border-brown/30' }}">
        <span x-text="label || @js($placeholder)" :class="label ? 'text-brown' : 'text-brown/50'"></span>
        <svg class="size-5 shrink-0 text-brown/60 transition-transform duration-200" :class="open && 'rotate-180'"
            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
    </button>

    <ul x-show="open" x-transition.opacity style="display: none;" role="listbox"
        class="absolute z-20 mt-2 max-h-60 w-full overflow-auto rounded-xl border border-brown bg-white py-1 shadow-xl">
        <template x-for="(option, index) in options" :key="option.value">
        <li role="option" :aria-selected="value === option.value"
            @click="choose(option)" @mouseenter="active = index"
            :class="active === index ? 'bg-brown text-cream' : 'text-brown'"
            class="flex cursor-pointer items-center justify-between px-4 py-2.5 text-sm transition-colors">
            <span x-text="option.label" :class="value === option.value ? 'font-bold' : ''"></span>
            <svg x-show="value === option.value" class="size-4"
                :class="active === index ? 'text-cream' : 'text-terracotta'"
                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.5 7.5a1 1 0 0 1-1.4 0L3.3 9.7a1 1 0 1 1 1.4-1.4l3.8 3.8 6.8-6.8a1 1 0 0 1 1.4 0Z" clip-rule="evenodd" />
            </svg>
        </li>
        </template>
    </ul>
</div>