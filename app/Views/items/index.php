<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Data Barang</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <span>Data Barang</span>
        </div>
    </div>
    <a href="<?= base_url('items/create') ?>" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Tambah Barang
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom: 0;">
        <form action="<?= base_url('items') ?>" method="get" class="search-bar">
            <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari kode atau nama barang...">
            <button type="submit" class="btn btn-outline">Cari</button>
            <?php if ($keyword) : ?>
                <a href="<?= base_url('items') ?>" class="btn btn-outline">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-wrap">
        <?php if (empty($items)) : ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                <p>Tidak ada data.</p>
                <span>Belum ada barang yang cocok dengan pencarian Anda.</span>
            </div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tersedia</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) : ?>
                        <tr>
                            <td class="text-muted"><?= esc($item['kode_barang']) ?></td>
                            <td class="text-strong"><?= esc($item['nama_barang']) ?></td>
                            <td><?= (int) $item['jumlah'] ?></td>
                            <td><?= (int) $item['tersedia'] ?></td>
                            <td><?= status_badge($item['kondisi']) ?></td>
                            <td><?= status_badge($item['status']) ?></td>
                            <td>
                                <div class="td-actions">
                                    <a href="<?= base_url('items/show/' . $item['id']) ?>" class="btn btn-outline btn-sm">Detail</a>
                                    <a href="<?= base_url('items/edit/' . $item['id']) ?>" class="btn btn-outline btn-sm">Edit</a>
                                    <form action="<?= base_url('items/delete/' . $item['id']) ?>" method="post" data-confirm="Yakin ingin menghapus barang ini?">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('default', 'app_pager') ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
