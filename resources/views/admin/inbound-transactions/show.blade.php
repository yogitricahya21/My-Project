<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi Barang Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Tanggal Transaksi:</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $inboundTransaction->transaction_date->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Nama Barang:</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $inboundTransaction->item->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Jumlah Masuk:</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $inboundTransaction->quantity }} {{ $inboundTransaction->item->unit ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Sumber:</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $inboundTransaction->source ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dicatat Oleh:</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $inboundTransaction->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-700">Catatan:</p>
                            <p class="mt-1 text-lg text-gray-900">{{ $inboundTransaction->notes ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Dibuat Pada:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $inboundTransaction->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Terakhir Diperbarui:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $inboundTransaction->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.inbound-transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
