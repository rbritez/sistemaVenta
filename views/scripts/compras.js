var tabla;

function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        // cerrar();
    });
    //cargamos los proveedores
    $.post("../ajax/compras.php?op=selectProveedor", function(r) {
        $("#proveedor_id").html(r);
        $("#proveedor_id").selectpicker('refresh');
    });
}
//function mostrar form
function mostrarform(flag) {
    limpiar();

    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop('disabled', false);
        $("#btnagregar").hide();
        detalle = 0;

    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
//funcion para cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
}
//deja limpio todos los campos al cerrar
function limpiar() {
    $("#title_product").text("Nueva Compra");
    $("#id_compra").val("");
    $("#proveedor_id").val("");
    $("#proveedor_id").selectpicker('refresh');
    $("#serie").val("");
    $("#numcomprobante").val("");
    $("#fecha_compra").val("");
    $("#impuesto").val("");
    $("#total_compra").val("");
    $(".filas").remove();
    $("#total").html("$ 0.00");
    $("#boton_block").show();
    $("#tipocomprobante").val("");
    $("#tipocomprobante").selectpicker('refresh');
    //fecha actual
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear() + "-" + (month) + "-" + (day);
    $("#fecha_compra").val(today);
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
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/compras.php?op=listar',
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
            url: '../ajax/compras.php?op=listarProductos',
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
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/compras.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 1) {
                alertify.alert('Resultado Satisfactorio', 'Se guardaron los datos con exito! ');
            } else if (datos == 0) {
                alertify.alert('Resultado Inconcluso', 'Hubo un error al guardar');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
            listar();
        }
    });
    limpiar();
}

//funcion mostrar productos para editar
function mostrar(idcompra) {
    $.post("../ajax/compras.php?op=mostrar", { id_compra: idcompra },
        function(data, status) {
            data = JSON.parse(data);
            mostrarform(true);
            $("#id_proveedor").val(data.id_proveedor);
            $("#id_proveedor").selectpicker('refresh');
            $("#tipocomprobante").val(data.tipocomprobante);
            $("#tipocomprobante").selectpicker('refresh');
            $("#serie").val(data.serie);
            $("#numcomprobante").val(data.numcomprobante);
            $("#fecha_compra").val(data.fecha);
            $("#impuesto").val(data.impuesto);
            $("#id_compra").val(data.id_compra);
            //ocultar botones
            $("#btnguardar").hide();
            if ($("#boton_block").length) {
                $("#boton_block").hide();
            }
            $("#btnCancelar").html("<i class='fa fa-arrow-circle-left'></i> Volver");

        });
    $.post("../ajax/compras.php?op=mostrarDetalles&id=" + idcompra, function(r) {

        $("#detalles").html(r);
    })

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
    if (tipocomprobante === "factura") {
        $("#impuesto").val(impuesto);
    } else {
        $("#impuesto").val("0");
    }
}

function agregardetalle(idproducto, descripcion) {
    var cantidad = 1;
    var precio_compra = 1;
    var precio_venta = 1;

    if (idproducto != "") {
        var subtotal = cantidad * precio_compra;
        var fila = '<tr class="filas" id="fila' + cont + '" style="text-align:center">' +
            '<td><button type="button" class="btn btn-danger" onclick="eliminardetalle(' + cont + ')"><i class="fa fa-times"></i></button></td>' +

            '<td><input type="hidden" name="producto_id[]" value="' + idproducto + '">' + descripcion + '</td>' +

            '<td><input type="number" name="cantidad[]"  id="cantidad[]" value="' + cantidad + '"></td>' +

            '<td><input type="number" step="0.01" name="precio_compra[]" id="precio_compra[]" value="' + precio_compra + '"></td>' +

            '<td><input type="number" step="0.01" name="precio_venta[]" id="precio_venta[]" value="' + precio_venta + '"></td>' +

            '<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +

            '<td><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>'
        '<tr>';
        cont = cont + 1;
        detalle = detalle + 1;
        $("#detalles").append(fila);
        modificarSubtotales();
    } else {
        alertify.alert("RESULTADO INCONCLUSO", "Error al ingresar el detalle, revisar los datos del Producto")
    }
}

function modificarSubtotales() {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_compra[]");
    var sub = document.getElementsByName("subtotal");
    for (var index = 0; index < cant.length; index++) {

        var inpC = $(cant[index]).val(); //cantidad 
        var inpP = $(prec[index]).val(); //precio
        var inpS = sub[index]; //subtotal

        inpS = inpC * inpP;
        document.getElementsByName("subtotal")[index].innerHTML = inpS;
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
init();