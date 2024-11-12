// Obtener las pestañas y los contenidos correspondientes
var tabs = document.querySelectorAll('.nav-tabs .nav-link');
var tabContents = document.querySelectorAll('.tab-content .tab-pane');

// Agregar un evento de clic a cada pestaña
tabs.forEach(function(tab) {
  tab.addEventListener('click', function(e) {
    e.preventDefault();

    // Remover la clase 'active' de todas las pestañas y contenidos
    tabs.forEach(function(tab) {
      tab.classList.remove('active');
    });
    tabContents.forEach(function(content) {
      content.classList.remove('show', 'active');
    });

    // Agregar la clase 'active' a la pestaña clickeada y mostrar su contenido correspondiente
    this.classList.add('active');
    var target = this.getAttribute('href');
    document.querySelector(target).classList.add('show', 'active');
  });
});