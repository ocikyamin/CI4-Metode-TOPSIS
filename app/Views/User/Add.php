<!-- Modal -->
<div class="modal fade" id="modal-form-user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">New User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-user">
                <div class="modal-body">

                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email"
                            placeholder="Contoh yobi@gmail.com">
                        <div class="email invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nama_user" class="form-label">Nama User</label>
                        <input type="text" name="nama_user" class="form-control" id="nama_user"
                            placeholder="Masukkan Nama User">
                        <div class="nama_user invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="new_pass" class="form-label">Password Baru</label>
                        <input type="text" name="new_pass" class="form-control" id="new_pass"
                            placeholder="Password Baru">
                        <div class="new_pass invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-2">
                        <label for="conf_pass" class="form-label">Konfirmasi Password</label>
                        <input type="text" name="conf_pass" class="form-control" id="conf_pass"
                            placeholder="Password Baru">
                        <div class="conf_pass invalid-feedback"></div>
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
$('#form-user').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "<?=base_url('user/save')?>",
        data: $(this).serialize(),
        dataType: "json",
        success: function(response) {
            if (response.error) {
                if (response.error.email) {
                    $('#email').addClass('is-invalid')
                    $('.email').html(response.error.email)
                }
                if (response.error.nama_user) {
                    $('#nama_user').addClass('is-invalid')
                    $('.nama_user').html(response.error.nama_user)
                }
                if (response.error.new_pass) {
                    $('#new_pass').addClass('is-invalid')
                    $('.new_pass').html(response.error.new_pass)
                }
                if (response.error.conf_pass) {
                    $('#conf_pass').addClass('is-invalid')
                    $('.conf_pass').html(response.error.conf_pass)
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
                    $('#modal-form-user').modal('hide')
                })
            }

        }
    });

});
</script>