<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\MultipleUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $filterableColumns = ['gender'];
        $searchableColumns = ['first_name','last_name','email','phone'];

        $data['dataPelanggan'] = Pelanggan::filter($request, $filterableColumns)
        ->search($request, $searchableColumns)
        ->paginate(10);

        return view('admin.pelanggan.index',$data);
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $data['first_name'] = $request->first_name;
        $data['last_name'] = $request->last_name;
        $data['birthday'] = $request->birthday;
        $data['gender'] = $request->gender;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;

        $pelanggan = Pelanggan::create($data);
        
        // Handle multiple file upload
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/pelanggan', $fileName, 'public');
                
                MultipleUpload::create([
                    'ref_table' => 'pelanggan',
                    'ref_id' => $pelanggan->pelanggan_id,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('pelanggan.index')->with('success','Penambahan Data Berhasil!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::with('uploads')->findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->first_name = $request->first_name;
        $pelanggan->last_name = $request->last_name;
        $pelanggan->birthday = $request->birthday;
        $pelanggan->gender = $request->gender;
        $pelanggan->email = $request->email;
        $pelanggan->phone = $request->phone;

        $pelanggan->save();
        
        // Handle multiple file upload saat update
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/pelanggan', $fileName, 'public');
                
                MultipleUpload::create([
                    'ref_table' => 'pelanggan',
                    'ref_id' => $id,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                ]);
            }
        }
        
        return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil!');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        
        // Hapus semua file yang terkait
        $uploads = MultipleUpload::where('ref_table', 'pelanggan')
                                 ->where('ref_id', $id)
                                 ->get();
        
        foreach ($uploads as $upload) {
            Storage::disk('public')->delete($upload->file_path);
            $upload->delete();
        }

        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success','Data Berhasil dihapus');
    }
    
    // Method untuk menghapus file individual
    public function deleteFile($id)
    {
        $upload = MultipleUpload::findOrFail($id);
        Storage::disk('public')->delete($upload->file_path);
        $upload->delete();
        
        return back()->with('success', 'File berhasil dihapus');
    }
}