<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Tambah Peminjam</h1>
        <div class="breadcrumb">
            <a href="<?= base_url('dashboard') ?>">Dashboard</a>
            <span>/</span>
            <a href="<?= base_url('borrowers') ?>">Data Peminjam</a>
            <span>/</span>
            <span>Tambah</span>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php $errors = session()->getFlashdata('errors') ?? []; ?>
        <form action="<?= base_url('borrowers/store') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="nama">Nama <span class="required-mark">*</span></label>
                    <input type="text" id="nama" name="nama" value="<?= esc(old('nama')) ?>" class="<?= isset($errors['nama']) ? 'is-invalid' : '' ?>" placeholder="Nama lengkap">
                    <?php if (isset($errors['nama'])) : ?><div class="invalid-feedback"><?= esc($errors['nama']) ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="identitas">Identitas (NIM/NIP/ID) <span class="required-mark">*</span></label>
                    <input type="text" id="identitas" name="identitas" value="<?= esc(old('identitas')) ?>" class="<?= isset($errors['identitas']) ? 'is-invalid' : '' ?>" placeholder="Contoh: 2021010105">
                    <?php if (isset($errors['identitas'])) : ?><div class="invalid-feedback"><?= esc($errors['identitas']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" value="<?= esc(old('kelas')) ?>" class="<?= isset($errors['kelas']) ? 'is-invalid' : '' ?>" placeholder="Contoh: TI-3A">
                    <?php if (isset($errors['kelas'])) : ?><div class="invalid-feedback"><?= esc($errors['kelas']) ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" value="<?= esc(old('no_hp')) ?>" class="<?= isset($errors['no_hp']) ? 'is-invalid' : '' ?>" placeholder="Contoh: 081234567890">
                    <?php if (isset($errors['no_hp'])) : ?><div class="invalid-feedback"><?= esc($errors['no_hp']) ?></div><?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('borrowers') ?>" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
