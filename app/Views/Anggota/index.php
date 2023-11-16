<?= $this->extend('User/Template') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Anggota Koperasi</h5>
        <p class="mb-0">
            <button id="add" class="btn btn-primary">Tambah</button>
        </p>
        <div class="table-responsive mt-4">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No.Anggota</th>
                        <th>Nama</th>
                        <th>Jk</th>
                        <th><i class="ti ti-settings"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no =1;
                    foreach ($anggota as $k) {?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$k['no_anggota']?></td>
                        <td><?=$k['nama']?></td>
                        <td><?=$k['jk']?></td>
                        <td>
                            <button onclick="Edit(<?=$k['id']?>)" class="btn btn-info btn-sm">Edit</button>
                            <button onclick="Hapus(<?=$k['id']?>)" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modalview"></div>
<script>
$('#add').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?=base_url('anggota/add')?>",
        data: 'data',
        dataType: "json",
        success: function(response) {
            $('.modalview').html(response.form).show()
            $('#modal-form-anggota').modal('show')
        }
    });
});

function Edit(id) {
    $.ajax({
        url: "<?=base_url('anggota/edit')?>",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response) {
            $('.modalview').html(response.form).show()
            $('#modal-form-anggota').modal('show')
        }
    });

}

function Hapus(id) {

    Swal.fire({
        title: 'Hapus Data?',
        text: "Apakah Anda Yakin ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?=base_url('anggota/delete')?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
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
                        })
                    }
                }
            });

        }
    })




}
</script>
<?= $this->endSection() ?>