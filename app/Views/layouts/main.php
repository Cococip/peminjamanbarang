<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Dashboard') ?> - PinjamBarang</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-mark">PB</div>
            <div class="sidebar-brand-text">PinjamBarang</div>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('dashboard') ?>" class="sidebar-nav-item <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                <span class="sidebar-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </span>
                Dashboard
            </a>
            <a href="<?= base_url('items') ?>" class="sidebar-nav-item <?= ($activeMenu ?? '') === 'items' ? 'active' : '' ?>">
                <span class="sidebar-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </span>
                Data Barang
            </a>
            <a href="<?= base_url('borrowers') ?>" class="sidebar-nav-item <?= ($activeMenu ?? '') === 'borrowers' ? 'active' : '' ?>">
                <span class="sidebar-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                Data Peminjam
            </a>
            <a href="<?= base_url('borrowings') ?>" class="sidebar-nav-item <?= ($activeMenu ?? '') === 'borrowings' ? 'active' : '' ?>">
                <span class="sidebar-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                </span>
                Peminjaman
            </a>
            <a href="<?= base_url('borrowings/return') ?>" class="sidebar-nav-item <?= ($activeMenu ?? '') === 'return' ? 'active' : '' ?>">
                <span class="sidebar-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 10 4 15 9 20"></polyline><path d="M20 4v7a4 4 0 0 1-4 4H4"></path></svg>
                </span>
                Pengembalian
            </a>
            <a href="<?= base_url('history') ?>" class="sidebar-nav-item <?= ($activeMenu ?? '') === 'history' ? 'active' : '' ?>">
                <span class="sidebar-nav-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </span>
                Riwayat
            </a>
        </nav>
        <div class="sidebar-footer">
            <form action="<?= base_url('logout') ?>" method="post" data-confirm="Yakin ingin logout?">
                <?= csrf_field() ?>
                <button type="submit" class="sidebar-logout">
                    <span class="sidebar-nav-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="main-area">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="topbar-menu-btn" id="sidebarToggle" aria-label="Buka menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
                <div class="topbar-title"><?= esc($pageTitle ?? 'Dashboard') ?></div>
            </div>
            <div class="topbar-right">
                <div class="topbar-user">
                    <div class="topbar-user-avatar"><?= esc(strtoupper(substr(session('user_name') ?? 'A', 0, 1))) ?></div>
                    <div>
                        <div class="topbar-user-name"><?= esc(session('user_name') ?? 'Admin') ?></div>
                        <div class="topbar-user-role">Administrator</div>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success" data-auto-dismiss>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger" data-auto-dismiss>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="<?= base_url('assets/js/app.js') ?>"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
