(function () {
  'use strict';

  function normalize(value) {
    return value.toLowerCase()
      .replace(/á/g, 'a').replace(/é/g, 'e').replace(/í/g, 'i')
      .replace(/ó/g, 'o').replace(/ú/g, 'u').replace(/ñ/g, 'n');
  }

  // Avisos flotantes
  var toast = document.getElementById('toast');
  if (toast) {
    var closeToast = function () { toast.style.display = 'none'; };
    var toastButton = toast.querySelector('[data-close-toast]');
    if (toastButton) toastButton.addEventListener('click', closeToast);
    window.setTimeout(closeToast, 5000);
  }

  // Menú móvil
  var menuToggle = document.getElementById('menuToggle');
  var mobileNav = document.getElementById('mobileNav');
  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', function () {
      var open = mobileNav.hasAttribute('hidden');
      if (open) mobileNav.removeAttribute('hidden');
      else mobileNav.setAttribute('hidden', '');
      menuToggle.setAttribute('aria-expanded', String(open));
    });
  }

  // Autocompletado de búsqueda con Fetch API + JSON (TP9)
  var input = document.getElementById('searchInput');
  var suggestions = document.getElementById('searchSuggestions');
  if (input && suggestions) {
    var timer = null;
    var controller = null;

    var clearSuggestions = function () {
      suggestions.innerHTML = '';
      suggestions.hidden = true;
    };

    var renderResults = function (productos) {
      suggestions.innerHTML = '';
      if (!productos.length) {
        var empty = document.createElement('p');
        empty.textContent = 'No encontramos productos para "' + input.value + '".';
        suggestions.appendChild(empty);
      } else {
        productos.forEach(function (p) {
          var link = document.createElement('a');
          link.href = 'producto.php?slug=' + encodeURIComponent(p.slug);

          var img = document.createElement('img');
          img.src = p.image;
          img.alt = '';

          var info = document.createElement('span');
          var name = document.createElement('span');
          name.className = 'suggest-name';
          name.textContent = p.name;
          var meta = document.createElement('small');
          meta.className = 'suggest-meta';
          meta.textContent = p.brand + ' · ' + p.unit;
          info.appendChild(name);
          info.appendChild(meta);

          var price = document.createElement('span');
          price.className = 'suggest-price';
          price.textContent = p.price;

          link.appendChild(img);
          link.appendChild(info);
          link.appendChild(price);
          suggestions.appendChild(link);
        });
      }
      suggestions.hidden = false;
    };

    var showError = function (message) {
      suggestions.innerHTML = '';
      var error = document.createElement('p');
      error.textContent = message;
      suggestions.appendChild(error);
      suggestions.hidden = false;
    };

    var buscar = async function (query) {
      if (controller && typeof controller.abort === 'function') {
        controller.abort();
      }
      if (typeof AbortController !== 'undefined') {
        controller = new AbortController();
      }
      var options = { headers: { 'Accept': 'application/json' } };
      if (controller && options.signal === undefined) {
        options.signal = controller.signal;
      }

      try {
        var response = await fetch(
          'api/buscar_productos.php?q=' + encodeURIComponent(query),
          options
        );
        if (!response.ok) {
          throw new Error('Error HTTP: ' + response.status);
        }
        var res = await response.json();
        if (res.status !== 'success' || !Array.isArray(res.data)) {
          throw new Error('Respuesta JSON inválida');
        }
        renderResults(res.data);
      } catch (error) {
        if (error && error.name === 'AbortError') {
          return;
        }
        console.error('Error al realizar la petición:', error);
        showError('No pudimos buscar productos en este momento.');
      }
    };

    var onInput = function () {
      var query = input.value.trim();
      if (normalize(query).length < 2) {
        if (timer) window.clearTimeout(timer);
        clearSuggestions();
        return;
      }
      if (timer) window.clearTimeout(timer);
      timer = window.setTimeout(function () {
        buscar(query);
      }, 180);
    };

    input.addEventListener('input', onInput);
    input.addEventListener('focus', onInput);
    document.addEventListener('click', function (e) {
      if (!suggestions.contains(e.target) && e.target !== input) clearSuggestions();
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') clearSuggestions();
    });
  }

  // Etiqueta del filtro de precio
  var priceRange = document.getElementById('priceRange');
  var priceLabel = document.getElementById('priceLabel');
  if (priceRange && priceLabel) {
    priceRange.addEventListener('input', function () {
      priceLabel.textContent = '$ ' + Number(priceRange.value).toLocaleString('es-AR');
    });
  }

  // Mostrar/ocultar filtros en móvil
  var filterToggle = document.getElementById('filterToggle');
  var filtersPanel = document.getElementById('filtersPanel');
  if (filterToggle && filtersPanel) {
    filterToggle.addEventListener('click', function () {
      filtersPanel.hidden = !filtersPanel.hidden;
    });
    if (window.innerWidth >= 1024) filtersPanel.hidden = false;
  }

  // Pestañas de la ficha de producto
  document.querySelectorAll('[data-tabs]').forEach(function (group) {
    var buttons = group.querySelectorAll('[data-tab]');
    var panels = group.querySelectorAll('[data-panel]');
    buttons.forEach(function (button) {
      button.addEventListener('click', function () {
        buttons.forEach(function (b) { b.classList.toggle('active', b === button); });
        panels.forEach(function (panel) {
          panel.hidden = panel.getAttribute('data-panel') !== button.getAttribute('data-tab');
        });
      });
    });
  });

  // Botones +/- de cantidades
  document.querySelectorAll('[data-step]').forEach(function (button) {
    button.addEventListener('click', function () {
      var field = button.parentNode.querySelector('input[type="number"]');
      if (!field) return;
      var step = Number(button.getAttribute('data-step'));
      var min = Number(field.getAttribute('min') || 0);
      var max = Number(field.getAttribute('max') || 99);
      var value = Math.min(max, Math.max(min, Number(field.value || 0) + step));
      field.value = value;
      if (field.form) field.form.submit();
    });
  });

  // Medios de pago del checkout
  document.querySelectorAll('.payment-option input').forEach(function (radio) {
    radio.addEventListener('change', function () {
      document.querySelectorAll('.payment-option').forEach(function (option) {
        option.classList.toggle('selected', option.contains(radio));
      });
      document.querySelectorAll('[data-method]').forEach(function (block) {
        if (block.classList.contains('payment-extra') || block.classList.contains('payment-note')) {
          block.hidden = block.getAttribute('data-method') !== radio.value;
        }
      });
    });
  });
})();
