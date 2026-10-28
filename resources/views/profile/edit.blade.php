<x-app-layout>
    <div class="mx-auto max-w-7xl px-6 py-12">

        <section class="mb-10">
            <h1 class="font-playfair mb-2 text-4xl font-extrabold italic sm:text-5xl lg:text-6xl">
                Profile
            </h1>
            <p class="text-lg font-bold sm:text-xl">Manage your account information.</p>
        </section>

        <div class="space-y-6">
            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-2xl border border-brown bg-sky p-6 shadow-lg sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
</x-app-layout>