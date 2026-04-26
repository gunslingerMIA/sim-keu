@extends('layouts.app')

@section('content')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if($errors->any())
            let modalId = '';
            const isEdit = "{{ old('_method') }}" === "PUT";

            // 1. Cek apakah ini konteks KEGIATAN
            @if($errors->has('kode_kegiatan') || old('program_id'))
                modalId = isEdit ? 'modal-edit-kegiatan' : 'modal-kegiatan';
            
            // 2. Cek apakah ini konteks SUB KEGIATAN
            @elseif($errors->has('kode_sub_kegiatan') || old('activity_id'))
                modalId = isEdit ? 'modal-edit-sub-kegiatan' : 'modal-sub-kegiatan';
            
            // 3. Default ke PROGRAM
            @else
                modalId = isEdit ? 'modal-edit-program' : 'modal-program';
            @endif

            // Eksekusi buka modal
            const modalEl = document.getElementById(modalId);
            if (modalEl && window.bootstrap) {
                const modal = window.bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        @endif
    });
</script>
<div class="row mb-3 align-items-center">
    <div class="col">
        <h3 class="page-title text-primary">Cascading DPMPTSP</h3>
    </div>
    <div class="col-auto ms-auto">
        <button class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-program">
            <i class="bi bi-plus-lg me-2"></i> Tambah Program Baru
        </button>
    </div>
</div>
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th width="20%">Kode</th>
                    <th>Uraian Struktur</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody id="accordionDPA">
                @foreach($programs as $p)
                <tr class="bg-primary-lt" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#prog-{{ $p->id }}">
                    <td class="fw-bold text-primary">{{ $p->kode_program }}</td>
                    <td class="fw-bold">
                        <i class="bi bi-folder2-open me-2"></i> {{ $p->nama_program }}
                    </td>
                    <td class="text-end pe-3">
                        <div class="btn-group shadow-sm">
                            <button class="btn btn-sm btn-white text-primary" title="Tambah Kegiatan" 
                                    data-bs-toggle="modal" data-bs-target="#modal-kegiatan"
                                    onclick="prepareKegiatan({{ $p->id }}); event.stopPropagation();">
                                <i class="bi bi-plus-circle"></i>
                            </button>
                            
                            <button class="btn btn-sm btn-white text-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-program" title="Edit Program" 
                                    onclick="event.stopPropagation(); editProgram({{json_encode($p) }});">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            
                            <button class="btn btn-sm btn-white text-danger" title="Hapus Program" 
                                    onclick="event.stopPropagation(); confirmDelete('programs/delete/{{$p->id}}', {{$p->activities->count()}}, 'Program')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="collapse" id="prog-{{ $p->id }}" data-bs-parent="#accordionDPA">
                    <td colspan="3" class="p-0">
                        <table class="table table-vcenter mb-0 bg-white">
                            <tbody id="group-keg-{{ $p->id }}">
                                @foreach($p->activities as $a)
                                <tr class="bg-light" 
                                    style="cursor: pointer;" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#keg-{{ $a->id }}" 
                                    aria-expanded="false">
                                    <td width="20%" class="ps-4 text-muted small">{{ $a->kode_kegiatan }}</td>
                                    <td class="ps-4">
                                        <i class="bi bi-arrow-return-right me-2 text-secondary"></i> {{ $a->nama_kegiatan }}
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group shadow-sm">
                                            <button class="btn btn-sm btn-white text-primary" title="Tambah Sub Kegiatan" 
                                                    data-bs-toggle="modal" data-bs-target="#modal-sub-kegiatan"
                                                    onclick="event.stopPropagation(); prepareSubKegiatan({{$a->id}})">
                                                <i class="bi bi-plus-circle"></i>
                                            </button>
                                            
                                            <button class="btn btn-sm btn-white text-warning"data-bs-toggle="modal" data-bs-target="#modal-edit-kegiatan" title="Edit Kegiatan" 
                                                    onclick="event.stopPropagation(); editKegiatan({{json_encode($a) }});">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            
                                            <button class="btn btn-sm btn-white text-danger" title="Hapus Kegiatan" 
                                                    onclick="event.stopPropagation(); confirmDelete('programs/kegiatan/delete/{{$a->id}}', {{$a->subActivities->count()}}, 'Kegiatan')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="collapse" id="keg-{{ $a->id }}" data-bs-parent="#group-keg-{{ $p->id }}">
                                    <td colspan="3" class="p-0">
                                        <table class="table table-vcenter mb-0 bg-white">
                                            @foreach($a->subActivities as $s)
                                            <tr>
                                                <td width="20%" class="ps-5 text-secondary small">{{ $s->kode_sub_kegiatan }}</td>
                                                <td class="ps-5 small text-secondary">
                                                    <i class="bi bi-dot me-1"></i> {{ $s->nama_sub_kegiatan }}
                                                </td>
                                                
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-white text-warning"data-bs-toggle="modal" data-bs-target="#modal-edit-sub-kegiatan" title="Edit Sub Kegiatan" 
                                                    onclick="event.stopPropagation(); editSubKegiatan({{json_encode($s) }});">
                                                    <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-ghost-danger" title="Hapus Sub Kegiatan" onclick="confirmDelete('programs/sub/delete/{{$s->id}}', '0', 'Sub Kegiatan')"><i class="bi bi-trash3"></i ></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- Modal Program --}}
