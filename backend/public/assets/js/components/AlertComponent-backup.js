// showNotification("success", "¡Hola mundo!", notificacion); Ejemplo

/*<script src="{{ asset('assets/js/components/AlertComponent.js')}}"></script> 
AGREGAR AL BLADE PARA INCLUIR La función JavaScript ejecuta el tipo de alerta que se debe entregar, 
solo se debe entregar una alerta, si desea entregar otro mensaje de alerta, solo debe ingresarlo como está en el Ejemplo
el operador ternario verificar y envía la información después de la verificación.*/
/* */

//AGREGAR EL SVG DE CADA ALERTA PARA 14 06 2023
showNotification = (type, message, idNotificacion) => {

    let alertClass = "";
    let alertMessage = "";

    if (idNotificacion == null || idNotificacion == undefined) {
        idNotificacion = "#notificacion";
    }

    switch (type) {
        case "success":
            alertClass = "alert-success";
            alertMessage = message ? message : `Proceso Realizado Correctamente.`;
            break;
        case "error":
            alertClass = "alert-secondary";
            alertMessage = message ? message : `No se pudo completar el Procedimiento.`;
            break;
        case "updated":
            alertClass = "alert-success";
            alertMessage = message ? message : "Informacion Actualizada.";
            break;
        case "deleted":
            alertClass = "alert-danger";
            alertMessage = message ? message : "Registro Eliminado.";
            break;
        case "loading":
            alertClass = "alert-warning";
            alertMessage = message ? message : "En Proceso";
            break;
        default:
            break;
    }

    $(idNotificacion).html(`
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${alertMessage}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `);

    setTimeout(function () {
        $(idNotificacion).find(".alert").alert('close');
    }, 5000);
};

