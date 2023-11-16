<?= $this->extend('User/Template') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Nilai Alternatif</h5>
        <p class="mb-0">
            <button id="add" class="btn btn-primary">Pengaturan Nilai</button>
        </p>
        <div class="table-responsive mt-4">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="mid">No</th>
                        <th class="mid">Alternatif</th>
                        <?php
                        foreach ($list_kriteria as $k) {?>
                        <th class="text-center"> (<?=$k['kode']?>) <br>
                            <?=$k['nm_kriteria']?>
                        </th>
                        <?php } ?>
                        <th><i class="ti ti-settings"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no =1;
                    foreach ($list_alternatif as $a) {?>
                    <tr>
                        <td><?=$no++?></td>
                        <td><?=$a['nama']?></td>
                        <?php
                            foreach ($list_kriteria as $k) {
                            $nilai_alternatif = NilaiAlternatif($a['id_anggota'], $k['id']);
                            ?>
                        <td class="text-center"><?= $nilai_alternatif == NULL ? 0 : $nilai_alternatif->nilai ?></td>
                        <?php
                        }
                        ?>
                        <td>
                            <button onclick="Hapus(<?=$a['id_anggota']?>)" class="btn btn-danger btn-sm">Hapus</button>
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
        url: "<?=base_url('alternatif/add')?>",
        data: 'data',
        dataType: "json",
        success: function(response) {
            $('.modalview').html(response.form).show()
            $('#modal-form-alternatif').modal('show')
        }
    });
});

function Edit(id) {
    $.ajax({
        url: "<?=base_url('kriteria/edit')?>",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response) {
            $('.modalview').html(response.form).show()
            $('#modal-form-kriteria').modal('show')
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
                url: "<?=base_url('alternatif/delete')?>",
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