<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Peminjaman</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <span>Peminjaman</span>
        </div>
    </div>
    <a href="<?= base_url('borrowings/create') ?>" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Tambah Peminjaman
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom: 0;">
        <form action="<?= base_url('borrowings') ?>" method="get" class="search-bar">
            <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari kode, barang, atau peminjam...">
            <button type="submit" class="btn btn-outline">Cari</button>
            <?php if ($keyword) : ?>
                <a href="<?= base_url('borrowings') ?>" class="btn btn-outline">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-wrap">
        <?php if (empty($borrowings)) : ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path></svg>
                <p>Tidak ada data.</p>
                <span>Belum ada peminjaman aktif saat ini.</span>
            </div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowings as $row) : ?>
                        <tr>
                            <td class="text-muted"><?= esc($row['kode_peminjaman']) ?></td>
                            <td class="text-strong"><?= esc($row['nama_barang']) ?></td>
                            <td><?= esc($row['nama_peminjam']) ?></td>
                            <td><?= (int) $row['jumlah'] ?></td>
                            <td><?= esc(date('d M Y', strtotime($row['tanggal_pinjam']))) ?></td>
                            <td><?= esc(date('d M Y', strtotime($row['tanggal_kembali']))) ?></td>
                            <td><?= status_badge($row['status']) ?></td>
                            <td>
                                <div class="td-actions">
                                    <a href="<?= base_url('borrowings/show/' . $row['id']) ?>" class="btn btn-outline btn-sm">Detail</a>
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
