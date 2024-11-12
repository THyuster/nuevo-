const camposExcluir = ["moduloRelacion", "idModulo", "cantidad_users"];
const orden = ["Grupo empresarial", "empresa"];

const URL_PETICION_MODULOS = `${constante.HOST}/su_admin/licencias`;

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const buttonsModal = {
    idCreateModal: "#createLicense",
    idEditModal: "#editLicense",
    idDeleteModal: "#deleteLicense",
};

const btnModalButtonsActions = {
    create: "#btnCreateLicense",
    delete: "#btnDeleteLicense",
    edit: "#btnEditLicense",
    estado: "#estado",
};
const obtenerDataTable = function (tbody, table) {
    $(tbody).on("click", "#estado", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
        changeStatus($(this));
    });
    $(tbody).on("click", "#delete", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);
    });
    $(tbody).on("click", "#edit", function (e) {
        e.preventDefault();
        let data = table.row($(this).parents("tr")).data();
        localStorage.setItem("id", data.id);

        $('#formEditlicense input[type="checkbox"]').prop("checked", false);

        data.moduloRelacion.forEach((value) => {
            $(`#formEditlicense input[value="${value}"]`).prop("checked", true);
        });
        for (let objeto in data) {
            if (data.hasOwnProperty(objeto)) {
                let valor = data[objeto];

                if ($(`#formEditlicense input[name="${objeto}"]`).length) {
                    $(`#formEditlicense input[name="${objeto}"]`).val(valor);
                }

                if ($(`#formEditlicense select[name="${objeto}"]`).length) {
                    $(`#formEditlicense select[name="${objeto}"]`).val(valor);
                }
            }
        }
    });
};
let clientsCompanies;
let companiesArray;

$(document).ready(async function () {
    try {
        const responseRelation = await fetch(
            `${constante.HOST}/su_admin/licencias/relations`
        );
        clientsCompanies = await responseRelation.json();

        const responseCompanie = await fetch(
            `${constante.HOST}/modulo_contabilidad/empresas/getAll`
        );
        companiesArray = await responseCompanie.json();

        document.getElementById("empresa_id").disabled = true;
    } catch (error) {
        console.log({ error });
    }
});

$("#cliente_id").on("change", function (e) {
    e.preventDefault();
    const value = Object.fromEntries(new FormData($("#formCreatelicense")[0]));
    showOptions(value);
});

$("#cliente_ids").on("change", function (e) {
    e.preventDefault();
    const value = Object.fromEntries(new FormData($("#formEditlicense")[0]));
    showOptions(value);
});

function showOptions(value) {
    const idBusinessGroup = Object.values(value)[0];

    if (idBusinessGroup == 0) {
        document.getElementById("empresa_id").disabled = true;
    }

    document.getElementById("empresa_id").disabled = false;

    const empresasPintar = clientsCompanies
        .map((i) => (i.cliente_id == idBusinessGroup ? i.empresa_id : null))
        .filter(Boolean);

    var datalistEmpresa = $("#datalistEmpresa_id");
    datalistEmpresa.empty();
    companiesArray.forEach((company) => {
        if (empresasPintar.includes(company.id)) {
            datalistEmpresa.append(
                $("<option>").val(company.id + " - " + company.razon_social)
            );
        }
    });

    $("#empresa_id").attr("list", "datalistEmpresa_id");
}

$(btnModalButtonsActions.create).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    const formData = new FormData($("#formCreatelicense")[0]);
    $('.checkbox-container-create input[type="checkbox"]:checked').each(
        function () {
            formData.append("modulo_id[]", $(this).val());
        }
    );
    // console.log(Object.fromEntries(formData));
    $.ajax({
        url: URL_PETICION_MODULOS,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log({ res });
            showNotification("success");
            $("#formCreatelicense")[0].reset();
            resetModal(buttonsModal.idCreateModal);
            button.prop("disabled", false);
        },
        error: function (err) {
            console.log(err);
            button.prop("disabled", false);
            showNotification("error", err.responseJSON.message);
        },
    });
});

$(btnModalButtonsActions.edit).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    const formData = new FormData($("#formEditlicense")[0]);

    const setIdsModules = new Set();
    $('.checkbox-container-create input[type="checkbox"]:checked').each(
        function () {
            setIdsModules.add($(this).val());
        }
    );
    [...setIdsModules].forEach((i) => formData.append("modulo_id[]", i));

    const id = localStorage.getItem("id");

    $.ajax({
        url: `${URL_PETICION_MODULOS}/update/${id}`,
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {

            showNotification("success");
            $("#formCreatelicense")[0].reset();
            resetModal(buttonsModal.idCreateModal);
            button.prop("disabled", false);
        },
        error: function (err) {

            button.prop("disabled", false);
            showNotification("error", err.responseJSON.message);
        },
    });
});

$(btnModalButtonsActions.delete).on("click", function (e) {
    e.preventDefault();
    let button = $(this);
    button.prop("disabled", true);
    const id = localStorage.getItem("id");
    $.ajax({
        url: `${URL_PETICION_MODULOS}/delete/${id}`,
        method: "DELETE",
        success: function (res) {
            showNotification("success");
            resetModal(buttonsModal.idDeleteModal);
            button.prop("disabled", false);
        },
        error: function (err) {
            button.prop("disabled", false);
            resetModal(buttonsModal.idDeleteModal);

            showNotification("error", err.responseJSON.message);
        },
    });
    localStorage.removeItem("id");
});

function changeStatus(e) {
    const id = localStorage.getItem("id");
    e.prop("disabled", true);
    $.ajax({
        url: `${URL_PETICION_MODULOS}/updateStatus/${id}`,
        method: "PUT",
        success: function (res) {
            resetModal(null);
            e.prop("disabled", true);
            return;
        },
        error: function (err) {
            console.log(err);
            showNotification("error");
        },
    });
}

const resetModal = (modal) => {
    if (modal != null) {
        $(modal).modal("hide");
        cargarDatos(
            `${URL_PETICION_MODULOS}/show`,
            buttonsModal,
            "#compactData",
            camposExcluir
        );
        return;
    }
    cargarDatos(
        `${URL_PETICION_MODULOS}/show`,
        buttonsModal,
        "#compactData",
        camposExcluir
    );
    return;
};
