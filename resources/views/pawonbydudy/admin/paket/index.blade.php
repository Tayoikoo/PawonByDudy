@extends('pawonbydudy.layout.layout')
<!-- Section Item -->
@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="container-fluid" style="background: white; border-radius: 10px; padding: 20px;">
    <p class="text-black fs-4 text-center" style="font-family: Righteous;">Daftar Paket</p>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr class="text-center">
                    <th>ID Paket</th>
                    <th>Nama Paket</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @php $row = 1; @endphp
            @foreach ($packet as $p)
                <tr class="text-center">
                    <td>{{ 'PK' . str_pad($p->id_paket, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->nama_paket }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn_edit" 
                            data-id="{{ $p->id_paket }}" 
                            data-nama_paket="{{ $p->nama_paket }}">
                            Edit
                        </button>
                        <!-- Delete Form -->
                        <form method="POST" action="{{ route('pawonbydudy_paket.paket.destroy', $p->id_paket) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="submit" data-konf-delete="{{ $p->nama_paket }}" class="btn btn-danger btn-sm show_confirm show_delete">Hapus</button>
                        </form>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>           
    </div>
    <div class="d-flex justify-content-center">
        {{ $packet->links() }}
        <button class="btn btn-primary d-flex justify-content-center btn_tambah" style="font-family: Righteous;">
            Tambah Paket
        </button>        
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.btn_tambah').click(function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Paket',
                    html: `
                        <form id="paketForm" action="{{ route('pawonbydudy_paket.paket.store') }}" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @csrf
                            <div style="margin-bottom: 10px;">
                                <label for="nama_paket"><strong>Nama Paket:</strong></label><br>
                                <input type="text" id="nama_paket" name="nama_paket" class="form-control" style="width: 100%;">
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
                    const nama_paket = $('#nama_paket').val().trim();

                    let errorMessage = '';

                    if (!nama_paket) errorMessage += 'Harap Masukan isi Nama Paket!.<br>';

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#paketForm').submit();
                    }
                });

            });

            $('.btn_edit').click(function (event) {
                event.preventDefault();
                const id = $(this).data('id');
                const nama_paket = $(this).data('nama_paket');

                Swal.fire({
                    title: 'Edit User',
                    html: `
                        <form id="editPaket" method="POST" enctype="multipart/form-data" style="text-align: left;">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id_paket" value="${id}">
                            <div style="margin-bottom: 10px;">
                                <label for="nama_paket"><strong>Nama Paket:</strong></label><br>
                                <input type="text" id="nama_paket" name="nama_paket" value="${nama_paket}" class="form-control" style="width: 100%;">
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
                let actionUrl = "{{ route('pawonbydudy_paket.paket.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                $('#editPaket').attr('action', actionUrl);    

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const nama_paket = $('#nama_paket').val().trim();

                    let errorMessage = '';

                    if (!nama_paket) errorMessage += 'Harap Masukan isi Paket!.<br>';

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
