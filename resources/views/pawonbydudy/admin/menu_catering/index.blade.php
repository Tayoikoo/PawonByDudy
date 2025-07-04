@extends('pawonbydudy.layout.layout')
<!-- Section Item -->
@section('content') 
<span class="d-inline-block d-md-block mt-5"></span>
<div class="container-fluid" style="background: white; border-radius: 10px; padding: 20px;">
    <p class="text-black fs-4 text-center" style="font-family: Righteous;">Daftar Menu Catering</p>
    <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
        <table class="table table-bordered table-striped text-nowrap" style="min-width: 700px;">
            <thead>
                <tr class="text-center">
                    <th>ID Catering</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Tipe Paket</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($catering as $c)
                <tr class="text-center">
                    <td>{{ 'C' . str_pad($c->id_catering, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $c->nama }}</td>
                    <td>Rp.{{ number_format($c->harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $c->paket->nama_paket }}</td>
                    <td>
                        @php
                            $label = '';
                            $bg = '';
                            $color = '';

                            switch ($c->status) {
                                case 0:
                                    $label = 'Private';
                                    $bg = '#FFABA0';
                                    $color = '#FF0000';
                                    break;
                                case 1:
                                    $label = 'Public';
                                    $bg = '#FAFF73';
                                    $color = '#9A9500';
                                    break;
                            }
                        @endphp

                        <span class="fw-bold">
                            <p class="rounded" style="background-color: {{ $bg }}; color: {{ $color }}; padding: 4px;">
                                {{ $label }}
                            </p>
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm btn_detail" 
                            data-id="{{ $c->id_catering }}" 
                            data-nama="{{ $c->nama }}"
                            data-deskripsi="{{ $c->deskripsi }}"
                            data-harga="{{ $c->harga }}"
                            data-foto="{{ asset('storage/' . $c->foto) }}"
                            data-nama_paket="{{ $c->paket->nama_paket }}"
                            data-status="{{ $c->status }}"
                            >
                            Detail
                        </button>                        
                        <button class="btn btn-warning btn-sm btn_edit" 
                            data-id="{{ $c->id_catering }}" 
                            data-nama="{{ $c->nama }}"
                            data-deskripsi="{{ $c->deskripsi }}"
                            data-harga="{{ $c->harga }}"
                            data-foto="{{ asset('storage/' . $c->foto) }}"
                            data-nama_paket="{{ $c->paket->nama_paket }}"
                            data-status="{{ $c->status }}"
                            >
                            Edit
                        </button>
                        <!-- Delete Form -->
                        <form method="POST" action="{{ route('pawonbydudy_catering.catering.destroy', $c->id_catering) }}" style="display: inline-block;">
                            @method('delete')
                            @csrf
                            <button type="submit" data-konf-delete="{{ $c->nama_paket }}" class="btn btn-danger btn-sm show_confirm show_delete">Hapus</button>
                        </form>
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>           
    </div>
    <div class="d-flex justify-content-center">
        {{ $catering->links() }}
    <button class="btn btn-primary d-flex justify-content-center btn_tambah" style="font-family: Righteous;">Tambah Menu</button>
    </div>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.btn_tambah').click(function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tambah Menu',
                    html: `
                        <button type="button" id="closeBtn" style="
                            position: absolute;
                            top: 10px;
                            right: 10px;
                            background: transparent;
                            border: none;
                            font-size: 24px;
                            cursor: pointer;
                        ">&times;</button>

                        <form id="tambahPaket" action="{{ route('pawonbydudy_catering.catering.store') }}" method="POST" enctype="multipart/form-data" style="padding-top: 40px;">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="foto" class="form-label"><strong>Foto Menu:</strong></label>
                                            <img id="previewImage" src="" width="200px" height="200px" style="display:none; margin-top:10px; max-width:100%; border:1px solid #ccc; padding:5px;" />
                                            <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="nama" class="form-label"><strong>Nama Menu:</strong></label>
                                            <input type="text" id="nama" name="nama" value="" class="form-control" placeholder="Masukkan nama menu">
                                        </div>
                                        <div class="form-group">
                                            <label for="deskripsi" class="form-label"><strong>Deskripsi Menu:</strong></label>
                                            <textarea id="ckeditor" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi menu"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga" class="form-label"><strong>Harga:</strong></label>
                                            <input type="text" id="harga" name="harga" value="" class="form-control" placeholder="Masukkan harga">
                                        </div>
                                        <div class="form-group">
                                            <label for="id_paket" class="form-label"><strong>Tipe Paket:</strong></label>
                                            <select id="id_paket" name="id_paket" class="form-select">
                                                <option value="">-- Pilih Paket --</option>
                                                @foreach ($paket as $p)
                                                    <option value="{{ $p->id_paket }}">{{ $p->nama_paket }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary w-100">Tambah</button>
                            </div>
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: true,
                    width: '900px',
                    didOpen: () => {
                        const fileInput = document.getElementById('foto');
                        const preview = document.getElementById('previewImage');

                        fileInput.addEventListener('change', function () {
                            const file = this.files[0];
                            if (file && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                };
                                reader.readAsDataURL(file);
                            } else {
                                preview.src = '';
                                preview.style.display = 'none';
                            }
                        });
                        
                        document.getElementById('closeBtn').addEventListener('click', () => {
                            Swal.close();
                        });                                

                        const ckeditorElement = document.querySelector('#ckeditor');
                        if (ckeditorElement) {
                            ClassicEditor
                                .create(ckeditorElement)
                                .catch(error => {
                                    console.error('CKEditor init failed:', error);
                                });
                        }                        
                    }                    
                });

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const nama = $('#nama').val().trim();
                    const deskripsi = $('#ckeditor').val().trim();
                    const harga = $('#harga').val().trim();

                    let errorMessage = '';

                    if (!nama) errorMessage += 'Harap Masukan isi Nama!.<br>';
                    if (!deskripsi) errorMessage += 'Harap Masukan isi Deskripsi!.<br>';
                    if (!harga) errorMessage += 'Harap Masukan isi Harga!.<br>';

                    if (errorMessage) {
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        $('#cateringForm').submit();
                    }
                });

            });

            $('.btn_edit').click(function (event) {
                event.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const deskripsi = $(this).data('deskripsi');
                const harga = $(this).data('harga');
                const foto = $(this).data('foto');
                const paket = $(this).data('nama_paket');
                const status = $(this).data('status');

                Swal.fire({
                    title: 'Edit Menu',
                    html: `
                        <button type="button" id="closeBtn" style="
                            position: absolute;
                            top: 10px;
                            right: 10px;
                            background: transparent;
                            border: none;
                            font-size: 24px;
                            cursor: pointer;
                        ">&times;</button>                    
                        <form id="editPaket" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">${nama}</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="foto" class="form-label"><strong>Foto Menu:</strong></label>
                                            <img id="previewImage" src="" width="200px" height="200px" style="display:none; margin-top:10px; max-width:100%; border:1px solid #ccc; padding:5px;" />
                                            <input type="file" id="foto" name="foto" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="nama" class="form-label"><strong>Nama Menu:</strong></label>
                                            <input type="text" id="nama" name="nama" value="${nama}" class="form-control">                                        
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"><strong>Deskripsi Menu:</strong></label>
                                            <textarea id="ckeditor" name="deskripsi" class="form-control">${deskripsi}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="harga" class="form-label"><strong>Harga:</strong></label>
                                            <input type="text" id="harga" name="harga" value="${harga}" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="id_paket" class="form-label"><strong>Tipe Paket:</strong></label>
                                            <select id="id_paket" name="id_paket" class="form-select">
                                                <option value="">-- Pilih Paket --</option>
                                                @foreach ($paket as $p)
                                                    <option value="{{ $p->id_paket }}">{{ $p->nama_paket }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status" class="form-label"><strong>Status:</strong></label>
                                            <select id="status" name="status" class="form-select">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="0">Private</option>
                                                <option value="1">Public</option>
                                            </select>
                                        </div>                                                                                                                                 
                                    </div>
                                </div>
                            </div>

                            <!-- Full-width submit button -->
                            <div class="col-12 text-center mt-4">
                                <button type="button" id="submitForm" class="btn btn-primary w-100">Simpan</button>
                            </div>
                        </form>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: true,
                    width: "900px",
                    didOpen: () => {
                        const fileInput = document.getElementById('foto');
                        const preview = document.getElementById('previewImage');

                        // Show current image from data-foto
                        if (foto) {
                            preview.src = foto;
                            preview.style.display = 'block';
                        }

                        // Live preview when uploading new file
                        fileInput.addEventListener('change', function () {
                            const file = this.files[0];
                            if (file && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        document.getElementById('closeBtn').addEventListener('click', () => {
                            Swal.close();
                        });                        

                        const ckeditorElement = document.querySelector('#ckeditor');
                        if (ckeditorElement) {
                            ClassicEditor
                                .create(ckeditorElement)
                                .catch(error => {
                                    console.error('CKEditor init failed:', error);
                                });
                        }   
                    }            
                });

                // Set the form action dynamically after Swal has opened
                let actionUrl = "{{ route('pawonbydudy_catering.catering.update', ':id') }}";
                actionUrl = actionUrl.replace(':id', id);
                $('#editPaket').attr('action', actionUrl);

                $('#submitForm').click(function () {
                    // Validate form inputs
                    const nama = $('#nama').val().trim();
                    const deskripsi = $('#ckeditor').val().trim();
                    const harga = $('#harga').val().trim();

                    let errorMessage = '';

                    if (!nama) errorMessage += 'Harap Masukan isi Nama Menu!.<br>';
                    if (!deskripsi) errorMessage += 'Harap Masukan isi Deskripsi!.<br>';
                    if (!harga) errorMessage += 'Harap Masukan isi Harga!.<br>';

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

            $('.btn_detail').click(function (event) {
                event.preventDefault();

                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const deskripsi = $(this).data('deskripsi');
                const harga = $(this).data('harga');
                const foto = $(this).data('foto');
                const paket = $(this).data('nama_paket');
                const status = $(this).data('status'); // e.g., 0 or 1

                let label = '';
                let bg = '';
                let color = '';

                switch (status) {
                    case 0:
                        label = 'Private';
                        bg = '#FFABA0';
                        color = '#FF0000';
                        break;
                    case 1:
                        label = 'Public';
                        bg = '#FAFF73';
                        color = '#9A9500';
                        break;
                    default:
                        label = 'Unknown';
                        bg = '#EEE';
                        color = '#666';
                        break;
                }

                let hargaString = String(harga);
                let formattedPrice = hargaString.replace('Rp.', '').trim();
                formattedPrice = new Intl.NumberFormat('id-ID').format(formattedPrice);

            Swal.fire({
                title: "Detail Menu",
                html: `
                    <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
                        <table class="table table-bordered table-striped text-nowrap" style="min-width: 700px;">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Menu</th>
                                    <th>Foto</th>
                                    <th>Nama Menu</th>
                                    <th>Harga</th>
                                    <th>Tipe Paket</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${id}</td>
                                    <td><img src="${foto}" width="100px" height="100px" style="object-fit: cover;"></td>                                        
                                    <td>${nama}</td>
                                    <td>Rp. ${formattedPrice}</td>
                                    <td>${paket}</td>
                                    <td>
                                        <span class="fw-bold">
                                            <p class="rounded" style="background-color: ${bg}; color: ${color}; padding: 5px; margin: 0;">
                                                ${label}
                                            </p>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `,
                confirmButtonText: 'Tutup',
                width: '100%'
            });

            });
        });
</script>

@endsection
