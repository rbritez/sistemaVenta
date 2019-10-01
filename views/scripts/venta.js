var tabla;
var nuevo;

function init() {
    mostrarform(false)
    listar()
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })
    $("#fContacto").on("submit", function(e) {
        guardarContacto(e);
    })
    $("#fDire").on("submit", function(e) {
            guardarDireccion(e);
        })
        //cargamos los clientes
    $.post("../ajax/venta.php?op=selectCliente", function(r) {
            $("#cliente_id").html(r);
            $("#cliente_id").selectpicker('refresh');
        })
        //fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_p").val(today);
    $("#soliEnvio").change(verCliente);
    $("#cliente_id").change(cambiarCheck);

}

function guardarContacto(e) {
    e.preventDefault();
    var idCliente = $("#cliente_id").val();
    var timeE = $("#hora_envio").val();
    var dateE = $("#fecha_envio").val();
    var montoE = $("#monto_envio").val();
    var pagoE = $("#pago_envio").val();
    var inpDir = $("#id_direccion_enviar").val();
    var inpCon = $("#id_contacto_enviar").val();
    telefono = $("#telefonoContacto").val();
    celular = $("#celularContacto").val();
    if (telefono || celular) {
        var formData = new FormData($("#fContacto")[0]);
        $.ajax({
            url: "../ajax/contacto.php?op=guardarContacto&id_cliente=" + idCliente,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos) {
                if (datos == 1) {
                    alertify.alert('Resultado Satisfactorio', 'Se guardaron los datos con exito!', function() {

                    });
                } else if (datos == 0) {
                    alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
                }
                $('#tblContactos').dataTable().api().ajax.reload();
                $("#telefonoContacto").val('');
                $("#celularContacto").val('');
                mostrarInputEnvio(true);
                $("#fecha_envio").val(dateE);
                $("#hora_envio").val(timeE);
                $("#monto_envio").val(montoE);
                $("#pago_envio").val(pagoE);
                $("#id_direccion_enviar").val(inpDir);
                $("#id_contacto_enviar").val(inpCon);
            }
        });

    } else {
        alertify.alert('ERROR', 'Debe cargar almenos un campo para continuar!!');
        return false;
    }
}
var enviando = false; //Obligaremos a entrar el if en el primer submit

function checkSubmit() {
    if (!enviando) {
        enviando = true;
        return true;
    } else {
        //Si llega hasta aca significa que pulsaron 2 veces el boton submit
        return false;
    }
}

function guardarDireccion(e) {
    e.preventDefault();
    var idCliente = $("#cliente_id").val();
    var timeE = $("#hora_envio").val();
    var dateE = $("#fecha_envio").val();
    var montoE = $("#monto_envio").val();
    var pagoE = $("#pago_envio").val();
    var inpDir = $("#id_direccion_enviar").val();
    var inpCon = $("#id_contacto_enviar").val();
    prov = $("#provDire").val();
    loc = $("#locDire").val();
    if (prov && loc) {
        var formData = new FormData($("#fDire")[0]);
        $.ajax({
            url: "../ajax/direccion.php?op=guardarDireccion&id_cliente=" + idCliente,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos) {
                if (datos == 1) {
                    alertify.alert('Resultado Satisfactorio', 'Se guardaron los datos con exito!', function() {

                    });
                } else if (datos == 0) {
                    alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
                }

                $('#tblDireccion').dataTable().api().ajax.reload();
                $("#provDire").val('');
                $("#locDire").val('');
                $("#barDire").val('');
                $("#calDire").val('');
                $("#altDire").val('');
                $("#mzDire").val('');
                $("#pisoDire").val('');
                $("#dptDire").val('');
                $("#infaddDire").val('');
                mostrarInputEnvio(true);
                $("#fecha_envio").val(dateE);
                $("#hora_envio").val(timeE);
                $("#monto_envio").val(montoE);
                $("#pago_envio").val(pagoE);
                $("#id_direccion_enviar").val(inpDir);
                $("#id_contacto_enviar").val(inpCon);
            }
        });

    } else {
        alertify.alert('ERROR', 'Los campos PROVINCIA y LOCALIDAD son obligatorios!!');
        return false;
    }
}

