var tabla;

function init() {
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();
    })
}

function modal() {
    $("#title_proveedor").text('NUEVO CLIENTE');
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
            'pdf'
        ],
        "ajax": {
            url: '../ajax/cliente.php?op=listar',
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
//funcion para guardar y editar el cliente
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/cliente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 0) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA PERSONA! ');
            } else if (datos == 1) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR AL CLIENTE!');
            } else if (datos == 2) {
                alertify.alert('RESULTADO SATISFACTORIO', 'SE GUARDARON LOS DATOS DEL CLIENTE CON EXITO!');
            } else if (datos == 3) {
                alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON LOS DATOS CON EXITO!');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiar();
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

    $("#id_cliente").remove();
    $("#persona_id").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#razonsocial").val("");
    $("#nro_doc").val("");
}
//funcion para mostrar el cliente a la hora de editar en el modal
function mostrar(idcliente) {
    $("#title_proveedor").text('EDITAR CLIENTE');
    $.post("../ajax/cliente.php?op=mostrar", { id_cliente: idcliente }, function(data, status) {
        $("#title_cliente").text("EDITAR CLIENTE");
        $("#formulario").append('<input type="hidden" id="id_cliente" name="id_cliente">');
        data = JSON.parse(data);
        $("#id_cliente").val(data.id_clientes);
        $("#persona_id").val(data.persona_id);
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#nro_doc").val(data.nro_doc);
    });
    $("#cerrar").on("click", function() {
        limpiar();
    })
}
//function par activar el cliente
function activar(idcliente) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN ACTIVAR EL CLIENTE?",
        function() {
            $.post("../ajax/cliente.php?op=activar", { id_cliente: idcliente }, function(e) {
                if (e = 1) {
                    alertify.success('SE ACTIVO CON EXITO!');
                } else {
                    alertify.error('HUBO UN ERRRO AL ACTIVAR');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('ACCION CANCELADA');
        });
}
//function para desactivar el cliente
function desactivar(idcliente) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN DESACTIVAR EL CLIENTE?",
        function() {
            $.post("../ajax/cliente.php?op=desactivar", { id_cliente: idcliente }, function(e) {
                if (e = 1) {
                    alertify.success('SE DESACTIVO CON EXITO!');
                } else {
                    alertify.error('HUBO UN ERROR AL DESACTIVAR');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('ACCION CANCELADA');
        });
}
init();