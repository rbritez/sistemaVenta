var tabla;

function init() {
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();
    })
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
            url: '../ajax/proveedor.php?op=listar',
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
//dejar los campos vacios
function limpiarProveedor() {
    $("#title_proveedor").text("NUEVO PROVEEEDOR");
    $("#id_proveedor").val("");
    $("#persona_id").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#razonsocial").val("");
    $("#nro_doc").val("");
    $("#fecha_nac").val("");
}

function cerrar() {
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiarProveedor();
    });
}
//funcion para guardar y editar el proveedor
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/proveedor.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 0) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA PERSONA! ');
            } else if (datos == 1) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR EL PROVEEDOR');
            } else if (datos == 2) {
                alertify.alert('RESULTAOO SATISFACTORIO', 'SE GUARDARON LOS DATOS CON EXITO');
            } else if (datos == 3) {
                alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON LOS DATOS CON EXITO');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiarProveedor();
}

//funcion para mostrar el proveedor a la hora de editar
function mostrar(idproveedor) {
    $.post("../ajax/proveedor.php?op=mostrar", { id_proveedor: idproveedor }, function(data, status) {
        $("#title_proveedor").text("EDITAR PROVEEDOR");
        data = JSON.parse(data);
        $("#id_proveedor").val(data.id_proveedor);
        $("#persona_id").val(data.id_persona);
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#nro_doc").val(data.nro_doc);
        $("#razonsocial").val(data.razon_social);
    });
    $("#cerrar").on("click", function() {
        limpiarProveedor();
    })
}

function activar(idproveedor) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN ACTIVAR EL PROVEEDOR?",
        function() {
            $.post("../ajax/proveedor.php?op=activar", { id_proveedor: idproveedor }, function(e) {
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

function desactivar(idproveedor) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN DESACTIVAR EL PROVEEDOR?",
        function() {
            $.post("../ajax/proveedor.php?op=desactivar", { id_proveedor: idproveedor }, function(e) {
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