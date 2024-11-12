// =============  Data Table - (Start) ================= //

$(document).ready(function(){ 
    var table = $('#vehiculos').DataTable({
        
        buttons:['copy', 'csv', 'excel', 'pdf', 'print']
        
    });
    table.buttons().container()
    .appendTo('#vehiculos_wrapper .col-md-6:eq(0)')    
});

// =============  Data Table - (End) ================= //
