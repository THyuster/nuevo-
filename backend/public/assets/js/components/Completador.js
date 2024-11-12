const completador = async (url) => {
    let entidad_tercero = await search(url);
    return entidad_tercero['entidad_tercero'];
}

const obtenerSugerenciasFiltradas = (textoIngresado, sugerencias) => {
    return sugerencias.filter(sugerencia =>
        sugerencia.toLowerCase().startsWith(textoIngresado)
    );
};

const obtenerSugerenciaObjecto = (sugerenciaSeleccionada, sugerencias) => {
    return sugerencias.find(sugerencia =>
        Object.values(sugerencia).some(valor =>
            valor.toString() === sugerenciaSeleccionada
        )
    );
}

const obtenerTodosLosAtributos = (sugerenciasNombres) => {
    return sugerenciasNombres.flatMap(sugerencia =>
        Object.values(sugerencia).map(valor => valor.toString())
    );
};

const obtenerParteAntesDeAtributo = (campo) => {
    return campo.slice(0, campo.lastIndexOf('_'));
}

const obtenerMejorSugerencia = (textoIngresado, sugerencias) => {
    let mejorSimilitud = 0;
    let sugerenciaSeleccionada = '';

    sugerencias.forEach(sugerencia => {
        const similitud = calcularSimilitud(textoIngresado, sugerencia);
        if (similitud > mejorSimilitud) {
            mejorSimilitud = similitud;
            sugerenciaSeleccionada = sugerencia;
        }
    });

    return sugerenciaSeleccionada;
};

const mostrarSugerencias = (input, sugerenciasNombres, isDeleting, formulario, camposInput) => {


    const sugerencias = obtenerTodosLosAtributos(sugerenciasNombres);

    const umbralSimilitud = 0.91;

    const textoIngresado = input.val().trim().toLowerCase();

    const valorActual = input.data('valor-actual');

    if (textoIngresado !== valorActual) {

        for (const key in camposInput) {
            $(`${formulario} input[name="${camposInput[key]}"]`).val('');
        }

        input.data('valor-actual', textoIngresado);
    }

    if (isDeleting || textoIngresado === '') {
        for (const key in camposInput) {
            $(`${formulario} input[name="${camposInput[key]}"]`).val('');
        }
    }

    if (textoIngresado !== '') {


        const sugerenciasFiltradas = obtenerSugerenciasFiltradas(textoIngresado, sugerencias);

        if (sugerenciasFiltradas.length === 1) {

            const sugerenciaSeleccionada = obtenerMejorSugerencia(textoIngresado, sugerenciasFiltradas);

            if (calcularSimilitud(textoIngresado, sugerenciaSeleccionada) >= umbralSimilitud) {

                const sugerenciaSeleccionadaUpper = sugerenciaSeleccionada.toUpperCase();
                const datos = obtenerSugerenciaObjecto(sugerenciaSeleccionadaUpper, sugerenciasNombres);

                input.val(datos.identificacion);

                for (const key in camposInput) {
                    const campoFiltrado = camposInput[key];
                    const parteAntesDeAtributo = obtenerParteAntesDeAtributo(campoFiltrado);
                    $(`${formulario} input[name="${camposInput[key]}"]`).val(datos[parteAntesDeAtributo]);
                }
            }
        }

    }
};

const calcularSimilitud = (str1, str2) => {
    const len1 = str1.length;
    const len2 = str2.length;
    const dp = Array.from({ length: len1 + 1 }, () => Array(len2 + 1).fill(0));

    for (let i = 1; i <= len1; i++) {
        for (let j = 1; j <= len2; j++) {
            (str1[i - 1].toLowerCase() === str2[j - 1].toLowerCase())
                ? dp[i][j] = dp[i - 1][j - 1] + 1 : dp[i][j] = Math.max(dp[i - 1][j], dp[i][j - 1]);
        }
    }

    return dp[len1][len2] / Math.max(len1, len2);
}

const search = async (url) => {
    let datos = await $.ajax({
        url: url,
        method: "GET",
        success: async function (response) {

            for (const entidad in response) {
                for (const elemento of response[entidad]) {
                    for (const atributo in elemento) {
                        return await elemento[atributo];
                    }
                }
            }

        },
        error: function (error) {
            console.log(error);
        },
    });
    return datos;
}

export { completador, mostrarSugerencias }