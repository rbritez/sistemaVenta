var tabla;
var montointeresmensual = 0;

function init() {
    mostrarform(false);
    listar();
    mostrarInteres();
    $("#formulariocuota").on("submit", function(e) {
        guardar(e);
    });
    $("#formularioInteres").on("submit", function(e) {
        guardarInteres(e);
        cerrarInteres();
    });
    $.post("../ajax/cuentas.php?op=selectCliente", function(r) {
        $("#cliente_id").html(r);
        $("#cliente_id").selectpicker('refresh');
        $("#btnguardar").hide();
    });

    $("#cliente_id").change(mostrarCuenta);
    $("#cuenta_id").change(mostrarCuota);
    $("#cuota_id").change(mostrardetalle);
}
//funcion para mostrar el formulario de pagar cuota
function mostrarInteres() {
    $.post("../ajax/cuentas.php?op=mostrarInteres", function(data, status) {
        data = JSON.parse(data);
        var monto = data.monto_interes_mes * 10;
        var montonuevo = monto / 10;
        $("#mostrarinteres").append('<span >El monto de Interes mensual actual impuesto por el AFIP es de ' + montonuevo + '%</span><br>')
    });
}

function mostrarformInteres() {
    $("#forminteres").append('<div id="eliminarinteres"><div class="modal-body">' +
        '<div class="row">' +
        '<div class="col-sm-12">' +
        '<form  class="form-horizontal"  name="formularioInteres" id="formularioInteres" method="POST">' +
        '<div class="form-group">' +
        '<label class="col-sm-3 col-sm-3 control-label">TASA MENSUAL DE INTERES %</label>' +
        '<div class="col-sm-9">' +
        '<input type="number" step="0.01" min="0" name="interesM" id="interesM" class="form-control" required>' +
        '<span>La tasa de interés <b style="font-size:18px">mensual</b> es actualizado por el AFIP. <b>*Antes de actualizar por favor verificar últimas actualizaciones en la página oficial del AFIP*</b></span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '<div class="modal-footer">' +
        '<button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrarInteres" name="cerrarInteres" onclick="cerrarInteres()"><i class="fa fa-arrow-circle-left" ></i> VOLVER</button>' +
        '<button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> GUARDAR</button>' +
        '</div>' +
        '</form></div>');

    $.post("../ajax/cuentas.php?op=mostrarInteres", function(data, status) {
        data = JSON.parse(data);
        var monto = data.monto_interes_mes * 10;
        var montonuevo = monto / 10;
        $("#interesM").val(montonuevo);
    });
}

function mostrarform(flag) {
    if (flag == false) {
        $("#formularioregistros").hide();
        $("#btnpagar").show();
        $("#listadoregistros").show();
        $("#title").html('LISTA DE CUENTAS <button type="button" class="btn btn-success" onclick="mostrarform(true)" id="btnpagar"><i class="fa fa-money" aria-hidden="true"></i> Pagar Cuota</button>');

    } else {
        $("#listadoregistros").hide()
        $("#btnpagar").hide();
        $("#title").text("NUEVO PAGO DE CUOTA");
        $("#formularioregistros").show();;
    }
}

function cerrarInteres() {
    $('#formularioInteres').ready(function() {
        $('#cerrarInteres').trigger('click');
        eliminarformInteres();
    });
}

function eliminarformInteres() {
    $("#eliminarinteres").remove();
}

function mostrarCuenta() {
    var cuenta = "";
    $.post("../ajax/cuentas.php?op=selectCuotaCliente", { cuenta_id: cuenta }, function(r) {
        $("#cuota_id").html(r);
        $("#cuota_id").selectpicker("refresh");
        if ($(".filas")) {
            $(".filas").remove();
            $("#detalles").hide();
            $("#btnguardar").hide();
        }
    });
    var cliente = $("#cliente_id").val();
    $.post("../ajax/cuentas.php?op=selectCuentaCliente", { cliente_id: cliente }, function(r) {
        $("#cuenta_id").html(r);
        $("#cuenta_id").selectpicker("refresh");
    });

}

function mostrarCuota() {
    var cuenta = $("#cuenta_id").val();
    $.post("../ajax/cuentas.php?op=selectCuotaCliente", { cuenta_id: cuenta }, function(r) {
        $("#cuota_id").html(r);
        $("#cuota_id").selectpicker("refresh");
    });
}

function mostrardetalle() {
    var cuota = $("#cuota_id").val();
    console.log(cuota);
    $("#detalles").show();
    $.post("../ajax/cuentas.php?op=detallarCuota", { id_cuota: cuota }, function(data, status) {
        data = JSON.parse(data);
        console.log(data.id_cuota);
        agregardetalle(data.id_cuota, data.nro_cuota, data.fecha_v, data.total_cuotas, data.monto, data.interes);
    });
}
var cont = 0;
var detalle = 0;

