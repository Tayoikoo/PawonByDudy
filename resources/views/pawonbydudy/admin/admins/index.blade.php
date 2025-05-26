@extends('pawonbydudy.layout.layout')
<!-- Section Item -->
@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="container-fluid" style="background: white; border-radius: 10px; padding: 20px;">
    <p class="text-black fs-4 text-center" style="font-family: Righteous;">Daftar Admin</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID Admin</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role Admin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($admin as $a)
                <tr class="text-center">
                    <td>{{ $a->id_admin }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->username }}</td>
                    <td>***</td>
                    <td>
                        @php
                            $role = '';
                            switch($a->role_admin) {
                                case 0:
                                    $role = 'Admin';
                                    break;
                                case 1:
                                    $role = 'High Admin';
                                    break;
                                case 2:
                                    $role = 'Super Admin';
                                    break;
                            }
                        @endphp
                        {{ $role }}
                    </td>

                    <td>
                        @php
                            $status = '';
                            switch($a->status) {
                                case 0:
                                    $status = 'Tidak Aktif';
                                    break;
                                case 1:
                                    $status = 'Aktif';
                                    break;
                            }
                        @endphp
                        {{ $status }}
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm btn_edit" 
                            data-id="{{ $a->id_admin }}" 
                            data-email="{{ $a->email }}" 
                            data-username="{{ $a->username }}" 
                            data-role="{{ $a->role_admin }}" 
                            data-status="{{ $a->status }}">
                            Edit
                        </button>
                        <!-- Delete Form -->
                        <form method="POST" action="{{ route('pawonbydudy_admin.admin.destroy', $a->id_admin) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="submit" data-konf-delete="{{ $a->username }}" class="btn btn-danger btn-sm show_confirm show_delete">Hapus</button>
                        </form>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>           
    </div>
    <div class="d-flex justify-content-center">
        {{ $admin->links() }}
    </div>
    <div class="d-flex justify-content-center mt-4">
        <button class="btn btn-primary d-flex justify-content-center btn_tambah" style="font-family: Righteous;">Tambah Admin</button>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.btn_tambah').click(function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Admin',
                    html: `
                        <form id="adminForm" action="{{ route('pawonbydudy_admin.admin.store') }}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @csrf
                            <div style="margin-bottom: 10px;">
                                <label for="email"><strong>Email:</strong></label><br>
                                <input type="text" id="email" name="email" class="form-control" style="width: 100%;">
                            </div>                            
                            <div style="margin-bottom: 10px;">
                                <label for="username"><strong>Username:</strong></label><br>
                                <input type="text" id="username" name="username" class="form-control" style="width: 100%;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="password"><strong>Password:</strong></label><br>
                                <input type="password" id="password" name="password" class="form-control" style="width: 100%;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="role"><strong>Role:</strong></label><br>
                                <select id="role" name="role" class="form-select" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="0">Admin</option>
                                    <option value="1">High Admin</option>
                                    <option value="2">Super Admin</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="status"><strong>Status:</strong></label><br>
                                <select id="status" name="status" class="form-select" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="0">Tidak Aktif</option>
                                    <option value="1">Aktif</option>
                                </select>
                            </div>                                            
                            <div style="text-align: center; margin-top: 15px;">
                                <button type="button" id="submitForm" class="btn btn-primary" style="width: 100%;">Tambah</button>
                            </div>
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: true
                });

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const username = $('#username').val().trim();
                    const password = $('#password').val().trim();
                    const role = $('#role').val().trim();
                    const status = $('#status').val().trim();

                    let errorMessage = '';

                    if (!username) errorMessage += 'Harap Masukan isi username!.<br>';
                    if (!password || password.length < 5) errorMessage += 'Kata sandi harus minimal 5 karakter.<br>';
                    if (!role) errorMessage += 'Harap isi Role!.<br>';
                    if (!status) errorMessage += 'Harap isi Status!.<br>';

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#adminForm').submit();
                    }
                });

            });

            $('.btn_edit').click(function (event) {
                event.preventDefault();
                const id = $(this).data('id');
                const email = $(this).data('email');
                const username = $(this).data('username');
                const role = $(this).data('role');
                const status = $(this).data('status');                

                Swal.fire({
                    title: 'Edit Admin',
                    html: `
                        <form id="editAdmin" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id_admin" value="${id}">
                            <div style="margin-bottom: 10px;">
                                <label for="email"><strong>Email:</strong></label><br>
                                <input type="text" id="email" name="email" value="${email}" class="form-control" style="width: 100%;">
                            </div>                            
                            <div style="margin-bottom: 10px;">
                                <label for="username"><strong>Username:</strong></label><br>
                                <input type="text" id="username" name="username" value="${username}" class="form-control" style="width: 100%;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="role"><strong>Role:</strong></label><br>
                                <select id="role" name="role_admin" class="form-select" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="1" ${role === '0' ? 'selected' : ''}>Admin</option>
                                    <option value="2" ${role === '1' ? 'selected' : ''}>High Admin</option>
                                    <option value="3" ${role === '2' ? 'selected' : ''}>Super Admin</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="status"><strong>Status:</strong></label><br>
                                <select id="status" name="status" class="form-select" style="width: 100%;">
                                    <option value=""></option>
                                    <option value="0" ${status === '0' ? 'selected' : ''}>Tidak Aktif</option>
                                    <option value="1" ${status === '1' ? 'selected' : ''}>Aktif</option>
                                </select>
                            </div>                               
                            <div style="text-align: center; margin-top: 15px;">
                                <button type="button" id="submitForm" class="btn btn-primary" style="width: 100%;">Edit</button>
                            </div>
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: true
                });

                // Set the form action dynamically after Swal has opened
                let actionUrl = "{{ route('pawonbydudy_admin.admin.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                $('#editAdmin').attr('action', actionUrl);

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const username = $('#username').val().trim();
                    const role = $('#role').val().trim();
                    const status = $('#status').val().trim();

                    let errorMessage = '';

                    if (!username) errorMessage += 'Harap Masukan isi username!.<br>';
                    if (!role) errorMessage += 'Harap isi Role!.<br>';
                    if (!status) errorMessage += 'Harap isi Status!.<br>';

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#editAdmin').submit();
                    }
                });                
            });    

            $('.show_delete').click(function (event) {
                var form = $(this).closest("form");
                var konfdelete = $(this).data("konf-delete");

                event.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Hapus Data?',
                    html: "Data yang dihapus <strong>" + konfdelete + "</strong> tidak dapat dikembalikan!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });

            });   
        });
</script>

@endsection
