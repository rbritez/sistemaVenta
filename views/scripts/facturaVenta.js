var tabla;
var nuevo;

function init() {
    limpiar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        // cerrar();
    });
    //cargamos los clientes
    $.post("../ajax/venta.php?op=selectCliente", function(r) {
        $("#cliente_id").html(r);
        $("#cliente_id").selectpicker('refresh');
    });
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
$("#tipo_pago").change(mostrarCuotas);

function mostrarCuotas() {
    var tipoPago = $("#tipo_pago option:selected").val();
    if (tipoPago === "cred_personal") {
        // $("#tipoPagoDiv").class('form-group col-lg-3 col-md-3 col-sm-3 col-xs-12');
        $("#tipoPagoDiv").removeClass();
        $("#tipoPagoDiv").addClass('form-group col-lg-3 col-md-3 col-sm-3 col-xs-12');
        $("#cuotasDiv").show();
    } else {
        $("#tipoPagoDiv").removeClass();
        $("#tipoPagoDiv").addClass('form-group col-lg-6 col-md-6 col-sm-6 col-xs-12');
        $("#cuotasDiv").hide();
    }
}
//funcion para cancelar form
function cancelarform() {
    limpiar();
}
//deja limpio todos los campos al cerrar
function limpiar() {
    $.post("../ajax/venta.php?op=ultimocodigo", function(data, status) {
        data = JSON.parse(data);
        if (data.cantidad == '51') {
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
    $("#tipoPagoDiv").addClass('form-group col-lg-6 col-md-6 col-sm-6 col-xs-12');
    $("#cuotasDiv").hide();
    //fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_venta").val(today);
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
//funcion para guardar nuevo y editado los productos
function guardaryeditar(e) {
    e.preventDefault();
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
        }
    });
    limpiar();
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
    var cantidad = 1;
    var descuento = 0;
    var interes = 0;

    if (idproducto != "") {
        var subtotal = cantidad * precioVenta;
        var fila = '<tr class="filas" id="fila' + cont + '" style="text-align:center">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminardetalle(' + cont + ')"><i class="fa fa-times"></i></button></td>' +

            '<td><input type="hidden" style="width:90%;" name="producto_id[]" value="' + idproducto + '">' + descripcion + '</td>' +

            '<td><input type="number" align="right" style="width:90%;text-align:right"  name="cantidad[]" min="1" max="' + stock + '" id="cantidad[]" value="' + cantidad + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +

            '<td>$<input type="number" align="right" style="width:90%;text-align:right" step="0.01" min="1" name="precio_venta[]" id="precio_compra[]" value="' + precioVenta + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +

            '<td>%<input type="number" align="right" style="width:90%;text-align:right" step="0.01" min="0" name="descuento[]" id="descuento[]" value="' + descuento + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +
            '<td>%<input type="number" align="right" style="width:90%;text-align:right" step="0.01" min="0" name="interes[]" id="interes[]" value="' + interes + '" onchange="modificarSubtotales();" onkeyup="this.onchange(modificarSubtotales());" onpaste="this.onchange(modificarSubtotales());" oninput="this.onchange(modificarSubtotales());"></td>' +
            '<td>$<span name="subtotal" style="width:90%;text-align:right" id="subtotal' + cont + '"> ' + subtotal + '</span></td>' +
            '<tr>';
        cont = cont + 1;
        detalle = detalle + 1;
        $("#detalles").append(fila);
        modificarSubtotales();
    } else {
        alertify.alert("RESULTADO INCONCLUSO", "Error al ingresar el detalle, revisar los datos del Producto")
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

function eliminardetalle(i) {
    $('#fila' + i).remove();
    calculartotales();
    detalle = detalle - 1;
    comprobar();
}
init()