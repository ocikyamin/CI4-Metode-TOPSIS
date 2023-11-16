<!-- Modal -->
<div class="modal fade" id="modal-form-alternatif" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Nilai Alternatif</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-alternatif">
                <div class="modal-body">

                    <div class="form-group mb-2">
                        <label for="anggota" class="form-label">Anggota </label>
                        <select name="anggota" id="anggota" class="form-control">
                            <option value="">Pilih Nama Anggota</option>
                            <?php
                            foreach ($anggota as $a) {?>
                            <option value="<?=$a['id']?>"><?=$a['nama']?></option>
                            <?php } ?>
                        </select>
                        <div class="anggota invalid-feedback"></div>
                    </div>
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>No.</th>
                            <th>Kriteria</th>
                            <th>Nilai</th>
                        </tr>
                        <?php
                           $jumlah_kriteria = 0;
                           $no=1;
                        foreach ($kriteria as $k) {?>
                        <tr>
                            <input type="hidden" name="kriteria[]" value="<?=$k['id']?>">
                            <td class="mid"><?=$no++?>.</td>
                            <td class="mid"><?=$k['nm_kriteria']?> (<?=$k['kode']?>)</td>
                            <td>
                                <?php
                                foreach (SubKriteria($k['id']) as $s) {?>

                                <div class="form-check form-switch">
                                    <span class="badge text-bg-success"><?=$s['range']?></span>
                                    <input class="range form-check-input" name="range[<?=$k['id']?>]" type="radio"
                                        data-kriteria-id="<?=$k['id']?>" value="<?=$s['range']?>">
                                    <label class="form-check-label" for="range-<?=$s['id']?>">
                                        <?=$s['keterangan']?></label>
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php 
                         $jumlah_kriteria++;
                    } ?>


                    </table>


                </div>
                <div class="mb-4 mt-3 text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" id="btn-simpan-nilai" disabled class="btn btn-warning d-none"> <span
                            class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
                        <span class="visually-hidden" role="status">Loading...</span></button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Tambahkan Script jQuery untuk mengatur status checked -->
<script>
$(document).ready(function() {
    var jumlah_kriteria = <?= empty($jumlah_kriteria) ? 0 : $jumlah_kriteria ?>
    // Hanya satu checkbox dalam setiap baris yang dapat dipilih
    $(".range").on("click", function() {
        var row = $(this).closest("tr");
        row.find(".range").not(this).prop("checked", false);
    });

    $(".range").on("change", function() {
        // hitungJumlahNilai()
        var totalChecked = $(".range:checked").length;
        if (totalChecked !== jumlah_kriteria) {

            is_inactiveBtn()
        } else {

            is_activeBtn()
        }
    });


    function is_activeBtn() {
        $('#btn-simpan-nilai').prop('disabled', false)
        $('#btn-simpan-nilai').html('Ya, Simpan Nilai')
        $('#btn-simpan-nilai').removeClass('btn-warning')
        $('#btn-simpan-nilai').removeClass('d-none')
        $('#btn-simpan-nilai').addClass('btn-primary')
    }

    function is_inactiveBtn() {
        $('#btn-simpan-nilai').prop('disabled', true)
        $('#btn-simpan-nilai').addClass('btn-warning')
        $('#btn-simpan-nilai').html(`<span class="spinner-grow spinner-grow-sm" aria-hidden="true"></span>
  <span role="status"> Isian Nilai Belum Lengkap ..</span>`)
    }



    $("#anggota").on("change", function() {
        var selectedAnggota = $(this).val();

        $.ajax({
            url: "<?=base_url('alternatif/get-nilai')?>", // Ganti dengan URL yang sesuai untuk mengambil data alternatif
            method: "POST",
            data: {
                anggota: selectedAnggota
            },
            dataType: "json",
            success: function(data) {
                // Reset status checked on radio options
                $("input[type='radio']").prop("checked", false);
                if (data.length > 0) {
                    $.each(data, function(index, item) {
                        var kriteria_id = item.kriteria_id;
                        var range_value = item.nilai;

                        var radioBtn = $("input[name='range[" + kriteria_id +
                            "]'][value='" + range_value + "']");
                        radioBtn.prop("checked", true);

                    });
                    is_activeBtn()
                } else {
                    is_inactiveBtn()
                }


            },
            error: function() {
                console.log("Gagal mengambil data alternatif.");
            }
        });
    });

    // ... (Kode JavaScript lainnya yang sudah Anda miliki)

    $('#form-alternatif').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?=base_url('alternatif/save')?>",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    if (response.error.anggota) {
                        $('#anggota').addClass('is-invalid')
                        $('.anggota').html(response.error.anggota)
                    }
                    if (response.error.range) {
                        $('#range').addClass('is-invalid')
                        $('.range').html(response.error.range)
                    }
                }

                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.msg,
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location = response.url
                        $('#modal-form-alternatif').modal('hide')
                    })
                }
            }
        });
    });
});
</script>