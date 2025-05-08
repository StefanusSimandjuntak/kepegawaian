<!-- Modal -->
<div class="modal fade" id="createProvinsiModal" tabindex="-1" aria-labelledby="createProvinsiModalLabel" aria-hidden="true">
    <div class="modal-dialog createProvinsiModal">
        <div class="modal-content">
            <form id="createProvinsiForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProvinsiModalLabel">Create Provinsi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        @if(!empty($data))
                            <input type="hidden" class="form-control" name="id" value="{{$data->kode_provinsi}}">
                        @endif
                        <label for="kodeProvinsi" class="form-label">Kode Provinsi</label>
                        <input type="text" class="form-control" id="kodeProvinsi" name="kode_provinsi" value="@if (!empty($data)) {{$data->kode_provinsi}} @endif" required>
                        <label for="ProvinsiName" class="form-label">Nama Provinsi</label>
                        <input type="text" class="form-control" id="ProvinsiName" name="nama_provinsi" value="@if (!empty($data)) {{$data->nama_provinsi}} @endif" required>
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
                    <button type="button" class="btn btn-primary" id="saveProvinsiButton">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var onLoad = (function() {
        $('#createProvinsiModal').find('.createProvinsiModal').css({
            // 'width': '100%'
        });
        $('#createProvinsiModal').modal('show');
        })();
        $('#createProvinsiModal').on('hidden.bs.modal', function() {
        $('.createProvinsiModal').html('');
    });
    $('#saveProvinsiButton').on('click', function () {
        const form = $('#createProvinsiForm')[0];
        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('store-provinsi') }}",
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
                        $('#createProvinsiModal').modal('hide');
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