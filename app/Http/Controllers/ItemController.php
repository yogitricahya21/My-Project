<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\StorageLocation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load relationships to avoid N+1 query problem
        $items = Item::with(['category', 'storageLocation'])->orderBy('name')->get();
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $storageLocations = StorageLocation::orderBy('name')->get();
        return view('admin.items.create', compact('categories', 'storageLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:items,code', // 'code' harus unik
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'initial_stock' => 'required|integer|min:0', // Menggunakan initial_stock
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'storage_location_id' => 'required|exists:storage_locations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'price' => 'nullable|numeric|min:0',
        ]);

        // Jika gambar diunggah, simpan
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/items'); // Simpan di storage/app/public/items
            $validated['image'] = str_replace('public/', '', $imagePath); // Simpan path relatif ke kolom 'image'
        }

        // Set current_stock berdasarkan initial_stock untuk item baru
        $validated['current_stock'] = $validated['initial_stock'];

        Item::create($validated);

        return redirect()->route('admin.items.index')->with('success', 'Barang inventaris berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        // Untuk saat ini, kita tidak akan membuat tampilan 'show' terpisah.
        // Data biasanya ditampilkan di halaman 'index' atau form 'edit'.
        return redirect()->route('admin.items.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        $storageLocations = StorageLocation::orderBy('name')->get();
        return view('admin.items.edit', compact('item', 'categories', 'storageLocations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items')->ignore($item->id), // 'code' unik tapi abaikan kode item saat ini
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            // initial_stock biasanya tidak diperbarui setelah pembuatan. current_stock dikelola oleh transaksi.
            // Untuk penyederhanaan, kita izinkan update current_stock secara manual di sini.
            'current_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'storage_location_id' => 'required|exists:storage_locations,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'price' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) { // Menggunakan $item->image sesuai dengan nama kolom Anda
                Storage::disk('public')->delete($item->image);
            }
            $imagePath = $request->file('image')->store('public/items');
            $validated['image'] = str_replace('public/', '', $imagePath); // Simpan path ke kolom 'image'
        }

        $item->update($validated);

        return redirect()->route('admin.items.index')->with('success', 'Barang inventaris berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        // Pencegahan penghapusan jika barang sudah terlibat dalam transaksi/peminjaman
        if ($item->inboundTransactions()->exists() || $item->outboundTransactions()->exists() || $item->loanItems()->exists()) {
            return redirect()->route('admin.items.index')->with('error', 'Tidak dapat menghapus barang karena sudah terkait dengan transaksi atau peminjaman.');
        }

        // Hapus gambar terkait jika ada
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.items.index')->with('success', 'Barang inventaris berhasil dihapus!');
    }
}
