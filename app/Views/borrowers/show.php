<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Detail Peminjam</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <a href="<?= base_url('borrowers') ?>">Data Peminjam</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>
    <a href="<?= base_url('borrowers/edit/' . $borrower['id']) ?>" class="btn btn-outline">Edit Peminjam</a>
</div>

<div class="card">
    <div class="card-body">
        <dl class="detail-grid">
            <dt>Nama</dt>
            <dd><?= esc($borrower['nama']) ?></dd>

            <dt>Identitas</dt>
            <dd><?= esc($borrower['identitas']) ?></dd>

            <dt>Kelas</dt>
            <dd><?= esc($borrower['kelas'] ?: '-') ?></dd>

            <dt>No. HP</dt>
            <dd><?= esc($borrower['no_hp'] ?: '-') ?></dd>

            <dt>Terdaftar</dt>
            <dd><?= esc(date('d M Y H:i', strtotime($borrower['created_at']))) ?></dd>
        </dl>
    </div>
</div>

<?= $this->endSection() ?>
