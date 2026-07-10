document.addEventListener('DOMContentLoaded', function () {
  var toggle = document.getElementById('admin-menu-toggle');
  var sidebar = document.getElementById('admin-sidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
  }
});
