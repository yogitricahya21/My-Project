<?php

namespace App\Http\Controllers\Admin;

use id;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\OutboundTransaction;
use App\Http\Controllers\Controller;
use App\Models\Item; // Import Item model
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Untuk generate kode transaksi
use Illuminate\Support\Facades\DB; // Import DB facade untuk transaksi database

class OutboundTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load item and user relationships for efficient data retrieval
        $outboundTransactions = OutboundTransaction::with(['item', 'user'])
            ->orderBy('transaction_date', 'desc')
            ->get();
        return view('admin.outbound-transactions.index', compact('outboundTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya tampilkan barang yang memiliki stok saat ini > 0
        $items = Item::where('current_stock', '>', 0)->orderBy('name')->get();
        return view('admin.outbound-transactions.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1', // Sesuai nama kolom 'quantity'
            'recipient' => 'nullable|string|max:255',
            'purpose' => 'required|string|max:255', // Validasi kolom 'purpose'
            'notes' => 'nullable|string|max:1000',
        ]);

        // Gunakan transaksi database untuk memastikan konsistensi data
        DB::transaction(function () use ($validated) {
            $item = Item::find($validated['item_id']);

            // Validasi stok yang cukup sebelum mengurangi
            if ($validated['quantity'] > $item->current_stock) {
                // Jika stok tidak cukup, batalkan transaksi dan lemparkan error
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => 'Jumlah barang keluar (' . $validated['quantity'] . ') melebihi stok yang tersedia (' . $item->current_stock . ').',
                ]);
            }

            // Generate unique transaction code
            $validated['transaction_code'] = 'OUT-' . now()->format('YmdHis') . Str::random(4);
            // Tambahkan user_id dari user yang sedang login
            $validated['user_id'] = auth()->id();

            // Buat transaksi barang keluar
            OutboundTransaction::create($validated);

            // Kurangi stok barang
            $item->current_stock -= $validated['quantity'];
            $item->save();
        });

        return redirect()->route('admin.outbound-transactions.index')->with('success', 'Transaksi barang keluar berhasil ditambahkan dan stok barang diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OutboundTransaction $outboundTransaction)
    {
        // Eager load item and user relationships for the show view
        $outboundTransaction->load(['item', 'user']);
        return view('admin.outbound-transactions.show', compact('outboundTransaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutboundTransaction $outboundTransaction)
    {
        // Gunakan transaksi database untuk memastikan konsistensi data
        DB::transaction(function () use ($outboundTransaction) {
            $item = $outboundTransaction->item;

            if ($item) {
                // Kembalikan stok barang
                $item->current_stock += $outboundTransaction->quantity; // Gunakan 'quantity'
                $item->save();
                $outboundTransaction->delete();
                session()->flash('success', 'Transaksi barang keluar berhasil dihapus dan stok barang dikembalikan.');
            } else {
                // Jika item terkait sudah tidak ada, hapus transaksinya saja
                $outboundTransaction->delete();
                session()->flash('warning', 'Transaksi barang keluar berhasil dihapus, namun barang terkait tidak ditemukan untuk mengembalikan stok.');
            }
        });

        return redirect()->route('admin.outbound-transactions.index');
    }

    // Metode 'edit' dan 'update' tidak diimplementasikan karena dikecualikan di route
    // public function edit() { abort(404); }
    // public function update() { abort(404); }
}
