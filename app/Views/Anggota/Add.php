<!-- Modal -->
<div class="modal fade" id="modal-form-anggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Anggota</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-anggota">
                <div class="modal-body">

                    <div class="form-group mb-2">
                        <label for="no_anggota" class="form-label">No. Anggota</label>
                        <input type="text" name="no_anggota" class="form-control" id="no_anggota"
                            placeholder="Contoh (001)">
                        <div class="no_anggota invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama" class="form-label">Nama Anggota</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Masukkan Nama Anggota">
                        <div class="nama invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" value="L" id="L">
                            <label class="form-check-label" for="L">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" value="P" id="P">
                            <label class="form-check-label" for="P">
                                Perempuan
                            </label>
                        </div>
                        <div class="jk invalid-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#form-anggota').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "<?=base_url('anggota/save')?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
            if (response.error) {
                if (response.error.no_anggota) {
                    $('#no_anggota').addClass('is-invalid')
                    $('.no_anggota').html(response.error.no_anggota)
                }
                if (response.error.nama) {
                    $('#nama').addClass('is-invalid')
                    $('.nama').html(response.error.nama)
                }
                if (response.error.jk) {
                    $('.form-check').addClass('is-invalid')
                    $('.jk').html(response.error.jk)
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
                    $('#modal-form-anggota').modal('hide')
                })
            }

        }
    });

});
</script>