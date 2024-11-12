var tables = {};

/* 
Esta función carga datos desde una URL y los muestra en una tabla HTML, 
proporcionando mensajes de estado en caso de éxito o error.

La función cargarDatos toma varios parámetros:

    url: la URL desde la cual se cargarán los datos.
    idButtons: el identificador de los botones relacionados con la tabla.
    idTabla: el identificador de la tabla HTML donde se mostrarán los datos.
    camposExcluir: una lista de campos que se excluirán al construir las columnas de la tabla.
    orden: un parámetro opcional que se usa para ordenar los datos.
*/

function cargarDatos(url, idButtons, idTabla, camposExcluir, orden) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.length > 0) {
                    let columna = construirColumnas(
                        response,
                        camposExcluir,
                        idButtons,
                        orden
                    );
                    // console.log(columna);
                    // console.log($(idTabla));
                    tables[idTabla]
                        ? tables[idTabla].clear().rows.add(response).draw()
                        : crearTabla(response, idTabla, columna);
                }
                if (tables[idTabla] && response.length == 0) {
                    tables[idTabla].clear().rows.add(response).draw();
                }

                tables[idTabla] == undefined
                    ? $(idTabla).html(
                          `<td id="mensajeDefault" valign="top" colspan="3" class="">No hay datos Creados</td>`
                      )
                    : $(idTabla).find("td#mensajeDefault").remove();

                // Resolvemos la Promise ya que la carga de datos ha terminado exitosamente
                resolve();
            },
            error: function (xhr, status, error) {
                tables[idTabla] == undefined
                    ? $(idTabla).html(
                          `<td id="mensajeDefault" valign="top" colspan="3" class="">Error al obtener los datos Recargar la pagina</td>`
                      )
                    : console.error("Error al obtener los datos:", error);
                console.log(xhr);

                // Rechazamos la Promise si ocurrió un error durante la carga de datos
                reject(error);
            },
        });
    });
}

/* 
La función construirColumnas recibe los siguientes parámetros:

datos: los datos utilizados para construir las columnas de la tabla.
camposExcluir: una lista de campos que se deben excluir al construir las columnas.
idButtons: los identificadores de los botones relacionados con la tabla.
ordenPropiedades: un arreglo opcional que indica el orden en el que se deben agregar las propiedades/columnas.
*/

function construirColumnas(datos, camposExcluir, idButtons, ordenPropiedades) {
    let columnas = [];
    let propiedadesAgregadas = [];
    let posicionEstado = -1;

    if (ordenPropiedades && Array.isArray(ordenPropiedades)) {
        for (let i = 0; i < ordenPropiedades.length; i++) {
            let key = ordenPropiedades[i];

            if (
                datos[0].hasOwnProperty(key) &&
                camposExcluir.indexOf(key) === -1 &&
                !patron.test(key)
            ) {
                let columna = {
                    data: key,
                    title: key.charAt(0).toUpperCase() + key.slice(1),
                };

                if (modificarColumnas.indexOf(key) !== -1) {
                    const posicion = key;
                    columna.render = function (data, type, row) {
                        return columnasTransformacion(posicion, data);
                    };
                }

                columnas.push(columna);
                propiedadesAgregadas.push(key);
            }
        }
    }
    for (let key in datos[0]) {
        if (
            datos[0].hasOwnProperty(key) &&
            camposExcluir.indexOf(key) === -1 &&
            !patron.test(key) &&
            propiedadesAgregadas.indexOf(key) === -1
        ) {
            let columna = {
                data: key,
                title: key.charAt(0).toUpperCase() + key.slice(1),
            };

            if (modificarColumnas.indexOf(key) !== -1) {
                const posicion = key;
                columna.render = function (data, type, row) {
                    return columnasTransformacion(posicion, data);
                };
            }

            columnas.push(columna);
        }
    }

    if (propiedadesAgregadas.length === 0) {
        columnas.sort((a, b) =>
            a.title.localeCompare(b.title, undefined, { sensitivity: "base" })
        );
    }

    columnas.forEach((value, index) => {
        if (value.data === "estado") {
            posicionEstado = index;
        }
    });

    if (camposExcluir.indexOf("acciones") === -1) {
        columnas.push({
            data: null,
            title: "Acción",
            render: function (data, type, row) {
                return `
                <div class="text-center">
                    <button type='button' id="edit" data-bs-toggle="modal" data-bs-target="${idButtons.idEditModal}"
                        class="btn btn-info editar">EDITAR</button>
                    <button type='button' id="delete" data-bs-toggle="modal" data-bs-target="${idButtons.idDeleteModal}"
                        class="btn btn-danger">ELIMINAR</button>
                </div>`;
            },
        });
    }

    if (posicionEstado !== -1) {
        columnas.splice(-1, 0, columnas.splice(posicionEstado, 1)[0]);
    }

    return columnas;
}

// Función para borrar las claves relacionadas con DataTables del localStorage
const borrarLocalStorageDataTables = () => {
    const keysToDelete = [];

    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith("DataTables_")) {
            keysToDelete.push(key);
        }
    }

    keysToDelete.forEach((key) => localStorage.removeItem(key));
};

// Llamar a la función para borrar las claves de DataTables
// borrarLocalStorageDataTables();

/* 
La función crearTabla recibe los siguientes parámetros:

datos: los datos que se mostrarán en la tabla.
idTabla: el identificador de la tabla HTML donde se mostrarán los datos.
columnas: las columnas de la tabla que se crearán utilizando la función construirColumnas.
*/
function crearTabla(datos, idTabla, columnas) {
    if (tables[idTabla]) {
        tables[idTabla].destroy();
    }

    borrarLocalStorageDataTables();

    // Aqui se realizan los cambios en los estilos
    $(idTabla).addClass(
        "border table-responsive table table-hover table-striped"
    );
    $(idTabla).css("width", "100%");

    // Crear la tabla dinámica
    tables[idTabla] = $(idTabla).DataTable({
        // serverSide: true,
        responsive: true,
        autoWidth: true,
        stateSave: false,
        data: datos,
        columns: columnas,
        language: idioma_espanol,
        lengthMenu: lengthMenu,
        searchDelay: 500,
        columnDefs: columnDefs,
        stateSave: true,
    });

    obtenerDataTable(`${idTabla} tbody`, tables[idTabla]);
}
