URL_PETICION_MODULOS = `${constante.HOST}/su_administrador/diseno_vistas`;
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const createView = async (jsonData) => {
    const id = jsonData.idSubmenu
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/create/${id}`,
        method: 'POST',
        data: jsonData,
        success: function (res) {
            console.log({ res })
            resetModal("#createView")
            return;
        },
        error: function (err) {
            console.log(err.responseJSON.message);
            resetModal("#createView")
            return;
        }
    })
}

const updateView = async (id, jsonData) => {

    await $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: 'PUT',
        data: jsonData,
        success: function (res) {
            console.log({ res })
            resetModal("#editView")
            return;
        },
        error: function (err) {
            console.log(err.responseJSON.message);
            resetModal("#editView")
            return;
        }
    })

}

const deleteView = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: 'DELETE',
        success: function (res) {
            resetModal()
            console.log({ res })
        },
        error: function (err) {
            resetModal()
            console.log(err.responseJSON.message);
        }

    });
}

const updateStatus = async (id) => {
    await $.ajax({
        url: `${URL_PETICION_MODULOS}/changeStatus/${id}`,
        method: 'PUT',
        success: function (res) {
            resetModal()
            console.log(res)
        },
        error: function (err) {
            resetModal()
            console.log(err.responseJSON.message);
        }
    })
}
const resetModal = (modal) => {
    if (modal) {
        $(modal).modal("hide");
        $(".table").load(location.href + " .table");
        return;
    }
    $(".table").load(location.href + " .table");
    return;
}

