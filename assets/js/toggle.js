// Toggle de Particulares/Empresas para header.php
// Cambia la URL entre /particulares y /empresas

document.addEventListener('DOMContentLoaded', function() {
  const headerToggle = document.querySelector('#toggle-header');
  const headerDataWrapper = headerToggle?.closest('[data-current]');
  
  if (headerToggle && headerDataWrapper) {
    // Inicializar posición del slider del header al cargar
    initializeHeaderSliderPosition();
    
    // Event listener para botones del header toggle  
    const headerToggleButtons = headerToggle.querySelectorAll('.toggle-btn');
    headerToggleButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        // Solo procesar si el botón está inactivo (no disabled)
        if (this.disabled || this.classList.contains('active')) {
          return;
        }
        
        const targetType = this.getAttribute('data-target');
        
        // Mover slider visualmente
        updateHeaderSliderPosition(targetType);
        
        // Redirección (descomenta cuando quieras activar)
        //if (targetType === 'particulares') {
        //  window.location.href = '/particulares/';
        //} else if (targetType === 'empresas') {
        //  window.location.href = '/empresas/';
        //}
      });
    });
    
    /**
     * Inicializar posición del slider del header
     */
    function initializeHeaderSliderPosition() {
      const currentState = headerDataWrapper.getAttribute('data-current');
      updateHeaderSliderPosition(currentState);
    }
    
    /**
     * Actualizar posición del slider del header
     */
    function updateHeaderSliderPosition(activeType) {
      const headerSlider = headerToggle.querySelector('.toggle-btn--slider');
      
      if (headerSlider) {
        if (activeType === 'empresas') {
          headerSlider.classList.add('active');
        } else {
          headerSlider.classList.remove('active');
        }
      }
    }
  }
});

// Toggle de mega menú con AJAX + localStorage
document.addEventListener('DOMContentLoaded', function() {
  initializeMegaMenuToggle();
});

/**
 * Inicializar toggle del mega menú (separado para poder reinicializar)
 */
