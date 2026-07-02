// Añade clase a body cuando se hace scroll
window.addEventListener("scroll", function() {
    if (window.scrollY > 180) {
        document.body.classList.add("scrolled");
    } else {
        document.body.classList.remove("scrolled");
    }
});
// Añade botones de scroll a la izquierda y derecha
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".is-style-group-horizontal-scroll-btns").forEach((content) => {
        if (content.children.length > 1) {
            const rightBtn = document.createElement("button");
            rightBtn.classList.add("scrolling-button", "scrolling-button--right");
            rightBtn.innerHTML = "→";
            rightBtn.disabled = false;

            const leftBtn = document.createElement("button");
            leftBtn.classList.add("scrolling-button", "scrolling-button--left");
            leftBtn.innerHTML = "←";
            leftBtn.disabled = true;

            const buttonContainer = document.createElement("div");
            buttonContainer.classList.add("scrolling-button-container");
            buttonContainer.appendChild(leftBtn);
            buttonContainer.appendChild(rightBtn);
            //content.parentNode.insertBefore(buttonContainer, content.nextSibling);
            // Agregar el contenedor de botones antes del contenido
            content.parentNode.insertBefore(buttonContainer, content);

            // Desplazamiento fijo para móvil y desktop
            function getScrollStep() {
                return window.innerWidth < 768 ? 400 : 288;
            }

            rightBtn.addEventListener("click", () => {
                const scrollContent = content;
                const scrollStep = getScrollStep();
                scrollContent.scrollLeft += scrollStep;
                leftBtn.disabled = false;

                if (scrollContent.scrollWidth - scrollContent.scrollLeft - scrollContent.clientWidth <= 0) {
                    rightBtn.disabled = true;
                }
            });

            leftBtn.addEventListener("click", () => {
                const scrollContent = content;
                const scrollStep = getScrollStep();
                scrollContent.scrollLeft -= scrollStep;
                rightBtn.disabled = false;

                if (scrollContent.scrollLeft <= 0) {
                    leftBtn.disabled = true;
                }
            });
        }
    });
});

// Añade drag para los elementos con scroll horizontal
document.addEventListener('DOMContentLoaded', (event) => {
    const sliders = document.querySelectorAll('.is-style-group-horizontal-scroll');
    let isDown = false;
    let startX;
    let scrollLeft;
  
    // Añade el evento a cada slider
    sliders.forEach(slider => {
        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
        });
        slider.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 3; //scroll-fast
            slider.scrollLeft = scrollLeft - walk;
            console.log(walk);
        });
    });
  
  });

//Rank Math FAQ Dropdown
document.addEventListener('DOMContentLoaded', (event) => {
    const faqs = document.querySelectorAll('.rank-math-list-item');
    faqs.forEach(faq => {
        const question = faq.querySelector('.rank-math-question');
        question.addEventListener('click', () => {
            faq.classList.toggle('active');
        });
    });
});

// Iconos para facet estaciones - funciona con carga dinámica de FacetWP
function addFacetIcons() {
    document.querySelectorAll('.facetwp-checkbox[data-value]').forEach(el => {
        // Solo añadir icono si no existe ya
        if (!el.querySelector('.facetwp-custom-icon')) {
            const icon = document.createElement('span');
            icon.className = 'facetwp-custom-icon';
            // Usar la URL del tema localizada desde PHP
            const themeUrl = window.themeData ? window.themeData.themeUrl : '';
            icon.style.backgroundImage = `url('${themeUrl}/assets/icons/${el.dataset.value}.svg')`;
            el.prepend(icon);
        }
    });
}

// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', addFacetIcons);

// Ejecutar después de cada refresh de FacetWP
document.addEventListener('facetwp-loaded', addFacetIcons);

// Fallback: observar cambios en el DOM para elementos añadidos dinámicamente
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.addedNodes.length) {
            addFacetIcons();
        }
    });
});

// Observar cambios en el contenedor de filtros
if (document.querySelector('.filter-box')) {
    observer.observe(document.querySelector('.filter-box'), {
        childList: true,
        subtree: true
    });
}

