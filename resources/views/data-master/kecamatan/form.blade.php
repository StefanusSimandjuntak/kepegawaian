<!-- Modal -->
<div class="modal fade" id="createKecamatanModal" tabindex="-1" aria-labelledby="createKecamatanModalLabel" aria-hidden="true">
    <div class="modal-dialog createKecamatanModal">
        <div class="modal-content">
            <form id="createKecamatanForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKecamatanModalLabel">Create Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        @if(!empty($data))
                            <input type="hidden" class="form-control" name="id" value="{{$data->kode_kecamatan}}">
                        @endif
                        <label for="kodeKecamatan" class="form-label">Kode Kecamatan</label>
                        <input type="text" class="form-control" id="kodeKecamatan" name="kode_kecamatan" value="@if (!empty($data)) {{$data->kode_kecamatan}} @endif" required>
                        <label for="KecamatanName" class="form-label">Nama Kecamatan</label>
                        <input type="text" class="form-control" id="KecamatanName" name="nama_kecamatan" value="@if (!empty($data)) {{$data->nama_kecamatan}} @endif" required>
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
        $('#createKecamatanModal').find('.createKecamatanModal').css({
            // 'width': '100%'
        });
        $('#createKecamatanModal').modal('show');
        })();
        $('#createKecamatanModal').on('hidden.bs.modal', function() {
        $('.createKecamatanModal').html('');
    });
    $('#saveKecamatanButton').on('click', function () {
        const form = $('#createKecamatanForm')[0];
        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('store-kecamatan') }}",
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
                        $('#createKecamatanModal').modal('hide');
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