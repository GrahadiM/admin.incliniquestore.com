<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @if (Auth::user()->status == 'active')
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @else
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl space-y-4">
                    <p class="text-red-600 font-semibold">Account is inactive and cannot be used.</p>

                    <form method="POST" action="{{ route('profile.activate') }}">
                        @csrf
                        @method('PATCH')
                        <x-primary-button>Activate Account</x-primary-button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- SweetAlert --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @if (session('status') === 'account-activated')
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Activated',
                        text: 'Your account has been activated successfully.',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                @elseif (session('status') === 'account-already-active')
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Active',
                        text: 'Your account is already active.',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                    });
                @endif
            });
        </script>
    @endpush
</x-app-layout>
