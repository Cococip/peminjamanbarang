<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-card-info">
            <span class="stat-card-label">Total Barang</span>
            <span class="stat-card-value"><?= (int) $totalBarang ?></span>
        </div>
        <div class="stat-card-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-info">
            <span class="stat-card-label">Total Peminjam</span>
            <span class="stat-card-value"><?= (int) $totalPeminjam ?></span>
        </div>
        <div class="stat-card-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-info">
            <span class="stat-card-label">Barang Sedang Dipinjam</span>
            <span class="stat-card-value"><?= (int) $barangDipinjam ?></span>
        </div>
        <div class="stat-card-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-info">
            <span class="stat-card-label">Peminjaman Aktif</span>
            <span class="stat-card-value"><?= (int) $peminjamanAktif ?></span>
        </div>
        <div class="stat-card-icon gray">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Peminjaman Terbaru</h2>
        <a href="<?= base_url('history') ?>" class="btn btn-outline btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
        <?php if (empty($recentBorrowings)) : ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <p>Tidak ada data.</p>
                <span>Belum ada transaksi peminjaman.</span>
            </div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentBorrowings as $row) : ?>
                        <tr>
                            <td class="text-strong"><?= esc($row['nama_barang']) ?></td>
                            <td><?= esc($row['nama_peminjam']) ?></td>
                            <td><?= esc(date('d M Y', strtotime($row['tanggal_pinjam']))) ?></td>
                            <td><?= esc(date('d M Y', strtotime($row['tanggal_kembali']))) ?></td>
                            <td><?= status_badge($row['status']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
