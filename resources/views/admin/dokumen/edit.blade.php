<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokumen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow rounded-lg p-6">
                <form method="POST" action="{{ route('admin.dokumen.update', $dokumen) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.dokumen._form')
                    <div class="text-center mt-6">
                        <x-primary-button>Update</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>