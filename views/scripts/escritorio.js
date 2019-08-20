var tabla;
//function que se ejectua al inicio
function init() {
    // mostrarform(false);
    gananciasDia()

}

function bienvenido() {
    $(document).ready(function() {
        alertify.alert('BIENVENIDO AL SISTEMA');
    });
}

function gananciasDia() {
    $.post("../ajax/consulta.php?op=GananciasDia", function(data, status) {
        $("#ganancias").html(' <i class="fa fa-arrow-right"></i> Ganancias Neto $' + data + '.00');
    });
}
//funcion para listar en ajax
// function listar() {
//     tabla = $('#tablalistado').dataTable({ //mediante la propiedad datatable enviamos valores

//         "responsive": {
//             "details": true,
//         },
//         "aProcessing": true, //Activamos el prcesamiento del datatable
//         "aServerSide": true, //Paginacion y filtrado realizado por el servidor
//         dom: 'Bfrtip', //Definimos los elementos del control de tabla
//         buttons: [ //botones para exportar 
//             'copyHtml5',
//             'excelHtml5',
//             'csvHtml5',
//             'pdf'
//         ],
//         "ajax": {
//             url: '../ajax/categoria.php?op=listar',
//             type: "get",
//             dataType: "json",
//             error: function(e) {
//                 console.log(e.responseText)
//             }
//         },
//         "bDestroy": true,
//         "iDisplayLength": 5, //paginacion cada 5 registros
//         "order": [
//                 [0, "desc"]
//             ] //orden de listado , columna 0, el id de categoria

//     }).dataTable();
// }

// function mostrar(idcategoria) {
//     $.post("../ajax/categoria.php?op=mostrar", { id_categoria: idcategoria }, function(data, status) {
//         $("#title_categoria").text("Editar Categoria");
//         data = JSON.parse(data);
//         $("#id_categoria").val(data.id_categoria); //aquie se encuentra el valor del input hidden id_categoria
//         $("#nombre_categoria").val(data.nombre_categoria); //aqui se encuentra el valor del imput nombre_categoria
//     });
// }

//La primera funcion que se va ejecutar es init
init();