// Toggle para menús de filtros
document.addEventListener('DOMContentLoaded', function() {
    const menuTitles = document.querySelectorAll('.menu-sibling--title');
    const backBtn = document.getElementById('back-btn');
    const filterBy = document.getElementById('filter-by');
    const toggleFilterBtn = document.getElementById('toggle-filter-box');
    const filterBox = document.getElementById('filter-box');
    const closeBtn = document.getElementById('close-btn');
    
    // Toggle para mostrar/ocultar filter-box
    if (toggleFilterBtn && filterBox) {
        const overlay = document.querySelector('.menu-overlay');
        
        function openFilterBox() {
            filterBox.classList.add('filter-box--open');
            if (overlay) {
                overlay.style.opacity = '1';
                overlay.style.visibility = 'visible';
            }
            document.body.style.overflow = 'hidden';
        }
        
        function closeFilterBox() {
            filterBox.classList.remove('filter-box--open');
            if (overlay) {
                overlay.style.opacity = '0';
                overlay.style.visibility = 'hidden';
            }
            document.body.style.overflow = '';
        }
        
        toggleFilterBtn.addEventListener('click', function() {
            const isOpen = filterBox.classList.contains('filter-box--open');
            
            if (isOpen) {
                closeFilterBox();
            } else {
                openFilterBox();
            }
        });
        
        // Cerrar filter-box con botón close
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeFilterBox();
            });
        }
        
        // Cerrar filter-box al hacer click en overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                if (filterBox.classList.contains('filter-box--open')) {
                    closeFilterBox();
                }
            });
        }
    }
    
    // Función para actualizar visibilidad del botón back y filter-by
    function updateVisibility() {
        const hasOpenMenu = document.querySelector('.menu--siblings.menu-open');
        if (hasOpenMenu) {
            backBtn.classList.add('show');
            filterBy.classList.add('hide');
        } else {
            backBtn.classList.remove('show');
            filterBy.classList.remove('hide');
        }
    }
    
    // Click en títulos de menú para abrir submenús
    menuTitles.forEach(title => {
        title.addEventListener('click', function() {
            // Encontrar el contenedor .menu--siblings hermano
            const siblingsContainer = this.nextElementSibling;
            
            if (siblingsContainer && siblingsContainer.classList.contains('menu--siblings')) {
                // Cerrar otros menús abiertos
                document.querySelectorAll('.menu--siblings.menu-open').forEach(openMenu => {
                    if (openMenu !== siblingsContainer) {
                        openMenu.classList.remove('menu-open');
                        // Actualizar aria-expanded del botón correspondiente
                        const prevTitle = openMenu.previousElementSibling;
                        const prevButton = prevTitle?.querySelector('.btn-icon');
                        if (prevButton) {
                            prevButton.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
                
                // Toggle de la clase menu-open
                siblingsContainer.classList.toggle('menu-open');
                
                // Actualizar atributos ARIA si existen
                const button = this.querySelector('.btn-icon');
                if (button) {
                    const isExpanded = siblingsContainer.classList.contains('menu-open');
                    button.setAttribute('aria-expanded', isExpanded);
                }
                
                // Actualizar visibilidad
                updateVisibility();
            }
        });
    });
    
    // Click en botón back para cerrar menús
    if (backBtn) {
        backBtn.addEventListener('click', function() {
            // Cerrar todos los menús abiertos
            document.querySelectorAll('.menu--siblings.menu-open').forEach(openMenu => {
                openMenu.classList.remove('menu-open');
                // Actualizar aria-expanded del botón correspondiente
                const prevTitle = openMenu.previousElementSibling;
                const prevButton = prevTitle?.querySelector('.btn-icon');
                if (prevButton) {
                    prevButton.setAttribute('aria-expanded', 'false');
                }
            });
            
            // Actualizar visibilidad
            updateVisibility();
        });
    }
    
    // Toggle para filter-by
    const toggleFilterBy = document.querySelector('.toggle-filter-by');
    const filterByElement = document.getElementById('filter-by');
    
    if (toggleFilterBy && filterByElement) {
        toggleFilterBy.addEventListener('click', function() {
            filterByElement.classList.toggle('filter-by--is-open');
        });
    }
});

// Privacy popup modal: open on hover/focus, close with button, overlay click or Escape
document.addEventListener('DOMContentLoaded', function() {
    const triggers = document.querySelectorAll('.show-privacy-popup');

    if (!triggers.length) {
        return;
    }

    const processedWrappers = new WeakSet();
    const processedCloseButtons = new WeakSet();
    let activeWrapper = null;

    function closePopup(wrapper = activeWrapper) {
        if (!wrapper) {
            return;
        }

        wrapper.classList.remove('is-open');

        if (activeWrapper === wrapper) {
            activeWrapper = null;
        }

        if (!document.querySelector('.privacy-popup-wrapper.is-open')) {
            document.body.classList.remove('privacy-popup-open');
        }
    }

    function getPopupContext(trigger) {
        const parentForm = trigger.closest('form');

        if (!parentForm) {
            return null;
        }

        const privacyPopup = parentForm.querySelector('.privacy-popup');

        if (!privacyPopup) {
            return null;
        }

        let popupWrapper = privacyPopup.closest('.privacy-popup-wrapper');

        if (!popupWrapper && privacyPopup.parentNode) {
            popupWrapper = document.createElement('div');
            popupWrapper.className = 'privacy-popup-wrapper';
            privacyPopup.parentNode.insertBefore(popupWrapper, privacyPopup);
            popupWrapper.appendChild(privacyPopup);
        }

        if (!popupWrapper) {
            return null;
        }

        if (!processedWrappers.has(popupWrapper)) {
            popupWrapper.addEventListener('click', function(event) {
                if (event.target === popupWrapper) {
                    closePopup(popupWrapper);
                }
            });

            processedWrappers.add(popupWrapper);
        }

        let closeButton = privacyPopup.querySelector('.privacy-popup__close');

        if (!closeButton) {
            closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'privacy-popup__close';
            closeButton.setAttribute('aria-label', 'Cerrar ventana de privacidad');
            closeButton.textContent = '×';
            privacyPopup.prepend(closeButton);
        }

        if (!processedCloseButtons.has(closeButton)) {
            closeButton.addEventListener('click', function() {
                closePopup(popupWrapper);
            });

            processedCloseButtons.add(closeButton);
        }

        return {
            popupWrapper,
        };
    }

    function openPopupForTrigger(trigger) {
        const popupContext = getPopupContext(trigger);

        if (!popupContext) {
            return;
        }

        if (activeWrapper && activeWrapper !== popupContext.popupWrapper) {
            closePopup(activeWrapper);
        }

        popupContext.popupWrapper.classList.add('is-open');
        activeWrapper = popupContext.popupWrapper;
        document.body.classList.add('privacy-popup-open');
    }

    triggers.forEach((trigger) => {
        trigger.addEventListener('mouseenter', function() {
            openPopupForTrigger(trigger);
        });

        trigger.addEventListener('focus', function() {
            openPopupForTrigger(trigger);
        });

        // Inicializa wrapper y botón para cada formulario con trigger
        getPopupContext(trigger);
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePopup();
        }
    });
});

