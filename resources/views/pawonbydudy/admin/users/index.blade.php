@extends('pawonbydudy.layout.layout')
<!-- Section Item -->
@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="container-fluid" style="background: white; border-radius: 10px; padding: 20px;">
    <p class="text-black fs-4 text-center" style="font-family: Righteous;">Daftar User</p>
    <button class="btn btn-primary d-flex justify-content-center btn_tambah" style="font-family: Righteous;">Tambah User</button>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>HP</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php $row = 1; @endphp
            @foreach ($user as $u)
                <tr class="text-center">
                    <td>{{ $row++ }}</td>
                    <td>{{ $u->username }}</td>
                    <td>***</td>
                    <td>{{ $u->hp }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn_edit" 
                            data-id="{{ $u->id_user }}" 
                            data-username="{{ $u->username }}"
                            data-password="{{ $u->password }}" 
                            data-email="{{ $u->email }}" 
                            data-hp="{{ $u->hp }}">
                            Edit
                        </button>
                        <!-- Delete Form -->
                        <form method="POST" action="{{ route('pawonbydudy_user.user.destroy', $u->id_user) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="submit" data-konf-delete="{{ $u->username }}" class="btn btn-danger btn-sm show_confirm show_delete">Hapus</button>
                        </form>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>           
    </div>
    <div class="d-flex justify-content-center">

    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.btn_tambah').click(function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah User',
                    html: `
                        <form id="userForm" action="{{ route('pawonbydudy_user.user.store') }}" method="POST" enctype="multipart/form-data" style="text-align: left;">
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
                                <label for="hp"><strong>Nomor Telepon:</strong></label><br>
                                <input type="text" id="hp" name="hp" class="form-control" style="width: 100%;">
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
                    const email = $('#email').val().trim();
                    const hp = $('#hp').val().trim();

                    let errorMessage = '';

                    if (!username) errorMessage += 'Harap Masukan isi username!.<br>';
                    if (!email) errorMessage += 'Harap Masukan isi email!.<br>';
                    if (!password || password.length < 5) errorMessage += 'Kata sandi harus minimal 5 karakter.<br>';
                    if (!hp) errorMessage += 'Harap isi Nomor Telepon!.<br>';

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#userForm').submit();
                    }
                });

            });

            $('.btn_edit').click(function (event) {
                event.preventDefault();
                const id = $(this).data('id');
                const email = $(this).data('email');
                const username = $(this).data('username');
                const hp = $(this).data('hp');       

                Swal.fire({
                    title: 'Edit User',
                    html: `
                        <form id="editUser" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id_user" value="${id}">
                            <div style="margin-bottom: 10px;">
                                <label for="username"><strong>Username:</strong></label><br>
                                <input type="text" id="username" name="username" value="${username}" class="form-control" style="width: 100%;">
                            </div>                            
                            <div style="margin-bottom: 10px;">
                                <label for="email"><strong>Email:</strong></label><br>
                                <input type="text" id="email" name="email" value="${email}" class="form-control" style="width: 100%;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="hp"><strong>Nomor Telepon:</strong></label><br>
                                <input type="text" id="hp" name="hp" value="${hp}" class="form-control" style="width: 100%;">
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
                const actionUrl = "{{ route('pawonbydudy_user.user.update', '') }}";
                $('#editUser').attr('action', actionUrl + '/' + id);

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const username = $('#username').val().trim();

                    let errorMessage = '';

                    if (!username) errorMessage += 'Harap Masukan isi username!.<br>';

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#editUser').submit();
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
