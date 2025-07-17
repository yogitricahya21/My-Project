<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all(); // Mengambil semua kategori dari database
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Nama wajib, string, max 255 karakter, harus unik di tabel categories
            'description' => 'nullable|string|max:1000', // Deskripsi opsional, string, max 1000 karakter
        ]);

        // Buat kategori baru di database
        Category::create($validated);

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Menampilkan detail kategori tunggal
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Menampilkan form untuk mengedit kategori
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // Validasi input untuk update
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id, // Nama wajib, unik kecuali untuk ID kategori ini sendiri
            'description' => 'nullable|string|max:1000',
        ]);

        // Perbarui data kategori di database
        $category->update($validated);

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Hapus kategori dari database
        $category->delete();

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