<div class="modal modal-blur fade" id="modal-program" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/programs/store" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Program Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Program</label>
                        <input type="text" name="kode_program"  class="form-control @error('kode_program') is-invalid @enderror" placeholder="Contoh: 2.18.01" required>
                        @error('kode_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Program</label>
                        <textarea name="nama_program" class="form-control" rows="3" placeholder="Masukkan nama program sesuai DPA..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" onclick="">Simpan Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Program --}}

<div class="modal modal-blur fade" id="modal-edit-program" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="form-edit-program">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Program</label>
                        <input type="text" name="kode_program" id="edit_kode_program" class="form-control" required>
                        @error('kode_program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Program</label>
                        <textarea name="nama_program" id="edit_nama_program" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- //Modal Kegiatan --}}

<div class="modal modal-blur fade" id="modal-kegiatan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/programs/kegiatan/store" method="POST">
                @csrf
                <input type="hidden" name="program_id" id="modal_program_id" value="{{ old('program_id') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kegiatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kegiatan</label>
                        <input type="text" name="kode_kegiatan" class="form-control @error('kode_kegiatan') is-invalid @enderror" placeholder="Contoh: 2.18.01.2.01">
                        @error('kode_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kegiatan</label>
                        <textarea name="nama_kegiatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kegiatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kegiatan -->
 
 <div class="modal modal-blur fade" id="modal-edit-kegiatan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="form-edit-kegiatan">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Kegiatan</label>
                        <input type="text" name="kode_kegiatan" id="edit_kode_kegiatan" class="form-control" required>
                        @error('kode_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama kegiatan</label>
                        <textarea name="nama_kegiatan" id="edit_nama_kegiatan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sub Kegiatan -->
 <div class="modal modal-blur fade" id="modal-sub-kegiatan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="/programs/subkegiatan/store" method="POST">
                @csrf
                <input type="hidden" name="activity_id" id="modal_kegiatan_id" value="{{ old('activity_id') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Sub Kegiatan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Sub Kegiatan</label>
                        <input type="text" name="kode_sub_kegiatan" class="form-control @error('kode_sub_kegiatan') is-invalid @enderror" placeholder="Contoh: 2.18.01.2.01">
                        @error('kode_sub_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Sub Kegiatan</label>
                        <textarea name="nama_sub_kegiatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Sub Kegiatan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Sub Kegiatan -->
 <div class="modal modal-blur fade" id="modal-edit-sub-kegiatan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST" id="form-edit-sub-kegiatan">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Sub Kegiatan</label>
                        <input type="text" name="kode_sub_kegiatan" id="edit_kode_sub_kegiatan" class="form-control" required>
                        @error('kode_sub_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama sub kegiatan</label>
                        <textarea name="nama_sub_kegiatan" id="edit_nama_sub_kegiatan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    

    //fungsi edit program, menerima parameter data program lengkap untuk diisi ke form

    function editProgram(program) {
        // 1. Set URL action form agar mengarah ke ID yang benar
        document.getElementById('form-edit-program').action = '/programs/update/' + program.id;

        // 2. Isi value input modal dengan data program
        document.getElementById('edit_kode_program').value = program.kode_program;
        document.getElementById('edit_nama_program').value = program.nama_program;
  
    }

    function prepareKegiatan(programId) {
        // Cukup isi ID-nya saja, modal akan dibuka otomatis oleh data-bs-target
        document.getElementById('modal_program_id').value = programId;
    }

    function editKegiatan(kegiatan) {
        document.getElementById('form-edit-kegiatan').action = 'programs/kegiatan/update/' + kegiatan.id;
        document.getElementById('edit_kode_kegiatan').value = kegiatan.kode_kegiatan;
        document.getElementById('edit_nama_kegiatan').value = kegiatan.nama_kegiatan;
    }

    function editSubKegiatan(subkegiatan){
        document.getElementById('form-edit-sub-kegiatan').action = 'programs/subkegiatan/update/' +subkegiatan.id;
        document.getElementById('edit_kode_sub_kegiatan').value = subkegiatan.kode_sub_kegiatan;
        document.getElementById('edit_nama_sub_kegiatan').value = subkegiatan.nama_sub_kegiatan;
    }

    function prepareSubKegiatan(kegiatanId) {
        document.getElementById('modal_kegiatan_id').value = kegiatanId;
        console.log(kegiatanId)
    }

    // Jika ingin tetap pakai cara manual, gunakan pengecekan ini:
    function showModalKegiatan(programId) {
        document.getElementById('modal_program_id').value = programId;
        
        // Gunakan bootstrap global dari window
        var modalEl = document.getElementById('modal-kegiatan');
        var modal = bootstrap.Modal.getOrCreateInstance(modalEl); 
        modal.show();
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

