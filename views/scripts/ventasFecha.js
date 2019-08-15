var tabla;

function init() {
    listar();
    $("#fechaInicio").change(listar);
    $("#fechaFin").change(listar);

}

function listar() {
    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();
    tabla = $('#tablalistado').dataTable({ //mediante la propiedad datatable enviamos valores

        "responsive": {
            "details": true,
        },
        "aProcessing": true, //Activamos el prcesamiento del datatable
        "aServerSide": true, //Paginacion y filtrado realizado por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [ //botones para exportar 
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/consulta.php?op=ventasFecha',
            data: { fechaInicio: fechaInicio, fechaFin: fechaFin },
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText)
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, //paginacion cada 5 registros
        "order": [
                [0, "desc"]
            ] //orden de listado , columna 0, el id de categoria

    }).dataTable();
}
init();