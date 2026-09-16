document.addEventListener('DOMContentLoaded', function () {
  // Sidebar toggle (mobile)
  var toggleBtn = document.getElementById('sidebarToggle');
  var sidebar = document.getElementById('sidebar');
  var overlay = document.getElementById('sidebarOverlay');

  function openSidebar() {
    sidebar.classList.add('is-open');
    overlay.classList.add('is-open');
  }

  function closeSidebar() {
    sidebar.classList.remove('is-open');
    overlay.classList.remove('is-open');
  }

  if (toggleBtn) {
    toggleBtn.addEventListener('click', function () {
      if (sidebar.classList.contains('is-open')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  }

  if (overlay) {
    overlay.addEventListener('click', closeSidebar);
  }

  // Auto-dismiss flash messages
  document.querySelectorAll('.alert[data-auto-dismiss]').forEach(function (el) {
    setTimeout(function () {
      el.style.transition = 'opacity 0.3s ease';
      el.style.opacity = '0';
      setTimeout(function () {
        el.remove();
      }, 300);
    }, 4000);
  });

  // Confirmation before delete
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var message = form.getAttribute('data-confirm') || 'Apakah Anda yakin?';
      if (!window.confirm(message)) {
        e.preventDefault();
      }
    });
  });

  // Peminjaman: tampilkan info stok tersedia sesuai barang yang dipilih
  var itemSelect = document.getElementById('barang_id');
  var availabilityBox = document.getElementById('availabilityInfo');
  var jumlahInput = document.getElementById('jumlah');

  if (itemSelect && availabilityBox) {
    function updateAvailability() {
      var selected = itemSelect.options[itemSelect.selectedIndex];
      if (!selected || !selected.value) {
        availabilityBox.innerHTML = '';
        return;
      }
      var tersedia = selected.getAttribute('data-tersedia');
      var nama = selected.getAttribute('data-nama');
      availabilityBox.innerHTML = 'Stok tersedia untuk <strong>' + nama + '</strong>: <strong>' + tersedia + '</strong> unit';
      if (jumlahInput) {
        jumlahInput.setAttribute('max', tersedia);
      }
    }

    itemSelect.addEventListener('change', updateAvailability);
    updateAvailability();
  }
});
