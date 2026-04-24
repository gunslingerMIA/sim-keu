@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="col">
                    <h3 class="card-title">Daftar User</h3>
                </div>
                <div class="col-auto  ms-auto d-flex"><button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-user" onclick="fillModalUser()">Tambah User</button></div>


            </div>

            <div class="table-responsive">
                <table class="table table-selectable card-table table-vcenter text-nowrap datatable" id="table">
                    <thead>
                        <tr>
                            <th class="w-1">Aksi</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="Edit"><i
                                            class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-warning" title="Reset Password"><i
                                            class="bi bi-lock"></i></button>
                                    <button class="btn btn-sm btn-danger" title="Hapus"><i
                                            class="bi bi-trash"></i></button>
                                </td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- modal user -->
    <div class="modal modal-blur fade" id="modal-user" tabindex="-1" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST" id="form-akun">
                    @csrf
                    <div id="method-field"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Form User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip"
                                class="form-control  @error('nip') is-invalid @enderror"" placeholder="199xxxxxxxxxxxxx"
                                required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama_user" id="nama_user" class="form-control" placeholder=""
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Jabatan"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="Bendahara">Bendahara</option>
                                <option value="Aendahara">Admin</option>
                                <option value="Kendahara">Kasir</option>
                            </select>
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

    @push('scripts')
        <script>
            // Script ini akan otomatis ditaruh di bawah tabler.min.js
            @if($errors->any())
            console.log('eror');
                var myModal = new bootstrap.Modal(document.getElementById('modal-user'));
                myModal.show();
            @endif
        </script>
    @endpush
    <script>
        function fillModalUser(data = null) {
            const form = document.getElementById('form-akun');
            const title = document.getElementById('modal-title');
            const methodField = document.getElementById('method-field');

            if (data) {
                title.innerText = 'Edit User';
                form.action = '/users/update/' + data.id;
                methodField.innerHTML = '@method('PUT')';

                document.getElementById('nip').value = data.nip;
                document.getElementById('nama_user').value = data.name;
                document.getElementById('jabatan').value = data.jabatan;
                document.getElementById('role').value = data.role;
            } else {
                title.innerText = 'Tambah User Baru';
                form.action = '/users/store';
                methodField.innerHTML = '';
                form.reset();
            }
        }
    </script>
    
@endsection
