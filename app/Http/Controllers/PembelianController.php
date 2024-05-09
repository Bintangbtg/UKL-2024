<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pembelian;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{

    public function create(Barang $barang)
    {
        return view('transaksi.beli')->with('barang', $barang);
    }

    public function beli(Request $request, Barang $barang)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
        ]);

        $total = $request->jumlah * $barang->harga;

        // Mendapatkan ID pengguna dari session
        $userId = Auth::id();

        // Menyimpan informasi pembelian ke dalam database pembelian
        $pembelian = new Pembelian([
            'id_barang' => $barang->id,
            'nama' => $barang->nama,
            'jumlah' => $request->jumlah,
            'total' => $total,
            'user_id' => $request->user_id, // Menggunakan ID pengguna dari session
        ]);

        $pembelian->save();

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil dibeli.');
    }

    public function index()
    {
        $pembelians = Pembelian::all();
        return view('pembelian.index', compact('pembelians'));
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        return redirect()->route('pembelian.index')
                         ->with('success', 'History Pembelian berhasil dihapus.');
    }
}