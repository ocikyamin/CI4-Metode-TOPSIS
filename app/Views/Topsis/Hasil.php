<?= $this->extend('User/Template') ?>
<?= $this->section('content') ?>
<div class="alert alert-info mb-3 text-center">

    <h4>(TOPSIS)</h4>
    <h5 class="card-title fw-semibold">Technique for Order Preference by Similarity to Ideal Solution</h5>
</div>
<div class="card">
    <div class="card-body">
        <p>
        <h5 class="card-title fw-semibold mb-2"> Keputusan Besaran Pinjaman</h5>
        </p>
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Alternatif</th>
                    <th>Nilai (Pi)</th>
                    <th>Range Nilai</th>
                    <th class="text-center bg-success text-white">Keputusan Besaran Pinjaman</th>
                </tr>
            </thead>
            <tbody>
                <?php
        $no = 1;
        $totalBobot = TotalBobot()->bobot;

        foreach ($hasil as $a) {?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=$a['nama']?></td>
                    <?php
                    $hasil_keputusan = hitungBesarPinjaman($a['nilai']);
                    $ket = Keputusan($a['nilai']);

                    ?>
                    <td><?=number_format($a['nilai'], 5)?></td>
                    <td> <?=$ket?></td>
                    <td class="text-center">
                        <?=$hasil_keputusan?>
                    </td>
                </tr>
                <?php 
        } 
        ?>
            </tbody>
        </table>



    </div>
</div>
<?= $this->endSection() ?>