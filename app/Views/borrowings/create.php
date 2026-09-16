<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Tambah Peminjaman</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <a href="<?= base_url('borrowings') ?>">Peminjaman</a>
            <span>/</span>
            <span>Tambah</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php $errors = session()->getFlashdata('errors') ?? []; ?>
        <form action="<?= base_url('borrowings/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="barang_id">Barang <span class="required-mark">*</span></label>
                    <select id="barang_id" name="barang_id" class="<?= isset($errors['barang_id']) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach ($items as $item) : ?>
                            <option
                                value="<?= $item['id'] ?>"
                                data-tersedia="<?= (int) $item['tersedia'] ?>"
                                data-nama="<?= esc($item['nama_barang']) ?>"
                                <?= old('barang_id') == $item['id'] ? 'selected' : '' ?>
                                <?= $item['tersedia'] <= 0 ? 'disabled' : '' ?>
                            >
                                <?= esc($item['nama_barang']) ?> (<?= esc($item['kode_barang']) ?>) &mdash; Tersedia: <?= (int) $item['tersedia'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['barang_id'])) : ?><div class="invalid-feedback"><?= esc($errors['barang_id']) ?></div><?php endif; ?>
                    <div class="info-box" id="availabilityInfo"></div>
                </div>
                <div class="form-group">
                    <label for="peminjam_id">Peminjam <span class="required-mark">*</span></label>
                    <select id="peminjam_id" name="peminjam_id" class="<?= isset($errors['peminjam_id']) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Peminjam --</option>
                        <?php foreach ($borrowers as $borrower) : ?>
                            <option value="<?= $borrower['id'] ?>" <?= old('peminjam_id') == $borrower['id'] ? 'selected' : '' ?>>
                                <?= esc($borrower['nama']) ?> (<?= esc($borrower['identitas']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['peminjam_id'])) : ?><div class="invalid-feedback"><?= esc($errors['peminjam_id']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="jumlah">Jumlah <span class="required-mark">*</span></label>
                    <input type="number" id="jumlah" name="jumlah" min="1" value="<?= esc(old('jumlah')) ?>" class="<?= isset($errors['jumlah']) ? 'is-invalid' : '' ?>" placeholder="Jumlah unit yang dipinjam">
                    <?php if (isset($errors['jumlah'])) : ?><div class="invalid-feedback"><?= esc($errors['jumlah']) ?></div><?php endif; ?>
                </div>
                <div></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Pinjam <span class="required-mark">*</span></label>
                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="<?= esc(old('tanggal_pinjam') ?? date('Y-m-d')) ?>" class="<?= isset($errors['tanggal_pinjam']) ? 'is-invalid' : '' ?>">
                    <?php if (isset($errors['tanggal_pinjam'])) : ?><div class="invalid-feedback"><?= esc($errors['tanggal_pinjam']) ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="tanggal_kembali">Rencana Tanggal Kembali <span class="required-mark">*</span></label>
                    <input type="date" id="tanggal_kembali" name="tanggal_kembali" value="<?= esc(old('tanggal_kembali')) ?>" class="<?= isset($errors['tanggal_kembali']) ? 'is-invalid' : '' ?>">
                    <?php if (isset($errors['tanggal_kembali'])) : ?><div class="invalid-feedback"><?= esc($errors['tanggal_kembali']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan (opsional)</label>
                <textarea id="catatan" name="catatan" placeholder="Keperluan atau catatan tambahan..."><?= esc(old('catatan')) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                <a href="<?= base_url('borrowings') ?>" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
