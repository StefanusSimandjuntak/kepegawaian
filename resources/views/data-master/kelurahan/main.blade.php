@extends('components.app')
@section('css')
@endsection
@section('contents')
    <div class="row main-page">
        <div class="col-12">
            <div class="card main-page">
                <div class="card-body">
                    <div class="table-responsive">
                        <button type="button" class="btn btn-primary btn-add"> <i class="bx bx-plus me-1"></i>Tambah
                            {{ $title }}</button>
                        <table class="table table-striped dataTable" id="datagrid" style="width: 100%">
                            <thead>
                                <td>NO</td>
                                <td>KODE KELURAHAN</td>
                                <td>NAMA KELURAHAN</td>
                                <td>NAMA KECAMATAN</td>
                                <td>AKTIF</td>
                                <td>AKSI</td>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal"></div>
            <div class="other-page"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#datagrid').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kelurahan') }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_kelurahan',
                        name: 'kode_kelurahan',
                    },
                    {
                        data: 'nama_kelurahan',
                        name: 'nama_kelurahan',
                    },
                    {
                        data: 'kecamatan.nama_kecamatan',
                        name: 'kecamatan.nama_kecamatan',
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                order: [
                    [0, 'asc']
                ],
            });

            $('.btn-add').on('click', function() {
                $.post("{!! route('create-kelurahan') !!}").done(function(data) {
                    if (data.status == 'success') {
                        $('.other-page').html(data.content).fadeIn();
                    } else {
                        $('.main-page').show();
                    }
                });
            });
        });

        function editForm(id) {
            $.post("{!! route('create-kelurahan') !!}",{id:id}).done(function(data){
                if(data.status == 'success'){
                  $('.other-page').html(data.content).fadeIn();
                } else {
                  $('.main-page').show();
                }
            });
        }

        function deleteForm(id) {
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: "{!! route('delete-kelurahan') !!}",
                type: 'POST',
                data: { id: id },
                success: function(data) {
                  if (data.status == 'success') {
                    Swal.fire(
                      'Terhapus!',
                      'Data berhasil dihapus.',
                      'success'
                    );
                    $('#datagrid').DataTable().ajax.reload();
                  } else {
                    Swal.fire(
                      'Gagal!',
                      'Terjadi kesalahan saat menghapus data.',
                      'error'
                    );
                  }
                },
                error: function() {
                  Swal.fire(
                    'Gagal!',
                    'Terjadi kesalahan saat menghapus data.',
                    'error'
                  );
                }
              });
            }
          });
        }
    </script>
@endsection
