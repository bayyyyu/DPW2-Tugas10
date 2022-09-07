<?php

namespace App\Http\Controllers\AdminControllers;
use App\Models\Produk;

class ProdukController extends Controller {
    function index(){
        $user = request()->user();
        $data ['list_produk'] = $user->produk;
        return view('AdminProduk.index', $data);
    }
    function create(){
        return view('AdminProduk.create');
    }
    function store(){
        $produk = new produk;
        $produk->id_user = request()->user()->id;
        $produk->nama = request('nama');
        
        $produk->harga = request('harga');
        $produk->berat = request('berat');
        $produk->deskripsi = request('deskripsi');
        $produk->stok = request('stok');
        $produk->save();

        $produk->handleUploadFoto();
        return redirect('AdminProduk')-> with('success', 'Data Berhasil Ditambahkan');
    }

    function show(Produk $produk){
        $data['produk'] = $produk;
        return view('AdminProduk.show', $data);
    }

    function edit(Produk $produk){
        $data['produk'] = $produk;
        return view('AdminProduk.edit', $data);
    }
    
    function update(Produk $produk){
        $produk->nama = request('nama'); 
        $produk->harga = request('harga');
        $produk->berat = request('berat');
        $produk->deskripsi = request('deskripsi');
        $produk->stok = request('stok');
        $produk->save();

        $produk->handleUploadFoto();
        return redirect('AdminProduk')-> with('success', 'Data Berhasil Diedit');
    }
    function destroy(Produk $produk){
        $produk->handleDelete();
        $produk-> delete();

        return redirect('AdminProduk')-> with('danger', 'Data Berhasil Dihapus');
    }
    function filter(){
        $nama = request('nama');
        $data['nama'] = $nama;
        $data['list_produk'] = Produk::where('nama','like', "%$nama%")->get();
        
        $data['stok'] = request('stok');
        $stok = explode(",", request('stok'));
        //$data['list_produk'] = Produk::whereIn('stok', $stok)->get();

        $data['harga_min'] = $harga_min = request('harga_min');
        $data['harga_max'] = $harga_max = request('harga_max');
        //$data['list_produk'] = Produk::whereBetween('harga', [$harga_min, $harga_max])->get();
        
        return view('AdminProduk.index', $data);
    }


}