@extends('layouts.admin.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Edit Pelanggan</h3>

    <form action="{{ route('pelanggan.update', $dataPelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control"
                value="{{ $dataPelanggan->first_name }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control"
                value="{{ $dataPelanggan->last_name }}" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Birthday</label>
                <input type="date" name="birthday" class="form-control"
                value="{{ $dataPelanggan->birthday }}">
            </div>

            <div class="col-md-4 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-select">
                    <option value="Male"   {{ $dataPelanggan->gender=='Male'?'selected':'' }}>Male</option>
                    <option value="Female" {{ $dataPelanggan->gender=='Female'?'selected':'' }}>Female</option>
                    <option value="Other"  {{ $dataPelanggan->gender=='Other'?'selected':'' }}>Other</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>No HP</label>
                <input type="text" name="phone" class="form-control"
                value="{{ $dataPelanggan->phone }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                value="{{ $dataPelanggan->email }}" required>
            </div>

        </div>

        <!-- Section untuk menampilkan file yang sudah diupload -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">File Yang Sudah Diupload</h5>
                    </div>
                    <div class="card-body">
                        @if($dataPelanggan->uploads->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Tanggal Upload</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataPelanggan->uploads as $index => $upload)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $upload->file_name }}</td>
                                            <td>{{ $upload->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                <a href="{{ Storage::url($upload->file_path) }}" 
                                                   class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                <form action="{{ route('pelanggan.deleteFile', $upload->multipleuploads_id) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada file yang diupload</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Section untuk upload file baru -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Upload File Baru</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="files" class="form-label">Pilih File (Dapat memilih lebih dari satu)</label>
                            <input type="file" name="files[]" id="files" class="form-control" multiple>
                            <small class="text-muted">Format yang diperbolehkan: PDF, JPG, PNG, DOCX (Max: 2MB per file)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection