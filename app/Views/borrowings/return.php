<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Pengembalian</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <span>Pengembalian</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom: 0;">
        <form action="<?= base_url('borrowings/return') ?>" method="get" class="search-bar">
            <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari kode, barang, atau peminjam...">
            <button type="submit" class="btn btn-outline">Cari</button>
            <?php if ($keyword) : ?>
                <a href="<?= base_url('borrowings/return') ?>" class="btn btn-outline">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-wrap">
        <?php if (empty($borrowings)) : ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                <p>Tidak ada data.</p>
                <span>Tidak ada peminjaman yang perlu dikembalikan saat ini.</span>
            </div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode Peminjaman</th>
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
                                <form action="<?= base_url('borrowings/return/' . $row['id']) ?>" method="post" data-confirm="Konfirmasi barang '<?= esc($row['nama_barang']) ?>' sudah dikembalikan?">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-success btn-sm">Proses Pengembalian</button>
                                </form>
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
