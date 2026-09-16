<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Data Peminjam</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <span>Data Peminjam</span>
        </div>
    </div>
    <a href="<?= base_url('borrowers/create') ?>" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Tambah Peminjam
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding-bottom: 0;">
        <form action="<?= base_url('borrowers') ?>" method="get" class="search-bar">
            <input type="text" name="keyword" value="<?= esc($keyword) ?>" placeholder="Cari nama, identitas, atau kelas...">
            <button type="submit" class="btn btn-outline">Cari</button>
            <?php if ($keyword) : ?>
                <a href="<?= base_url('borrowers') ?>" class="btn btn-outline">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="table-wrap">
        <?php if (empty($borrowers)) : ?>
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                <p>Tidak ada data.</p>
                <span>Belum ada peminjam yang cocok dengan pencarian Anda.</span>
            </div>
        <?php else : ?>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Identitas</th>
                        <th>Kelas</th>
                        <th>No. HP</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowers as $borrower) : ?>
                        <tr>
                            <td class="text-strong"><?= esc($borrower['nama']) ?></td>
                            <td class="text-muted"><?= esc($borrower['identitas']) ?></td>
                            <td><?= esc($borrower['kelas'] ?: '-') ?></td>
                            <td><?= esc($borrower['no_hp'] ?: '-') ?></td>
                            <td>
                                <div class="td-actions">
                                    <a href="<?= base_url('borrowers/show/' . $borrower['id']) ?>" class="btn btn-outline btn-sm">Detail</a>
                                    <a href="<?= base_url('borrowers/edit/' . $borrower['id']) ?>" class="btn btn-outline btn-sm">Edit</a>
                                    <form action="<?= base_url('borrowers/delete/' . $borrower['id']) ?>" method="post" data-confirm="Yakin ingin menghapus peminjam ini?">
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
