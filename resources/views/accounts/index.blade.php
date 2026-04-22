@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Rekening Belanja</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-akun" onclick="fillModalAkun()">
            <i class="bi bi-plus-lg me-2"></i> Tambah Akun
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table" id="table">
            <thead>
                <tr>
                    <th>Kode Rekening</th>
                    <th>Uraian Akun</th>
                    <th>Kelompok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $acc)
                <tr>
                    <td class="text-muted">{{ $acc->kode_rekening }}</td>
                    <td class="fw-bold">{{ $acc->nama_rekening }}</td>
                    <td>
                        <span class="badge {{ $acc->kelompok == 'Belanja Modal' ? 'bg-purple-lt' : 'bg-blue-lt' }}">
                            {{ $acc->kelompok }}
                        </span>
                    </td>
                    <td class="d-flex">
                        <button class="btn btn-sm btn-ghost-warning" data-bs-toggle="modal" data-bs-target="#modal-akun"  onclick="fillModalAkun({{ json_encode($acc) }})">Edit</button>
                        <button class="btn btn-sm btn-ghost-danger" onclick="confirmDelete('/accounts/delete/{{$acc->id}}', {{$acc->budgets->count()}}, 'Akun')">hapus</button>
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- modal akun -->
<div class="modal modal-blur fade" id="modal-akun" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="form-akun">
                @csrf
                <div id="method-field"></div> <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Form Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kelompok Belanja</label>
                        <select name="kelompok" id="acc_kelompok" class="form-select" required>
                            <option value="">-- Pilih Kelompok --</option>
                            <option value="belanja">Belanja</option>
                            <option value="kas">Kas</option>
                            <option value="pajak">Pajak</option>
                            <option value="panjar">Panjar</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Rekening</label>
                        <input type="text" name="kode_rekening" id="acc_kode" class="form-control" placeholder="5.1.02.xx.xx.xxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uraian Rekening</label>
                        <textarea name="nama_rekening" id="acc_nama" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    function fillModalAkun(data = null) {
        const form = document.getElementById('form-akun');
        const title = document.getElementById('modal-title');
        const methodField = document.getElementById('method-field');
        
        if (data) {
            // MODE EDIT
            title.innerText = 'Edit Rekening Belanja';
            form.action = '/accounts/update/' + data.id;
            methodField.innerHTML = '@method("PUT")';
            
            // Isi Value
            document.getElementById('acc_kode').value = data.kode_rekening;
            document.getElementById('acc_nama').value = data.nama_rekening;
            document.getElementById('acc_kelompok').value = data.kelompok;
        } else {
            // MODE TAMBAH
            title.innerText = 'Tambah Rekening Baru';
            form.action = '/accounts/store';
            methodField.innerHTML = '';
            form.reset(); // Kosongkan form
        }
        
       
    }

    function confirmDelete(url, ChildCount, type='data'){

        console.log(url);
        console.log(ChildCount);
        console.log(type);
        //cek ada anak apa enggak

        if (ChildCount > 0 ){
             Swal.fire({
                icon: 'error',
                    title: 'Akses Ditolak',
                    text: type+'  ini masih memiliki ' +ChildCount+ ' Data di Bawahnya',
                    confirmButtonColor: '#3b82f6'
            });
            return;
        }

        Swal.fire({
            title: `Hapus ${type}?`,
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>


@endsection
