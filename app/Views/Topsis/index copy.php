<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOPSIS</title>
</head>

<body>
    <?php
    // var_dump($list_alternatif);

    ?>

    <p>
        Nilai Alternatif
    </p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alternatif</th>
                <?php
                foreach ($list_kriteria as $k) {?>
                <th><?=$k['kode']?></th>
                <?php } ?>

            </tr>
        </thead>
        <tbody>
            <?php
            $no =1;
            $pangkat = []; // Untuk menyimpan hasil pangkat
            // Daftar NilaiAlternatif
            foreach ($list_alternatif as $a) {?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$a['nama']?></td>
                <?php
                foreach ($list_kriteria as $k) {
                    $nilai_alternatif = NilaiAlternatif($a['id_anggota'], $k['id']);
                          // Menghitung pangkat (kuadrat)
                $nilai_pangkat = POW($nilai_alternatif->nilai, 2);
                $pangkat[$k['id']][] = $nilai_pangkat;


                    ?>
                <td><?=$nilai_alternatif->nilai?></td>
                <?php } ?>
            </tr>
            <?php 
        
        } ?>
        </tbody>
        <tr>
            <td colspan="2">Pangkat</td>

            <?php
            // Hasil Nilai Pangkat 
        foreach ($list_kriteria as $k) {?>
            <td><?=array_sum($pangkat[$k['id']])?></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="2">Akar</td>
            <?php
            // Hasil Nilai Akar
        foreach ($list_kriteria as $k) {
            $hasil_pangkat = array_sum($pangkat[$k['id']]);
            $hasil_akar = SQRT($hasil_pangkat);
                   // Update nilai akar ke tabel kriteria
        $data = [
            'nilai_akar' => $hasil_akar
        ];

        updateNilaiAkar($k['id'], $data);
            
            ?>
            <td>

                <?=number_format($hasil_akar, 4)?>
            </td>
            <?php } ?>
        </tr>

    </table>

    <p>
        Normalisasi Matriks
    </p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alternatif</th>
                <?php
                foreach ($list_kriteria as $k) {?>
                <th><?=$k['kode']?></th>
                <?php } ?>

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
                    //    Normalisasi 
                    $nilai_a = $nilai_alternatif->nilai;
                    $hasil_normaliasi = $nilai_a / $k['nilai_akar'];
                  
                    ?>
                <td><?=number_format($hasil_normaliasi, 4)?></td>
                <?php } ?>
            </tr>
            <?php 
        } ?>
        </tbody>
        <tr>
            <td colspan="2">Bobot Ternormaliasisi</td>

            <?php
            $totalBobot = TotalBobot()->bobot;
            foreach ($list_kriteria as $k) {
                $bobot_ternormalisasi = $k['bobot']/$totalBobot;
                ?>
            <td><?=$bobot_ternormalisasi?></td>
            <?php
            }
            ?>

        </tr>
    </table>

    <p>
        Normalisasi Matriks terbobot
    </p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alternatif</th>
                <?php
                foreach ($list_kriteria as $k) {?>
                <th><?=$k['kode']?></th>
                <?php } ?>

            </tr>
        </thead>
        <tbody>
            <?php
            $no =1;
            $totalBobot = TotalBobot()->bobot;
            $maxValues = []; // Untuk menyimpan nilai maksimum
            $minValues = []; // Untuk menyimpan nilai minimum
            foreach ($list_alternatif as $a) {?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$a['nama']?></td>
                <?php
                foreach ($list_kriteria as $k) {
                    $nilai_alternatif = NilaiAlternatif($a['id_anggota'], $k['id']);
                    //    Normalisasi 
                    $nilai_a = $nilai_alternatif->nilai;
                    $hasil_normaliasi = $nilai_a / $k['nilai_akar'];
                    $bobot_ternormalisasi = $k['bobot']/$totalBobot;
                    // HASIL NORMALISASI TERBOBOT 
                    $hasil_normaliasi_terbobot = $hasil_normaliasi*$bobot_ternormalisasi;

                       // Menyimpan nilai maksimum dan minimum
                if (!isset($maxValues[$k['id']]) || $hasil_normaliasi_terbobot > $maxValues[$k['id']]) {
                    $maxValues[$k['id']] = $hasil_normaliasi_terbobot;
                }
                if (!isset($minValues[$k['id']]) || $hasil_normaliasi_terbobot < $minValues[$k['id']]) {
                    $minValues[$k['id']] = $hasil_normaliasi_terbobot;
                }
                  
                    ?>
                <td><?=number_format($hasil_normaliasi_terbobot, 4)?></td>
                <?php } ?>
            </tr>
            <?php 
        } ?>
        </tbody>
        <tr>
            <td colspan="2">MAX</td>
            <?php
        foreach ($list_kriteria as $k) {
             // Menyimpan nilai maksimum dan minimum ke tabel kriteria
    simpanNilaiMax($k['id'], $maxValues[$k['id']]);

            ?>
            <td><?=number_format($maxValues[$k['id']], 4)?></td>
            <?php
        }
        ?>
        </tr>

        <tr>
            <td colspan="2">MIN</td>
            <?php
        foreach ($list_kriteria as $k) {
            simpanNilaiMin($k['id'], $minValues[$k['id']]);
            ?>
            <td><?=number_format($minValues[$k['id']], 4)?></td>
            <?php
        }
        ?>
        </tr>
    </table>


    <p>
        Menghitung karak ideal Positif (D+)
    </p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alternatif</th>
                <?php
                foreach ($list_kriteria as $k) {?>
                <th><?=$k['kode']?></th>
                <?php } ?>
                <th>SUM</th>
                <th>D +</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $no =1;
            $totalBobot = TotalBobot()->bobot;
            $maxValues = []; // Untuk menyimpan nilai maksimum
            foreach ($list_alternatif as $a) {?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$a['nama']?></td>
                <?php
                $dPlusAlternatif = 0; // Untuk menyimpan D+ per alternatif
                $hasil_pangkat_dplus =0;
                foreach ($list_kriteria as $k) {
                    $nilai_alternatif = NilaiAlternatif($a['id_anggota'], $k['id']);
                    //    Normalisasi 
                    $nilai_a = $nilai_alternatif->nilai;
                    $hasil_normaliasi = $nilai_a / $k['nilai_akar'];
                    $bobot_ternormalisasi = $k['bobot']/$totalBobot;
                    // HASIL NORMALISASI TERBOBOT 
                    $hasil_normaliasi_terbobot = $hasil_normaliasi*$bobot_ternormalisasi;
                    // Ambil nilai max setiap kriteria 
                    $nilai_max = $k['nilai_max'];
                    
                    $d_plus = POW(($hasil_normaliasi_terbobot-$nilai_max), 2);
                    $dPlusAlternatif += $d_plus;
                    $hasil_pangkat_dplus = SQRT($dPlusAlternatif);
                    ?>
                <td><?=number_format($d_plus, 4)?></td>
                <?php } ?>
                <td><?=number_format($dPlusAlternatif, 4)?></td>
                <td><?=number_format($hasil_pangkat_dplus, 4)?></td>
            </tr>

            <?php 
        } 
        
        ?>
        </tbody>

    </table>



    <p>
        Menghitung karak ideal Negatif (D-)
    </p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alternatif</th>
                <?php
                foreach ($list_kriteria as $k) {?>
                <th><?=$k['kode']?></th>
                <?php } ?>
                <th>SUM</th>
                <th>D -</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $no =1;
            $totalBobot = TotalBobot()->bobot;
            $maxValues = []; // Untuk menyimpan nilai maksimum
            foreach ($list_alternatif as $a) {?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$a['nama']?></td>
                <?php
                $dMinAlternatif = 0; // Untuk menyimpan D- per alternatif

                $hasil_pangkat_dmin =0;
                foreach ($list_kriteria as $k) {
                    $nilai_alternatif = NilaiAlternatif($a['id_anggota'], $k['id']);
                    //    Normalisasi 
                    $nilai_a = $nilai_alternatif->nilai;
                    $hasil_normaliasi = $nilai_a / $k['nilai_akar'];
                    $bobot_ternormalisasi = $k['bobot']/$totalBobot;
                    // HASIL NORMALISASI TERBOBOT 
                    $hasil_normaliasi_terbobot = $hasil_normaliasi*$bobot_ternormalisasi;
                    // Ambil nilai min setiap kriteria 
                    // Min  
                    $nilai_min = $k['nilai_min'];
                    $d_min = POW(($hasil_normaliasi_terbobot-$nilai_min), 2);
                    $dMinAlternatif += $d_min;
                    $hasil_pangkat_dmin = SQRT($dMinAlternatif);
                    ?>
                <td><?=number_format($d_min, 4)?></td>
                <?php } ?>
                <td><?=number_format($dMinAlternatif, 4)?></td>
                <td><?=number_format($hasil_pangkat_dmin, 4)?></td>
            </tr>

            <?php 

        } 
        
        ?>
        </tbody>

    </table>


    <p>
        HASIL
    </p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Alternatif</th>
                <th>HASIL</th>
            </tr>
        </thead>
        <tbody>
            <?php
        $no = 1;
        $totalBobot = TotalBobot()->bobot;

        foreach ($list_alternatif as $a) {?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$a['nama']?></td>
                <?php
            $dPlusAlternatif = 0; // Untuk menyimpan D+ per alternatif
            $dMinAlternatif = 0; // Untuk menyimpan D- per alternatif

            foreach ($list_kriteria as $k) {
                $nilai_alternatif = NilaiAlternatif($a['id_anggota'], $k['id']);
                // Normalisasi 
                $nilai_a = $nilai_alternatif->nilai;
                $hasil_normaliasi = $nilai_a / $k['nilai_akar'];
                $bobot_ternormalisasi = $k['bobot'] / $totalBobot;
                // HASIL NORMALISASI TERBOBOT 
                $hasil_normaliasi_terbobot = $hasil_normaliasi * $bobot_ternormalisasi;

                // Plus 
                $nilai_max = $k['nilai_max'];
                $d_plus = pow(($hasil_normaliasi_terbobot - $nilai_max), 2);
                $dPlusAlternatif += $d_plus;

                // Min  
                $nilai_min = $k['nilai_min'];
                $d_min = pow(($hasil_normaliasi_terbobot - $nilai_min), 2);
                $dMinAlternatif += $d_min;
            }

            // Menghitung Pi
            $hasil_pangkat_dplus = sqrt($dPlusAlternatif);
            $hasil_pangkat_dmin = sqrt($dMinAlternatif);
            $nilai_topsis = $hasil_pangkat_dmin / ($hasil_pangkat_dplus + $hasil_pangkat_dmin);
            ?>
                <td><?=number_format($nilai_topsis, 4)?></td>
            </tr>
            <?php 
        } 
        ?>
        </tbody>
    </table>






</body>

</html>