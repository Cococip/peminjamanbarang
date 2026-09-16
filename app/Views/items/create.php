<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Tambah Barang</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <a href="<?= base_url('items') ?>">Data Barang</a>
            <span>/</span>
            <span>Tambah</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php $errors = session()->getFlashdata('errors') ?? []; ?>
        <form action="<?= base_url('items/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="kode_barang">Kode Barang <span class="required-mark">*</span></label>
                    <input type="text" id="kode_barang" name="kode_barang" value="<?= esc(old('kode_barang')) ?>" class="<?= isset($errors['kode_barang']) ? 'is-invalid' : '' ?>" placeholder="Contoh: BRG-007">
                    <?php if (isset($errors['kode_barang'])) : ?><div class="invalid-feedback"><?= esc($errors['kode_barang']) ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nama_barang">Nama Barang <span class="required-mark">*</span></label>
                    <input type="text" id="nama_barang" name="nama_barang" value="<?= esc(old('nama_barang')) ?>" class="<?= isset($errors['nama_barang']) ? 'is-invalid' : '' ?>" placeholder="Contoh: Laptop ASUS">
                    <?php if (isset($errors['nama_barang'])) : ?><div class="invalid-feedback"><?= esc($errors['nama_barang']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="jumlah">Jumlah <span class="required-mark">*</span></label>
                    <input type="number" id="jumlah" name="jumlah" min="1" value="<?= esc(old('jumlah')) ?>" class="<?= isset($errors['jumlah']) ? 'is-invalid' : '' ?>" placeholder="Contoh: 5">
                    <?php if (isset($errors['jumlah'])) : ?><div class="invalid-feedback"><?= esc($errors['jumlah']) ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi <span class="required-mark">*</span></label>
                    <select id="kondisi" name="kondisi" class="<?= isset($errors['kondisi']) ? 'is-invalid' : '' ?>">
                        <option value="">-- Pilih Kondisi --</option>
                        <?php foreach (['Baik', 'Rusak Ringan', 'Rusak'] as $opt) : ?>
                            <option value="<?= $opt ?>" <?= old('kondisi') === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($errors['kondisi'])) : ?><div class="invalid-feedback"><?= esc($errors['kondisi']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('items') ?>" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
