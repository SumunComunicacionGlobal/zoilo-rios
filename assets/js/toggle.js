// Toggle de vistas para estaciones
document.addEventListener('DOMContentLoaded', function() {
  const toggleViews = document.getElementById('toggle-views-estaciones');
  if (!toggleViews) return;

  const buttons = toggleViews.querySelectorAll('.toggle-btn');
  
  // Establecer estado inicial
  toggleViews.setAttribute('data-active', 'list');

  buttons.forEach(function(button) {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      const view = this.getAttribute('data-view');
      toggleViews.setAttribute('data-active', view);
      
      console.log('Vista seleccionada:', view);
      // Aquí se puede agregar lógica para cambiar la vista
    });
  });
});