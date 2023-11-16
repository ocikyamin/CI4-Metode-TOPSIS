<?= $this->extend('User/Template') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="text-center">
            <h5 class="mb-4">Selamat Datang [ <b><?=UserLogin()->nama_user?></b> ]</h5>
            <img src="<?=base_url('assets/images/logos/koperasi.png')?>" alt="logo" width="150">
            <h3 class="text-success" style="text-transform:uppercase">Identifikasi Besaran Dana Pinjaman
                Secara Tepat
                dalm Pemberian Kredit
                Menggunakan Metode
                TOPSIS</h3>
        </div>
    </div>
</div>
<?= $this->endSection() ?>