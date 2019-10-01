var tabla;
//function que se ejectua al inicio
function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })
    $.post("../ajax/venta.php?op=selectCliente", function(r) {
        $("#cliente_id").html(r);
        $("#cliente_id").selectpicker('refresh');
    })
}
//funcion limpiar, dejara vacio a los objetos del formulario
function limpiar() {
    $(".filas").remove();
    $("#cliente_id").val("");
    $("#cliente_id").selectpicker('refresh');
    $("#btnguardar").hide();

}
//funcion mostrar formulario, 
function mostrarform(flag) {
    limpiar(); //Para mantener limpio las cajas de Texto
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#boton_block").show();
        $("#title_pm").html('Nueva Consultas o Pedido <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_nuevoCliente"><i class="fa fa-plus-circle"></i> Nuevo Cliente</button>');
        //fecha actual
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);
        $("#fecha_p").val(today);
    } else {
        $("#formularioregistros").hide();
        $("#listadoregistros").show();
        $("#title_pm").html('Lista de Consultas y Pedidos de Productos a Medida <button type="button" class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Nuevo Pedido</button>');
    }
}
// funcion cancelar formularios, para ocultar un formulario
function cancelarform() {
    limpiar();
    mostrarform(false);
}
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
            url: '../ajax/productosAM.php?op=listar',
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
        url: "../ajax/productosAM.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        //si se ejecuta de manera correcta ,pasa a la siguiente instancia
        success: function(datos) {
            if (datos == 1) {
                alertify.alert('Resultado Satisfactorio', 'Se guardo el Pedido con exito! ');
            } else if (datos == 0) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
            } else if (datos == 2) {
                alertify.alert('Resultado Satisfactorio', 'Se Modifico el Pedido con exito!');
            } else if (datos == 3) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al actualizar');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiar()

}

function mostrar(idp) {
    $.post("../ajax/productosAM.php?op=mostrar", { id_prod_medida: idp },
        function(data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            $("#cliente_id").val(data.cliente_id);
            $("#cliente_id").selectpicker('refresh');
            $("#fecha_venta").val(data.fecha_pedido);
            //ocultar botones
            $.post("../ajax/productosAM.php?op=mostrarDetalles&idp=" + idp, function(r) {
                $("#detalles").html(r);
            })
            $("#btnguardar").hide();
            if ($("#boton_block").length) {
                $("#boton_block").hide();
            }
            $("#btnCancelar").html("<i class='fa fa-arrow-circle-left'></i> Volver");
            $("#title_pm").html("Consulta o Pedido Realizado");

        });
}

function desactivar(idprodmedida) {

    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea Eliminar el Pedido?",
        function() {
            $.post("../ajax/productosAM.php?op=desactivar", { id_prod_medida: idprodmedida }, function(e) {
                if (e = 1) {
                    alertify.success('Se Elimino el Pedido con exito!');
                } else {
                    alertify.error('Hubo un error al Eliminar');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada');
        });
}

function activar(idprodmedida) {

    alertify.confirm("ATENCIÓN", "¿Ya se Realizo aviso el Pedido?",
        function() {
            $.post("../ajax/productosAM.php?op=activar", { id_prod_medida: idprodmedida }, function(e) {
                if (e = 1) {
                    alertify.success('Se Confirmo el Aviso con exito!');
                } else {
                    alertify.error('Hubo un error al Confirmar Aviso');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada');
        });
}
var cont = 0;
var detalle = 0;
//funcion para agregar pedido
function agregardetalle() {
    if ($("#categoria_id")) {
        $("#categoria_id").prop('id', '"categoria_id' + cont + '"');
        $("#material_id").prop('id', '"material_id' + cont + '"');
    }
    var cantidad = 1;
    var fila = '<tr class="filas" id="fila' + cont + '">' +
        '<td><button type="button" class="btn btn-danger" onclick="eliminardetalle(' + cont + ')"><i class="fa fa-times"></i></button></td>' +
        '<td><input type="number" name="cantidad[]" class="form-control" style="width:55px;text-align:right" min="1"  value="' + cantidad + '" required></td>' +
        '<td><input type="number" name="alto[]" class="form-control" style="width:70px;text-align:center" min="0" step="0.01" required ></td>' +
        '<td><input type="number" name="ancho[]" class="form-control" style="width:70px" min="0" step="0.01" required ></td>' +
        '<td><input type="number" name="prof[]" class="form-control" style="width:70px" min="0" step="0.01" ></td>' +
        '<td><select name="material_id[]" id="material_id" class=" form-control selectpicker" data-live-search="true" required>' +
        '<option value="">Seleccionar...</option>' +
        '</select></td>' +
        '<td><select name="categoria_id[]" id="categoria_id" class=" form-control selectpicker" data-live-search="true" required>' +
        '<option value="">Seleccionar...</option>' +
        '</select></td>' +
        '<td><input type="text"  name="info_add[]" ></td>' +
        '</tr>';
    $.post("../ajax/producto.php?op=selectCategoria", function(r) {
        $("#categoria_id").html(r);
        $("#categoria_id").selectpicker('refresh');
    })
    $.post("../ajax/producto.php?op=selectMaterial", function(s) {
        $("#material_id").html(s);
        $("#material_id").selectpicker('refresh');
    })
    cont = cont + 1;
    detalle = detalle + 1;
    $("#detalles").append(fila);
    console.log("Se agrego  " + detalle + " filas");
    $("#cfilas").val(detalle);
    comprobar();
}

function eliminardetalle(i) {
    $('#fila' + i).remove();
    detalle = detalle - 1;
    comprobar();
    console.log("despues de eliminar quedan  " + detalle + " filas");
    $("#cfilas").val(detalle);
}

function comprobar() {
    if (detalle > 0) {
        $("#btnguardar").show();
    } else {
        $("#btnguardar").hide();
        cont = 0;
    }
}
//La primera funcion que se va ejecutar es init
init();