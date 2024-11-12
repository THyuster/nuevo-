$(document).ready(function() {
  // Inicializar la validación del formulario
  $('#formExtenseData').validate({
    rules: {
      // identificacion: {
      //   required: true
      // },
      identificacion: {
        required: true
      },
      // Agrega reglas de validación para otros campos si es necesario
    },
    messages: {
      // tipo_identificacion: {
      //   required: 'Por favor, seleccione un tipo de identificación'
      // },
      identificacion: {
        required: 'Por favor, ingrese el número de identificación'
      },
      // Agrega mensajes de validación personalizados para otros campos si es necesario
    },
    errorElement: 'div',
    errorPlacement: function(error, element) {
      // Personaliza la ubicación de los mensajes de error si es necesario
      error.appendTo(element.closest('.form-floating'));
    },
    highlight: function(element) {
      // Aplica estilos de resaltado a los campos inválidos si es necesario
      $(element).closest('.form-floating').addClass('is-invalid');
    },
    unhighlight: function(element) {
      // Remueve los estilos de resaltado de los campos válidos si es necesario
      $(element).closest('.form-floating').removeClass('is-invalid');
    }
  });
});