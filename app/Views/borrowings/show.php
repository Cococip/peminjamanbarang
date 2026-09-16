<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Detail Peminjaman</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <a href="<?= base_url('borrowings') ?>">Peminjaman</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="detail-grid">
            <dt>Kode Peminjaman</dt>
            <dd><?= esc($borrowing['kode_peminjaman']) ?></dd>

            <dt>Barang</dt>
            <dd><?= esc($borrowing['nama_barang']) ?> (<?= esc($borrowing['kode_barang']) ?>)</dd>

            <dt>Peminjam</dt>
            <dd><?= esc($borrowing['nama_peminjam']) ?> (<?= esc($borrowing['identitas']) ?>)</dd>

            <dt>Jumlah</dt>
            <dd><?= (int) $borrowing['jumlah'] ?> unit</dd>

            <dt>Tanggal Pinjam</dt>
            <dd><?= esc(date('d M Y', strtotime($borrowing['tanggal_pinjam']))) ?></dd>

            <dt>Rencana Kembali</dt>
            <dd><?= esc(date('d M Y', strtotime($borrowing['tanggal_kembali']))) ?></dd>

            <dt>Status</dt>
            <dd><?= status_badge($borrowing['status']) ?></dd>

            <dt>Catatan</dt>
            <dd><?= esc($borrowing['catatan'] ?: '-') ?></dd>
        </dl>
    </div>
</div>

<?= $this->endSection() ?>
