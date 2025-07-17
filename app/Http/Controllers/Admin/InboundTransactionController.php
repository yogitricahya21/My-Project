<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\InboundTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InboundTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load item and user relationships for efficient data retrieval
        $inboundTransactions = InboundTransaction::with(['item', 'user'])
            ->orderBy('transaction_date', 'desc')
            ->get();
        return view('admin.inbound-transactions.index', compact('inboundTransactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::orderBy('name')->get(); // Tampilkan semua item untuk inbound
        return view('admin.inbound-transactions.create', compact('items'));
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
            'source' => 'nullable|string|max:255', // Validasi kolom 'source'
            'notes' => 'nullable|string|max:1000',
        ]);

        // Gunakan transaksi database untuk memastikan konsistensi data
        DB::transaction(function () use ($validated) {
            $item = Item::find($validated['item_id']);

            // Tambahkan user_id dari user yang sedang login
            $validated['user_id'] = auth()->id();

            // Buat transaksi barang masuk
            InboundTransaction::create($validated);

            // Tambahkan stok barang
            $item->current_stock += $validated['quantity'];
            $item->save();
        });

        return redirect()->route('admin.inbound-transactions.index')->with('success', 'Transaksi barang masuk berhasil ditambahkan dan stok barang diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(InboundTransaction $inboundTransaction)
    {
        // Eager load item and user relationships for the show view
        $inboundTransaction->load(['item', 'user']);
        return view('admin.inbound-transactions.show', compact('inboundTransaction'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InboundTransaction $inboundTransaction)
    {
        // Gunakan transaksi database untuk memastikan konsistensi data
        DB::transaction(function () use ($inboundTransaction) {
            $item = $inboundTransaction->item;

            if ($item) {
                // Pastikan stok tidak menjadi negatif setelah penghapusan
                if ($item->current_stock < $inboundTransaction->quantity) {
                    throw Exception('Tidak dapat menghapus transaksi karena stok barang tidak mencukupi untuk dikurangi kembali.');
                }
                // Kurangi stok barang (kebalikan dari saat masuk)
                $item->current_stock -= $inboundTransaction->quantity; // Gunakan 'quantity'
                $item->save();
                $inboundTransaction->delete();
                session()->flash('success', 'Transaksi barang masuk berhasil dihapus dan stok barang dikurangi kembali.');
            } else {
                // Jika item terkait sudah tidak ada, hapus transaksinya saja
                $inboundTransaction->delete();
                session()->flash('warning', 'Transaksi barang masuk berhasil dihapus, namun barang terkait tidak ditemukan untuk mengurangi stok.');
            }
        });

        return redirect()->route('admin.inbound-transactions.index');
    }

    // Metode 'edit' dan 'update' tidak diimplementasikan karena dikecualikan di route
    // public function edit() { abort(404); }
    // public function update() { abort(404); }
}
