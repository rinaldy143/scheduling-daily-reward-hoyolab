@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-4">
            <!--begin::Card-->
            <h1>Cookies</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Status</th>
                        <th>Actions</th>
                        <th>Cookie</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($cookies)
                        <tr>
                            <td>{{ $cookies->id }}</td>
                            <td>{{ $cookies->user_id }}</td>
                            <td>{{ $cookies->status }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-id="{{ $cookies->id }}" data-cookie="{{ $cookies->cookie }}" data-toggle="modal" data-target="#editModal">
                                    Edit
                                </button>
                            </td>
                            <td>{{ $cookies->cookie }}</td>
                        </tr>
                @else
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada data
                            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#addModal">
                                Tambah Data
                            </button>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

            <!--end:: Card-->
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Cookie Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="cookie">Cookie</label>
                        <textarea class="form-control" name="cookie" id="cookie" placeholder="Enter cookie" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal untuk Menambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Cookie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="new_cookie">Cookie</label>
                        <textarea class="form-control" name="cookie" id="new_cookie" placeholder="Masukkan cookie" rows="3"></textarea>
                    </div>
                    <!-- Tambahkan input lain jika diperlukan -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Menangani pengiriman form untuk menambah data
        $('#addForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form secara default

            var formData = {
                _token: $('input[name="_token"]').val(),
                cookie: $('#new_cookie').val()
            };

            $.ajax({
                url: '{{ route("cookies.store") }}', // Ganti dengan rute yang sesuai untuk menyimpan data
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Tutup modal dan muat ulang halaman atau update tabel
                    $('#addModal').modal('hide');
                    location.reload(); // atau update tabel secara dinamis
                },
                error: function(response) {
                    console.log('Error:', response);
                }
            });
        });
    });

    $(document).on('click', '[data-toggle="modal"]', function() {
        var cookieId = $(this).data('id');
        var cookieValue = $(this).data('cookie');

        // Fill the hidden input and cookie input
        $('#editForm #id').val(cookieId);
        $('#editForm #cookie').val(cookieValue);
    });

    $(document).ready(function() {
        $('#editForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting the default way

            var formData = {
                _token: $('input[name="_token"]').val(),
                id: $('#editForm #id').val(),
                cookie: $('#editForm #cookie').val()
            };

            $.ajax({
                url: '/cookies/update', // The route that will handle the update
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Close the modal and refresh the page or update the table row with new data
                    $('#editModal').modal('hide');
                    location.reload(); // or dynamically update the table row if desired
                },
                error: function(response) {
                    console.log('Error:', response);
                }
            });
        });
    });
</script>
@endsection
