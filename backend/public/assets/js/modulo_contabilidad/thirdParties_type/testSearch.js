$(document).ready(function() {
    $('#thirdPartyType').on('input', function() {
        var query = $(this).val();
        if (query !== '') {
            return data.filter((i)=>i.name.includes(palabraClave));
            }
        });
    });
            // $.ajax({
            //     url: 'buscar_apellidos.php', // Ruta a tu script PHP para buscar apellidos en la base de datos
            //     method: 'POST',
            //     data: { query: query },
            //     dataType: 'json',
            //     success: function(response) {
            //    //  Procesar la respuesta y mostrar los resultados en una lista desplegable 
            //         var suggestions = response.suggestions;
            //         var html = '';
            //         if (suggestions.length > 0) {
            //             for (var i = 0; i < suggestions.length; i++) {
            //                 html += '<option value="' + suggestions[i] + '">' + suggestions[i] + '</option>';
            //             }
            //         } else {
            //             html += '<option value="">No se encontraron coincidencias</option>';
            //         }
            //         $('#apellidos').autocomplete({
            //             source: suggestions,
            //             minLength: 1
            //         });
            //     },
            //     error: function() {
            //         console.log('Error en la solicitud AJAX');
            //     }
            // });
        