<!-- Modal -->
<div class="modal fade" id="modal-form-kriteria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Kriteria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-kriteria">
                <input type="hidden" name="id" value="<?=$data['id']?>">
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="kode" class="form-label">Kode Kriteria</label>
                        <input type="text" name="kode" class="form-control" id="kode" value="<?=$data['kode']?>"
                            placeholder="Contoh (K1)">
                        <div class="kode invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nm_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" name="nm_kriteria" class="form-control" value="<?=$data['nm_kriteria']?>"
                            id="nm_kriteria" placeholder="Masukkan Nama Kriteria">
                        <div class="nm_kriteria invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="bobot" class="form-label">Bobot Kriteria</label>
                        <input type="number" name="bobot" class="form-control" value="<?=$data['bobot']?>" id="bobot"
                            placeholder="Masukkan Bobot Kriteria">
                        <div class="bobot invalid-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#form-kriteria').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "<?=base_url('kriteria/save')?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
            if (response.error) {
                if (response.error.kode) {
                    $('#kode').addClass('is-invalid')
                    $('.kode').html(response.error.kode)
                }
                if (response.error.nm_kriteria) {
                    $('#nm_kriteria').addClass('is-invalid')
                    $('.nm_kriteria').html(response.error.nm_kriteria)
                }
                if (response.error.bobot) {
                    $('#bobot').addClass('is-invalid')
                    $('.bobot').html(response.error.bobot)
                }
            }

            if (response.sukses) {
                Swal.fire({
                    // position: 'top-end',
                    icon: 'success',
                    title: 'Sukses',
                    text: response.msg,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    window.location = response.url
                    $('#modal-form-kriteria').modal('hide')
                })
            }

        }
    });

});
</script>