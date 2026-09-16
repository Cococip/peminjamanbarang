<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Riwayat Peminjaman</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <span>Riwayat</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom: 0;">
        <form action="<?= base_url('history') ?>" method="get" class="search-bar">
            <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari kode, barang, atau peminjam...">
            <select name="status">
                <option value="">Semua Status</option>
                <option value="Dipinjam" <?= $status === 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                <option value="Dikembalikan" <?= $status === 'Dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
            </select>
            <button type="submit" class="btn btn-outline">Cari</button>
            <?php if ($keyword || $status) : ?>
                <a href="<?= base_url('history') ?>" class="btn btn-outline">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-wrap">
        <?php if (empty($borrowings)) : ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <p>Tidak ada data.</p>
                <span>Belum ada riwayat peminjaman yang cocok.</span>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('default', 'app_pager') ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
