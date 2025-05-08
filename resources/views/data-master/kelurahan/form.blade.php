<!-- Modal -->
<div class="modal fade" id="createKelurahanModal" tabindex="-1" aria-labelledby="createKelurahanModalLabel" aria-hidden="true">
    <div class="modal-dialog createKelurahanModal">
        <div class="modal-content">
            <form id="createKecamatanForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKelurahanModalLabel">Create Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        @if(!empty($data))
                            <input type="hidden" class="form-control" name="id" value="{{$data->kode_kelurahan}}">
                        @endif
                        <label for="kodeKecamatan" class="form-label">Kecamatan</label>
                        <select name="kecamatan_id" id="kecamatan_id" class="form-control">
                            <option value="">Pilih Kecamatan</option>
                            @foreach ($kecamatan as $item)
                                <option value="{{$item->kode_kecamatan}}" @if (!empty($data) && $data->kecamatan_id == $item->kode_kecamatan)
                                    selected
                                @endif>{{$item->nama_kecamatan}}</option>
                            @endforeach
                        </select>
                        <label for="kodeKelurahan" class="form-label">Kode Kelurahan</label>
                        <input type="text" class="form-control" id="kodeKelurahan" name="kode_kelurahan" value="@if (!empty($data)) {{$data->kode_kelurahan}} @endif" required>
                        <label for="KelurahanName" class="form-label">Nama Kelurahan</label>
                        <input type="text" class="form-control" id="KelurahanName" name="nama_kelurahan" value="@if (!empty($data)) {{$data->nama_kelurahan}} @endif" required>
                        <label for="is_active" class="form-label">Aktif</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="Y" @if (!empty($data) && $data->is_active == 'Y')
                                selected
                    
                            @endif>Ya</option>
                            <option value="N" @if (!empty($data) && $data->is_active == 'N')
                                selected
                                
                            @endif>Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveKecamatanButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var onLoad = (function() {
        $('#createKelurahanModal').find('.createKelurahanModal').css({
            // 'width': '100%'
        });
        $('#createKelurahanModal').modal('show');
        })();
        $('#createKelurahanModal').on('hidden.bs.modal', function() {
        $('.createKelurahanModal').html('');
    });
    $('#saveKecamatanButton').on('click', function () {
        const form = $('#createKecamatanForm')[0];
        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('store-kelurahan') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message
                    }).then(() => {
                        $('#createKelurahanModal').modal('hide');
                        $('#datagrid').DataTable().ajax.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred.'
                });
            }
        });
    });
</script>