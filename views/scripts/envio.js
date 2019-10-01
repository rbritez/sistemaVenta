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
    $("#title_categoria").text("Nueva Categoria");
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
            'pdf'
        ],
        "ajax": {
            url: '../ajax/envios.php?op=listar',
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
    $(".dt-button.buttons-copy.buttons-html5").attr('id', 'botonCopia');
    $("#botonCopia").html('<span><i class="fa fa-copy"></i> Copia</span>');
    $(".dt-button.buttons-excel.buttons-html5").attr('id', 'botonExcel');
    $("#botonExcel").html('<span><i class="fa fa-file-excel-o"></i> Excel</span>');
    $("#botonExcel").css('color', 'white');
    $("#botonExcel").css('background', 'green');
    $(".dt-button.buttons-pdf.buttons-html5").attr('id', 'botonPdf');
    $("#botonPdf").html('<span><i class="fa fa-file-pdf-o"></i> PDF</span>');
    $("#botonPdf").css('color', 'white');
    $("#botonPdf").css('background', '#D33724');
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
        $("#title_categoria").text("Editar Categoria");
        data = JSON.parse(data);
        $("#id_categoria").val(data.id_categoria); //aquie se encuentra el valor del input hidden id_categoria
        $("#nombre_categoria").val(data.nombre_categoria); //aqui se encuentra el valor del imput nombre_categoria
    });
    $("#cerrar").on("click", function() {
        limpiar();
    });
}

function desactivar(idenvio) {

    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea Anular el Envio?",
        function() {
            $.post("../ajax/envios.php?op=desactivar", { id_envio: idenvio }, function(e) {
                if (e = 1) {
                    alertify.success('Se Anulo con exito!');
                } else {
                    alertify.error('Hubo un error al Anular');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada');
        });
}

function activar(idenvio) {

    alertify.confirm("CONFIRMAR", "¿Envio de Productos Entregados?",
        function() {
            $.post("../ajax/envios.php?op=activar", { id_envio: idenvio }, function(e) {
                if (e = 1) {
                    alertify.success('Se confirmo el envio con exito!');
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