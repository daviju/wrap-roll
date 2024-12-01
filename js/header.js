document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('nav .item');
  
    // Menú de navegación
    menuItems.forEach(item => {
      item.addEventListener('click', () => {
        const dropdown = item.querySelector('.dropdown');
        
        // Alternar la visibilidad del submenú
        if (dropdown.style.display === 'block') {
          dropdown.style.display = 'none';
          dropdown.style.opacity = '0';
        } else {
          dropdown.style.display = 'block';
          dropdown.style.opacity = '1';
          dropdown.style.transform = 'translateY(0)';
        }
  
        // Alternar la clase 'active' para animación
        item.classList.toggle('active');
      });
    });
  
    // Cerrar el dropdown si se hace clic fuera de él
    document.addEventListener('click', (e) => {
      if (!e.target.closest('nav')) {
        const openDropdowns = document.querySelectorAll('.item.active .dropdown');
        openDropdowns.forEach(dropdown => {
          dropdown.style.display = 'none';
          dropdown.style.opacity = '0';
        });
  
        // Eliminar la clase 'active' de todos los items
        const activeItems = document.querySelectorAll('.item.active');
        activeItems.forEach(item => {
          item.classList.remove('active');
        });
      }
    });
  });
  