@extends('pawonbydudy.layout.layout')
<!-- Section Item -->
@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="container-fluid" style="background: white; border-radius: 10px; padding: 20px;">
    <p class="text-black fs-4 text-center" style="font-family: Righteous;">Daftar Pengirim</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID Pengirim</th>
                    <th>Nama Pengirim</th>
                    <th>Nomor Telepon</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($pengirim as $p)
                <tr class="text-center">
                    <td>{{ 'P' . str_pad($p->id_pengirim, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->nama_pengirim }}</td>
                    <td>{{ $p->nomor_telepon }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn_edit" 
                            data-id="{{ $p->id_pengirim }}" 
                            data-nama_pengirim="{{ $p->nama_pengirim }}"
                            data-nomor_telepon="{{ $p->nomor_telepon }}"
                            >
                            Edit
                        </button>
                        <!-- Delete Form -->
                        <form method="POST" action="{{ route('pawonbydudy_pengirim.pengirim.destroy', $p->id_pengirim) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="submit" data-konf-delete="{{ $p->nama_pengirim }}" class="btn btn-danger btn-sm show_confirm show_delete">Hapus</button>
                        </form>
                    </td>                    
                </tr>
            @endforeach
            </tbody>
        </table>           
    </div>
    <div class="d-flex justify-content-center">
        {{ $pengirim->links() }}
        <button class="btn btn-primary d-flex justify-content-center btn_tambah" style="font-family: Righteous;">
            Tambah Pengirim
        </button>        
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.btn_tambah').click(function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Pengirim',
                    html: `
                        <form id="pengirimForm" action="{{ route('pawonbydudy_pengirim.pengirim.store') }}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @csrf
                            <div style="margin-bottom: 10px;">
                                <label for="nama_pengirim"><strong>Nama Pengirim:</strong></label><br>
                                <input type="text" id="nama_pengirim" name="nama_pengirim" class="form-control" style="width: 100%;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="nomor_telepon"><strong>Nomor Telepon:</strong></label><br>
                                <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" style="width: 100%;">
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
                    const nama_pengirim = $('#nama_pengirim').val().trim();
                    const nomor_telepon = $('#nomor_telepon').val().trim();

                    let errorMessage = '';
                    
                    if (!nama_pengirim) errorMessage += 'Harap Masukan isi Nama Pengirim!.<br>';
                    if (!nomor_telepon) {
                        errorMessage += 'Harap isi Nomor Telepon!<br>';
                    } else {
                        if (!/^\d+$/.test(nomor_telepon)) {
                            errorMessage += 'Nomor Telepon hanya boleh berupa angka!<br>';
                        }
                        if (nomor_telepon.length > 13) {
                            errorMessage += 'Nomor Telepon maksimal 13 digit!<br>';
                        }
                    }

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#pengirimForm').submit();
                    }
                });

            });

            $('.btn_edit').click(function (event) {
                event.preventDefault();
                const id = $(this).data('id');
                const nama_pengirim = $(this).data('nama_pengirim');
                const nomor_telepon = $(this).data('nomor_telepon');

                Swal.fire({
                    title: 'Edit User',
                    html: `
                        <form id="editPaket" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id_paket" value="${id}">
                            <div style="margin-bottom: 10px;">
                                <label for="nama_pengirim"><strong>Nama Pengirim:</strong></label><br>
                                <input type="text" id="nama_pengirim" name="nama_pengirim" value="${nama_pengirim}" class="form-control" style="width: 100%;">
                            </div>
                            <div style="margin-bottom: 10px;">
                                <label for="nomor_telepon"><strong>Nama Pengirim:</strong></label><br>
                                <input type="text" id="nomor_telepon" name="nomor_telepon" value="${nomor_telepon}" class="form-control" style="width: 100%;">
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
                const actionUrl = "{{ route('pawonbydudy_pengirim.pengirim.update', '') }}";
                $('#editPaket').attr('action', actionUrl + '/' + id);

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const nama_pengirim = $('#nama_pengirim').val().trim();
                    const nomor_telepon = $('#nomor_telepon').val().trim();

                    let errorMessage = '';

                    if (!nama_pengirim) errorMessage += 'Harap Masukan isi Nama Pengirim!.<br>';
                    if (!nomor_telepon) {
                        errorMessage += 'Harap isi Nomor Telepon!<br>';
                    } else {
                        if (!/^\d+$/.test(nomor_telepon)) {
                            errorMessage += 'Nomor Telepon hanya boleh berupa angka!<br>';
                        }
                        if (nomor_telepon.length > 13) {
                            errorMessage += 'Nomor Telepon maksimal 13 digit!<br>';
                        }
                    }

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#editPaket').submit();
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
