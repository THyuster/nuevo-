    // Obtener la referencia al campo de entrada de fecha
    var fechaInput = document.getElementById("fecha_actualizacion");

    // Crear una nueva instancia de fecha con la fecha actual
    var fechaActual = new Date();

    // Formatear la fecha como YYYY-MM-DD (formato requerido por el campo de entrada de fecha)
    var fechaFormateada = fechaActual.toISOString().slice(0, 10);

    // Asignar la fecha formateada al campo de entrada de fecha
    fechaInput.value = fechaFormateada;