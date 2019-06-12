var tabla;
//function que se ejectua al inicio
function init() {
    // mostrarform(false);
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();



    })
}
//funcion limpiar, dejara vacio a los objetos del formulario
function limpiar() {
    $("#id_categoria").val("");
    $("#nombre_categoria").val("");
}
// funcion mostrar formulario, 
// function mostrarform(flag) {
//     limpiar(); //Para mantener limpio las cajas de Texto
//     if (flag) {
//         $("#formularioregistros").show();
//     } else {
//         $("#listadoregistros").show();
//     }
// }
// // funcion cancelar formularios, para ocultar un formulario
// function cancelarform() {
//     limpiar();
//     mostrarform(false);
// }
//funcion para listar en ajax
function listar() {
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
            url: '../ajax/categoria.php?op=listar',
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

function cerrar() {
    $('#formulario').ready(function() {
        $('#cerrar').trigger('click');
        limpiar();
    });
}
//funcion para guardar y editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activara la accion predeterminada del evento
    var formData = new FormData($("#formulario")[0]); //obtengo los datos del fomulario
    $.ajax({
        url: "../ajax/categoria.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        //si se ejecuta de manera correcta ,pasa a la siguiente instancia
        success: function(datos) {

            if (datos == 1) {
                alertify.alert('Resultado Satisfactorio', 'Se guardaron los datos con exito! ');
            } else if (datos == 0) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
            } else if (datos == 2) {
                alertify.alert('Resultado Satisfactorio', 'Se actualizaron los datos con exito!');
            } else if (datos == 3) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al actualizar');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiar()

}

function mostrar(idcategoria) {
    $.post("../ajax/categoria.php?op=mostrar", { id_categoria: idcategoria }, function(data, status) {
        data = JSON.parse(data);
        $("#id_categoria").val(data.id_categoria); //aquie se encuentra el valor del input hidden id_categoria
        $("#nombre_categoria").val(data.nombre_categoria); //aqui se encuentra el valor del imput nombre_categoria
    });
    $("#cerrar").on("click", function() {
        limpiar();
    });
}

function desactivar(idcategoria) {

    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea desactivar la Categoría?",
        function() {
            $.post("../ajax/categoria.php?op=desactivar", { id_categoria: idcategoria }, function(e) {
                if (e = 1) {
                    alertify.success('Se desactivo con exito!');
                } else {
                    alertify.error('Hubo un error al desactivar');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada');
        });
}

function activar(idcategoria) {

    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea activar la Categoría?",
        function() {
            $.post("../ajax/categoria.php?op=activar", { id_categoria: idcategoria }, function(e) {
                if (e = 1) {
                    alertify.success('Se activo con exito!');
                } else {
                    alertify.error('Hubo un error al activar');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada');
        });
}
//La primera funcion que se va ejecutar es init
init();