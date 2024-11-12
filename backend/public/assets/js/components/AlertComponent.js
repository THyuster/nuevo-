const showNotification = (type, message, idNotificacion = "#notificacion") => {

    $(idNotificacion).html(buildNotification(type, message));

    $('#liveToast').toast('show');

    setTimeout(function () {
        $(idNotificacion).find(".toast").toast('hide');
    }, 5000);
    
};

const buildNotification = (type, message) => {

    const notifications = {
        success: {
            alertClass: "alert alert-success",
            alertMessage: message || "Proceso Realizado Correctamente.",
        },
        error: {
            alertClass: "alert alert-warning",
            alertMessage: message || "No se pudo completar el Procedimiento.",
        },
        deleted: {
            alertClass: "alert alert-danger",
            alertMessage: message || "Registro Eliminado.",
        },
    };

    const { alertClass, alertMessage } = notifications[type] || {};

    if (!alertClass) {
        return;
    }

    return `
    <div class="toast-container border border-0 position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast border border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body  m-0 border border-0 ${alertClass}">
                <span><b>${alertMessage}</b></span>
            </div>
        </div>
    </div>
    `
}