function agregardetalle(idcuota, nro_cuota, fecha_v, total_cuotas, monto, interes) {
    console.log([idcuota, nro_cuota, fecha_v, total_cuotas, monto, interes]);
    var subtotal = parseFloat(monto) + parseFloat(interes);
    var newdate = fecha_v.split("-").reverse().join("-"); // funcion para voltear fechas

    var fila = '<tr class="filas" id="fila' + cont + '" style="text-align:center">' +
        '<td><button type="button" class="btn btn-danger" onclick="eliminarcuota(' + cont + ')"><i class="fa fa-times"></i></button></td>' +

        '<td><input type="hidden" style="width:90%;" id="idd_cuota" name="id_cuota[]" value="' + idcuota + '">' + nro_cuota + '/' + total_cuotas + '</td>' +

        '<td>' + newdate + '</td>' +

        '<td>' + nro_cuota + '/' + total_cuotas + '</td>' +

        '<td>$' + monto + '</td>' +

        '<td>$' + interes + '</td>' +

        '<td>$<span name="subtotal" style="width:90%;text-align:right" id="subtotal' + cont + '"> ' + subtotal + '</span></td>' +
        '<tr>';
    cont = cont + 1;
    detalle = detalle + 1;
    $("#detalles").append(fila);
    modificarSubtotales();

}

function modificarSubtotales() {
    calculartotales();
}

function calculartotales() {
    var sub = document.getElementsByName("subtotal");

    var total = 0.0;
    for (var index = 0; index < sub.length; index++) {

        total += parseFloat(document.getElementsByName("subtotal")[index].innerHTML); // += funciona para acumular e ir sumando todos los subtotales que existan
    }
    $("#total").html("$ " + total);
    $("#total_compra").val(total);
    comprobar();
}

function comprobar() {
    if (detalle > 0) {
        $("#btnguardar").show();
    } else {
        $("#btnguardar").hide();
        cont = 0;
    }
}

function eliminarcuota(i) {
    $('#fila' + i).remove();
    calculartotales();
    detalle = detalle - 1;
    comprobar();
}

function limpiarcuota() {
    $("#cuota_id").remove();
    $("#divcuota").html('<select name="cuota_id" id="cuota_id" class="form-control selectpicker" data-live-search="true"></select>');
}

function guardar(e) {
    var cuenta = $("#cuenta_id").val();
    e.preventDefault();

    var formData = new FormData($("#formulariocuota")[0]);
    $.ajax({
        url: "../ajax/cuentas.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 1) {
                alertify.confirm('Resultado Satisfactorio', 'Se guardaron los datos con exito! ¿Imprimir Factura?', function() {
                    imprimir(cuenta);
                }, function() {
                    alertify.error('Cancelado, Puede volver atras o Crear una Venta Nueva')
                });
            } else if (datos == 0) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiar();
}

function guardarInteres(e) {
    e.preventDefault();
    var formData = new FormData($("#formularioInteres")[0]);
    $.ajax({
        url: "../ajax/cuentas.php?op=guardarInteres",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 1) {
                alertify.alert('Resultado Satisfactorio', 'Se guardaron los datos con exito! ');
            } else {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar los datos! ');
            }
        }
    });
}

function imprimir(idcuenta) {
    window.open('../reportes/exFacturaCuenta.php?id=' + idcuenta, '_blank');
}
//function para mostrar en el datatable los datos de clientes.
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
            url: '../ajax/cuentas.php?op=listar',
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
//function para que se cierre el modal luego de enviar los datos
function cerrar() {
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiar();
    });
}
//function para dejar en blanco los campos de modal luego de guardar o editar
function limpiar() {
    $(".filas").remove();
    $("#total").html("$ 0.00");
    $("#detalles").hide();
    $("#cliente_id").val("");
    $("#cliente_id").selectpicker("refresh");
    var cliente = "";
    $.post("../ajax/cuentas.php?op=selectCuentaCliente", { cliente_id: cliente }, function(r) {
        $("#cuenta_id").html(r);
        $("#cuenta_id").selectpicker("refresh");
    });
    var cuenta = "";
    $.post("../ajax/cuentas.php?op=selectCuotaCliente", { cuenta_id: cuenta }, function(r) {
        $("#cuota_id").html(r);
        $("#cuota_id").selectpicker("refresh");
    });
    $("#btnguardar").hide();
}
//funcion para mostrar el cliente a la hora de editar en el modal
function mostrar(idcuenta) {
    $.post("../ajax/cuentas.php?op=mostrarProducto", { idcuenta: idcuenta }, function(r) {
        $("#mostrarProducto").html(r);
    });
    $.post("../ajax/cuentas.php?op=mostrarProductoTotal", { idcuenta: idcuenta }, function(r) {
        $("#mostrarProductoTotal").html(r);
    });
    tabla = $('#tablalistadoCuota').dataTable({ //mediante la propiedad datatable enviamos valores
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
            url: '../ajax/cuentas.php?op=mostrar',
            data: { idcuenta: idcuenta },
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

    $("#cerrar").on("click", function() {
        limpiar();
    })
}

function cancelarform() {
    limpiar();
    mostrarform(false);
}

init();