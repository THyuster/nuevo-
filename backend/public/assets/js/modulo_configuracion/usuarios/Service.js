const url = location.href + "/show";

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const camposExcluir = [
    "id",
    "email_verified_at",
    "two_factor_confirmed_at",
    "current_team_id",
    "profile_photo_path",
    "created_at",
    "updated_at",
    "modulo",
    "profile_photo_url",
];

const buttonsModal = {
    // idEditModal: "#editUser",
    idDeleteModal: "#deleteUser",
};
const btnModalActions = {
    // edit: "#btnEditUser",
    delete: "#btnDeleteUser",
};

const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#delete", function () {
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
        console.log(data);

    });
    $(tbody).on("click", "#estado", function (e) {
        e.preventDefault();
        
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
        console.log(data);

        change($(this),"estado");
    });
    $(tbody).on("click", "#btnadministrador", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        console.log(data);
        localStorage.setItem("id", data.id);
        change($(this),"administrador");
    });
};

function change(e,apuntamiento) {
    let button = e;
    button.prop("disabled", true);
    let id = localStorage.getItem("id");
    $.ajax({
        url: location.href + `/${apuntamiento}/${id}`,
        method: "PUT",
        success: function (response) {
            // if (response == "elimino") {
            //     resetModal(buttonsModal.idDeleteModal);
            //     button.prop("disabled", false);
            //     localStorage.clear();
            //     showNotification("deleted");
            //     return;
            // }
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
            localStorage.clear();
            showNotification("error");
            return;
        },
        error: function (error) {
            console.log(error);
        },
    });
}

$(btnModalActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this)
    button.prop('disabled', true);
    let id = localStorage.getItem('id')
    $.ajax({
        url: location.href + `/delete/${id}`,
        method: 'DELETE',
        success: function (response) {
            resetModal(buttonsModal.idDeleteModal);
            button.prop('disabled', false);
            localStorage.clear();
            showNotification("error", response);
            return;
        },
        error: function (error) {
            console.error(error);
        }
    })
})

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
        return;
    }
    cargarDatos(url, buttonsModal, "#tabla", camposExcluir);
    return;
};