function mostrarContacto() {
    var idCliente = $("#cliente_id").val();
    console.log(idCliente);
    tabla = $('#tblContactos').dataTable({ //mediante la propiedad datatable enviamos valores
        "responsive": {
            "details": true,
        },
        "aProcessing": true, //Activamos el prcesamiento del datatable
        "aServerSide": true, //Paginacion y filtrado realizado por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [ //botones para exportar 

        ],
        "ajax": {
            url: '../ajax/venta.php?op=traerContactoCliente&id_cliente=' + idCliente,
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

function mostrarDireccion() {
    var idCliente = $("#cliente_id").val();
    tabla = $('#tblDireccion').dataTable({ //mediante la propiedad datatable enviamos valores
        "responsive": {
            "details": true,
        },
        "aProcessing": true, //Activamos el prcesamiento del datatable
        "aServerSide": true, //Paginacion y filtrado realizado por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [ //botones para exportar 

        ],
        "ajax": {
            url: '../ajax/venta.php?op=traerDireccionCliente&id_cliente=' + idCliente,
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

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */
    var zero = "0"; /* String de cero */

    if (width <= length) {
        if (number < 0) {
            return ("-" + numberOutput.toString());
        } else {
            return numberOutput.toString();
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString());
        }
    }
}

function Verhora() {
    var horaC = $("#hora_envio").val();
    console.log(horaC);
    if (horaC > '06:00' && horaC < '22:00') {

    } else {
        alertify.confirm('ERROR', 'Ingreso una hora fuera del horario de trabajo, ¿Esta segúro que desea Continúar?', function() {

        }, function() {
            $("#hora_envio").val('');
        }).set('labels', { ok: 'CONFIRMAR HORA', cancel: 'VOLVER A INGRESAR' });
    }
}

function verFecha() {
    var fechaCargada = $("#fecha_envio").val();
    console.log(fechaCargada);
    //comando para sacar fecha de hoy 
    var f = new Date();
    var fechahoy = f.getFullYear() + "-" + zfill((f.getMonth() + 1), 2) + "-" + zfill(f.getDate(), 2);
    var resFC = moment(fechaCargada);
    var resFH = moment(fechahoy);
    var resdias = resFC.diff(resFH, 'days');

    if (fechaCargada == fechahoy) {

    } else if (fechaCargada < fechahoy) {
        alertify.alert('ERROR', 'La Fecha Seleccionada no es Valida, Debe seleccionar una fecha mayor a la Actúal', function() {
            $("#fecha_envio").val(fechahoy);
        });
    } else if (resdias > 30) {
        alertify.confirm('PRECAUCIÓN', 'La Fecha Seleccionada supera los 30 Dias, ¿Esta segúro que desea Continúar?', function() {

        }, function() {
            $("#fecha_envio").val(fechahoy);
        }).set('labels', { ok: 'CONFIRMAR FECHA', cancel: 'VOLVER A INGRESAR' });
    }
}


function mostrarInputEnvio(flag) {
    if (flag == true) {
        console.log('mostrar input envio');
        $("#envioaprobado").html(' <div id="renv"><div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">' +
            '<label>FECHA A ENVIAR</label>' +
            '<input type="date" class="form-control" name="fecha_envio" id="fecha_envio" required  onchange="verFecha()">' +
            '</div>' +
            '<div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">' +
            '<label>HORA A ENVIAR</label>' +
            '<input type="time" class="form-control" name="hora_envio" id="hora_envio" required onchange="Verhora()" >' +
            '</div>' +
            '<div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-6">' +
            '<label>CONTACTO</label>' +
            '<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_selectContacto" ><i class="fa fa-phone"></i></button>' +
            '<input type="hidden" name="id_contacto_enviar" id="id_contacto_enviar">' +
            '</div>' +
            '<div class="form-group col-lg-1 col-md-1 col-sm-1 col-xs-6">' +
            '<label>DIRECCIÓN</label>' +
            '<button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_selectDireccion" ><i class="fa fa-map-marker"></i></button>' +
            '<input type="hidden" name="id_direccion_enviar" id="id_direccion_enviar">' +
            '</div>' +
            '<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
            '<label>MONTO ENVIO</label>' +
            '<input type="number" class="form-control" name="monto_envio" min="50" id="monto_envio" value="150" required>' +
            '</div>' +
            '<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">' +
            '<label>LUGAR DE PAGO</label>' +
            '<select name="pago_envio" id="pago_envio"  class="form-control" required>' +
            '<option >Seleccionar...</option>' +
            '<option value="0">Paga en Domicilio</option>' +
            '<option value="1">Paga en comercio</option>' +
            '</select>' +
            '</div></div>');
        mostrarContacto();
        mostrarDireccion();

    } else {
        console.log('ocultar input envio');
        $("#renv").remove();
    }
}

function cambiarCheck() {
    $("#soliEnvio").prop("checked", false);
    mostrarInputEnvio(false);
}

function ultimaFactura(iduser) {
    $.post("../ajax/venta.php?op=ultimaFactura", { id_user: iduser }, function(data, status) {
        data = JSON.parse(data);
        imprimir(data.id_factura, data.tipo_pago);
    })
}

function imprimir(idfactura, tipoPago) {
    if (tipoPago === 'tarjeta') {
        window.open('../reportes/exTicket.php?id=' + idfactura, '_blank');
        window.open('../reportes/exFactura.php?id=' + idfactura, '_blank');
    } else {
        window.open('../reportes/exFactura.php?id=' + idfactura, '_blank');
    }

}

function agregarContacto(idcontacto) {
    $(".botn-agregarC").show();
    $(".botn-mostrarC").hide();
    $("#agregarC" + idcontacto).hide();
    $("#mostrarC" + idcontacto).show();
    $("#id_contacto_enviar").val(idcontacto);
}

function agregarDireccion(iddireccion) {
    $(".botn-agregarD").show();
    $(".botn-mostrarD").hide();
    $("#agregarD" + iddireccion).hide();
    $("#mostrarD" + iddireccion).show();
    $("#id_direccion_enviar").val(iddireccion);
}

function verCliente() {
    idcliente = $('#cliente_id').val();
    if (idcliente) {
        if ($("#soliEnvio").is(':checked')) {
            mostrarInputEnvio(true);
        } else {
            mostrarInputEnvio(false);
        }
    } else {
        alertify.alert('PRECAUCIÓN', 'Debe seleccionar un Cliente antes de Confirmar el envio!!', function() {
            cambiarCheck(false);
        });
    }
}
//function mostrar form
function mostrarform(flag) {
    limpiar();

    if (flag) {
        listarProductos();
        $("#title_venta").html('Nueva Venta <button type="button" class="btn btn-success" onclick="formcliente()" data-toggle="modal" data-target="#modal_nuevoCliente"><i class="fa fa-plus-circle"></i> Nuevo Cliente</button>');
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop('disabled', false);
        $("#btnagregar").hide();
        detalle = 0;

    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#title_venta").html('Lista de Ventas <button type="button" id="btnagregar" onclick="mostrarform(true)" class="btn btn-success" ><i class="fa fa-plus-circle"></i> Nueva Factura</button>');
    }
}
$("#tipo_pago").change(mostrarCuotas);

function mostrarCuotas() {
    var tipoPago = $("#tipo_pago option:selected").val();
    if (tipoPago === "cred_personal") {
        // $("#tipoPagoDiv").class('form-group col-lg-3 col-md-3 col-sm-3 col-xs-12');
        $("#tipoPagoDiv").removeClass();
        $("#tipoPagoDiv").addClass('form-group col-lg-2 col-md-2 col-sm-2 col-xs-12');
        $("#cuotasDiv").show();
    } else {
        $("#tipoPagoDiv").removeClass();
        $("#tipoPagoDiv").addClass('form-group col-lg-4 col-md-4 col-sm-4 col-xs-12');
        $("#cuotasDiv").hide();
    }
}
//funcion para cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}
//deja limpio todos los campos al cerrar
function limpiar() {
    $.post("../ajax/venta.php?op=ultimocodigo", function(data, status) {
        data = JSON.parse(data);
        if (data.cantidad == '101') {
            var serie = parseInt(data.serie) + 1;
            newserie = String(serie).padStart(4, '0');
            $('#serie').val(newserie);
        } else {
            $("#serie").val(data.serie);
            $("#codigo").val(data.codigo);
        }
    });
    $("#id_venta").val("");
    $("#cliente_id").val("");
    $("#cliente_id").selectpicker('refresh');
    $("#fecha_venta").val("");
    $("#tipo_pago").val("");
    $("#tipo_pago").selectpicker('refresh');
    $("#impuesto").val("");
    $("#total_compra").val("");
    $(".filas").remove();
    $("#total").html("$ 0.00");
    $("#boton_block").show();
    $("#tipocomprobante").val("");
    $("#tipocomprobante").selectpicker('refresh');
    $("#tipoPagoDiv").removeClass();
    $("#tipoPagoDiv").addClass('form-group col-lg-4 col-md-4 col-sm-4 col-xs-12');
    $("#cuotasDiv").hide();
    //fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_venta").val(today);
}

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
            url: '../ajax/venta.php?op=listar',
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
//mostrar producctos 
function listarProductos() {
    tabla = $('#tblproductos').dataTable({ //mediante la propiedad datatable enviamos valores

        "responsive": {
            "details": true,
        },
        "aProcessing": true, //Activamos el prcesamiento del datatable
        "aServerSide": true, //Paginacion y filtrado realizado por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [ //botones para exportar 

        ],
        "ajax": {
            url: '../ajax/venta.php?op=listarProductos',
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

// function cerrar() {
//     $("#formulario").ready(function() {
//         $("#cerrar").trigger("click");
//         limpiar();
//     })
// }
//funcion para guardar nuevo y editado los productos
function guardaryeditar(e) {
    e.preventDefault();
    $("#id_contacto_enviar").val();

    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/venta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 1) {
                alertify.confirm('Resultado Satisfactorio', 'Se guardaron los datos con exito! ¿Imprimir Factura?', function() {

                    var user = $("#valorUsuarioParaFactura").val();
                    ultimaFactura(user);
                }, function() {
                    alertify.error('Cancelado, Puede volver atras o Crear una Venta Nueva')
                });
            } else if (datos == 0) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
            $('#tblproductos').dataTable().api().ajax.reload();
            listar();
        }
    });
    limpiar();
}

//funcion mostrar productos para editar
function mostrar(idventa) {
    $.post("../ajax/venta.php?op=mostrar", { id_venta: idventa },
        function(data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            $("#cliente_id").val(data.cliente_id);
            $("#cliente_id").selectpicker('refresh');
            $("#tipocomprobante").val(data.tipo_comprobante);
            $("#tipocomprobante").selectpicker('refresh');
            $("#tipo_pago").val(data.tipo_pago);
            $("#tipo_pago").selectpicker('refresh');
            $("#serie").val(data.serie);
            $("#codigo").val(data.codigo);
            $("#fecha_venta").val(data.fecha_venta);
            $("#impuesto").val(data.impuesto);
            $("#id_venta").val(data.id_factura);
            //ocultar botones
            $.post("../ajax/venta.php?op=mostrarDetalles&id=" + idventa, function(r) {

                $("#detalles").html(r);
            })

            $("#btnguardar").hide();
            if ($("#boton_block").length) {
                $("#boton_block").hide();
            }
            $("#btnCancelar").html("<i class='fa fa-arrow-circle-left'></i> Volver");

        });

}

//desactivar productos
function anular(idcompra) {
    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea anular la compra?",
        function() {
            $.post("../ajax/compras.php?op=anular", { id_producto: idproducto }, function(e) {
                if (e = 1) {
                    alertify.success('Se anulo con exito!');
                } else {
                    alertify.error('Hubo un error al anular');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada');
        });
}
//declaracion de variables necesarias para trabajar con las cmpras
var impuesto = 21;
var cont = 0;
var detalle = 0;
$("#btnguardar").hide();
$("#tipocomprobante").change(marcarImpuesto);

function marcarImpuesto() {
    var tipocomprobante = $("#tipocomprobante option:selected").val();
    if (tipocomprobante === "A") {
        $("#impuesto").val(impuesto);
    } else {
        $("#impuesto").val("0");
    }
}

function agregardetalle(idproducto, descripcion, precioVenta, stock) {
    if (stock == 0) {
        alertify.alert("NOTIFICACIÓN", "ESTE PRODUCTO NO CUENTA CON STOCK!!, POR FAVOR SELECCIONE OTRO PRODUCTO ");
    } else {
        $("#agregarP" + idproducto).hide();
        $("#mostrarP" + idproducto).show();
        var cantidad = 1;
        var descuento = 0;
        var interes = 0;
        if (stock <= 5) {
            alertify.alert("NOTIFICACIÓN", "ESTE PRODUCTO SE ENCUENTRA CON STOCK BAJO!!, POR FAVOR INFORMAR AL ADMINISTRADOR!");
        }
        if (idproducto != "") {
            var subtotal = cantidad * precioVenta;
            var fila = '<tr class="filas" id="fila' + cont + '" style="text-align:center">' +
                '<td><button type="button" class="btn btn-danger" onclick="eliminardetalle(' + cont + ',' + idproducto + ')"><i class="fa fa-times"></i></button></td>' +

                '<td><input type="hidden" style="width:90%;" name="producto_id[]" value="' + idproducto + '">' + descripcion + '</td>' +

                '<td><input type="number" align="right" style="width:90%;text-align:right"  name="cantidad[]" min="1" max="' + stock + '" id="cantidad[]" value="' + cantidad + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +

                '<td>$<input type="number" align="right" style="width:90%;text-align:right" step="0.01" min="1" name="precio_venta[]" id="precio_compra[]" min="' + precioVenta + '" value="' + precioVenta + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +

                '<td>$<input type="number" align="right" style="width:90%;text-align:right" step="0.01" min="0" name="descuento[]" id="descuento[]" value="' + descuento + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +
                '<td>$<input type="number" align="right" style="width:90%;text-align:right" step="0.01" min="0" name="interes[]" id="interes[]" value="' + interes + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +
                '<td>$<span name="subtotal" style="width:90%;text-align:right" id="subtotal' + cont + '"> ' + subtotal + '</span></td>' +
                '</tr>';
            cont = cont + 1;
            detalle = detalle + 1;
            $("#detalles").append(fila);
            modificarSubtotales();
        } else {
            alertify.alert("RESULTADO INCONCLUSO", "Error al ingresar el detalle, revisar los datos del Producto")
        }
    }
}
$("#cantidad").on('input', function() {
    console.log($("#cantidad").val());
});


function modificarSubtotales() {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var inte = document.getElementsByName("interes[]");
    var sub = document.getElementsByName("subtotal");
    for (var index = 0; index < cant.length; index++) {

        if ($(cant[index]).val() == "") {
            $(cant[index]).val('1');
        }
        if ($(desc[index]).val() == "") {
            $(desc[index]).val('0');
        }
        if ($(inte[index]).val() == "") {
            $(inte[index]).val('0');
        }

        var inpC = parseFloat($(cant[index]).val()); //cantidad 
        var inpP = parseFloat($(prec[index]).val()); //precio
        var descP = parseFloat($(desc[index]).val()); //descuento
        var inteP = parseFloat($(inte[index]).val()); //interes
        var inpS = sub[index]; //subtotal


        inpS = (inpC * inpP); //calculo la cantidad * precio
        descuento = inpS - descP; //le resto el descuento
        resultadoFinal = descuento + inteP; //sumo el interes
        document.getElementsByName("subtotal")[index].innerHTML = resultadoFinal;
    }
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

function eliminardetalle(i, idproducto) {
    $("#agregarP" + idproducto).show();
    $("#mostrarP" + idproducto).hide();
    $('#fila' + i).remove();
    calculartotales();
    detalle = detalle - 1;
    comprobar();
}
init()