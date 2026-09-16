<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Detail Barang</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <a href="<?= base_url('items') ?>">Data Barang</a>
            <span>/</span>
            <span>Detail</span>
        </div>
    </div>
    <a href="<?= base_url('items/edit/' . $item['id']) ?>" class="btn btn-outline">Edit Barang</a>
</div>

<div class="card">
    <div class="card-body">
        <dl class="detail-grid">
            <dt>Kode Barang</dt>
            <dd><?= esc($item['kode_barang']) ?></dd>

            <dt>Nama Barang</dt>
            <dd><?= esc($item['nama_barang']) ?></dd>

            <dt>Jumlah Total</dt>
            <dd><?= (int) $item['jumlah'] ?> unit</dd>

            <dt>Sedang Dipinjam</dt>
            <dd><?= (int) $dipinjam ?> unit</dd>

            <dt>Tersedia</dt>
            <dd><?= (int) $tersedia ?> unit</dd>

            <dt>Kondisi</dt>
            <dd><?= status_badge($item['kondisi']) ?></dd>

            <dt>Status</dt>
            <dd><?= status_badge($item['status']) ?></dd>

            <dt>Ditambahkan</dt>
            <dd><?= esc(date('d M Y H:i', strtotime($item['created_at']))) ?></dd>
        </dl>
    </div>
</div>

<?= $this->endSection() ?>