function initializeMegaMenuToggle() {
  console.log('🔍 Inicializando toggle mega menú...');
  
  const megaMenuToggle = document.querySelector('#toggle-megamenu');
  const megaMenuDataWrapper = megaMenuToggle?.closest('[data-current]');
  
  if (!megaMenuToggle) {
    console.log('❌ No se encontró #toggle-megamenu');
    return;
  }
  
  if (!megaMenuDataWrapper) {
    console.log('❌ No se encontró data wrapper');
    return;
  }
  
  if (typeof toggleMenuAjax === 'undefined') {
    console.log('❌ toggleMenuAjax no está disponible. Verificar que navigation.js se carga.');
    return;
  }
  
  console.log('✅ Toggle encontrado, variables AJAX disponibles');
  console.log('📊 Estado actual:', megaMenuDataWrapper.getAttribute('data-current'));

  // Remover event listeners previos para evitar duplicados
  megaMenuToggle.replaceWith(megaMenuToggle.cloneNode(true));
  const newToggle = document.querySelector('#toggle-megamenu');
  
  // Al cargar la página, comprobar localStorage y ajustar menú si es necesario
  initializeMegaMenuState();
  
  // Event listener para clics en los botones del toggle del mega menú
  const toggleButtons = document.querySelectorAll('#toggle-megamenu .toggle-btn');
  toggleButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Solo procesar si el botón está inactivo (no disabled)
      if (this.disabled || this.classList.contains('active')) {
        console.log('🚫 Botón activo - no se puede hacer clic');
        return;
      }
      
      const targetType = this.getAttribute('data-target');
      console.log('🔄 Toggle clickeado hacia:', targetType);
      
      toggleMegaMenuToTarget(targetType);
    });
  });

  /**
   * Inicializar estado del mega menú basado en localStorage + contexto
   */
  function initializeMegaMenuState() {
    const megaMenuDataWrapper = document.querySelector('#toggle-megamenu')?.closest('[data-current]');
    if (!megaMenuDataWrapper) return;
    
    const savedPreference = localStorage.getItem('zoilo_menu_preference');
    const currentMenuType = megaMenuDataWrapper.getAttribute('data-current');
    const currentPostType = megaMenuDataWrapper.getAttribute('data-current-post-type');
    
    // Determinar qué menú mostrar
    let targetMenuType = currentMenuType; // por defecto el actual
    
    // Si hay preferencia guardada y no estamos en contexto empresa, usar preferencia
    if (savedPreference && currentPostType !== 'empresa') {
      targetMenuType = savedPreference;
    }
    
    // Si el menú target es diferente al actual, cambiarlo
    if (targetMenuType !== currentMenuType) {
      loadMenu(targetMenuType, false); // false = no actualizar localStorage
    } else {
      // Aunque no cambies el menú, asegurar que los botones y slider tengan el estado correcto
      updateToggleButtonsState(targetMenuType);
    }
  }

  /**
   * Cambiar a un tipo de menú específico
   */
  function toggleMegaMenuToTarget(targetType) {
    const megaMenuDataWrapper = document.querySelector('#toggle-megamenu')?.closest('[data-current]');
    if (!megaMenuDataWrapper) return;
    
    const currentMenuType = megaMenuDataWrapper.getAttribute('data-current');
    
    // Si ya está en el tipo target, no hacer nada
    if (currentMenuType === targetType) {
      console.log('🔄 Ya está en:', targetType);
      return;
    }
    
    // Deshabilitar ambos botones durante la carga
    const toggleButtons = document.querySelectorAll('#toggle-megamenu .toggle-btn');
    toggleButtons.forEach(btn => {
      btn.disabled = true;
      btn.style.opacity = '0.6';
    });
    
    // Cargar nuevo menú y guardar preferencia
    loadMenu(targetType, true);
  }

  /**
   * Cargar menú via AJAX
   */
  function loadMenu(menuType, updatePreference = true) {
    console.log('🚀 Cargando menú:', menuType);
    
    // Mostrar estado de carga
    const menuContainer = document.querySelector('.menu-main-menu-container');
    if (!menuContainer) {
      console.log('❌ No se encontró contenedor de menú');
      return;
    }
    
    console.log('📦 Contenedor encontrado:', menuContainer.className);
    
    menuContainer.style.opacity = '0.5';
    menuContainer.style.pointerEvents = 'none';

    // Parámetros AJAX
    const formData = new FormData();
    formData.append('action', 'toggle_menu');
    formData.append('menu_type', menuType);
    formData.append('nonce', toggleMenuAjax.nonce);

    console.log('📨 Enviando AJAX request:', {
      action: 'toggle_menu',
      menu_type: menuType,
      ajax_url: toggleMenuAjax.ajax_url
    });

    // Llamada AJAX
    fetch(toggleMenuAjax.ajax_url, {
      method: 'POST',
      body: formData
    })
    .then(response => {
      console.log('📡 Respuesta AJAX status:', response.status);
      return response.json();
    })
    .then(data => {
      console.log('📄 Datos AJAX recibidos:', data);
      
      if (data.success) {
        // Reemplazar contenido del menú
        const megaMenu = document.querySelector('#mega-menu');
        if (megaMenu) {
          // Encontrar el contenedor del menú actual
          const currentContainer = megaMenu.querySelector('.menu-main-menu-container');
          
          if (currentContainer) {
            console.log('🔄 Reemplazando contenido del menú...');
            
            // Reemplazar HTML del menú
            currentContainer.outerHTML = data.data.menu_html;
            
            // Actualizar estado del toggle
            const updatedDataWrapper = document.querySelector('#toggle-megamenu')?.closest('[data-current]');
            if (updatedDataWrapper) {
              updatedDataWrapper.setAttribute('data-current', menuType);
              console.log('✅ Estado actualizado a:', menuType);
            }
            
            // Actualizar estado de los botones
            updateToggleButtonsState(menuType);
            
            // Reinicializar funcionalidades del menú
            initializeMenuFeatures();
            
            // Reinicializar el toggle (importante para mantener funcionalidad)
            setTimeout(() => {
              console.log('🔄 Reinicializando toggle...');
              initializeMegaMenuToggle();
            }, 100);
          } else {
            console.log('❌ No se encontró contenedor actual para reemplazar');
          }
        }
        
        // Guardar preferencia en localStorage si se solicita
        if (updatePreference) {
          localStorage.setItem('zoilo_menu_preference', menuType);
          console.log('💾 Preferencia guardada:', menuType);
        }
        
        console.log('✅ Menú cambiado a:', menuType);
      } else {
        console.error('❌ Error en respuesta AJAX:', data.data);
        // Restaurar estado de botones si hay error
        restoreToggleButtonsState();
      }
    })
    .catch(error => {
      console.error('❌ Error AJAX:', error);
      // Restaurar estado de botones si hay error
      restoreToggleButtonsState();
    })
    .finally(() => {
      // Restaurar estado visual
      const menuContainer = document.querySelector('.menu-main-menu-container');
      if (menuContainer) {
        menuContainer.style.opacity = '';
        menuContainer.style.pointerEvents = '';
      }
    });
  }

  /**
   * Reinicializar funcionalidades del menú después de AJAX
   * (dropdowns, animaciones, etc.)
   */
  function initializeMenuFeatures() {
    // Aquí puedes reinicializar funcionalidades específicas del menú
    // Por ejemplo, dropdowns, animaciones, etc.
    
    // Ejemplo: reinicializar dropdowns si los tienes
    const menuItems = document.querySelectorAll('.menu-item-has-children');
    menuItems.forEach(item => {
      // Reinicializar funcionalidad específica
    });
  }

  /**
   * Actualizar estado de los botones del toggle después de cambio exitoso
   */
  function updateToggleButtonsState(activeMenuType) {
    const toggleButtons = document.querySelectorAll('#toggle-megamenu .toggle-btn');
    const toggleSlider = document.querySelector('#toggle-megamenu .toggle-btn--slider');
    
    toggleButtons.forEach(button => {
      const buttonTarget = button.getAttribute('data-target');
      
      if (buttonTarget === activeMenuType) {
        // Botón activo: disabled y con clase active
        button.disabled = true;
        button.classList.remove('inactive');
        button.classList.add('active');
        button.style.opacity = '';
      } else {
        // Botón inactivo: enabled y con clase inactive
        button.disabled = false;
        button.classList.remove('active');
        button.classList.add('inactive');
        button.style.opacity = '';
      }
    });
    
    // Mover slider con clase CSS
    if (toggleSlider) {
      if (activeMenuType === 'empresas') {
        toggleSlider.classList.add('active');
      } else {
        toggleSlider.classList.remove('active');
      }
    }
    
    console.log('🎯 Estado de botones actualizado para:', activeMenuType);
  }

  /**
   * Restaurar estado original de los botones en caso de error
   */
  function restoreToggleButtonsState() {
    const megaMenuDataWrapper = document.querySelector('#toggle-megamenu')?.closest('[data-current]');
    const currentMenuType = megaMenuDataWrapper?.getAttribute('data-current') || 'particulares';
    
    updateToggleButtonsState(currentMenuType);
    
    console.log('🔄 Estado de botones restaurado a:', currentMenuType);
  }
}

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