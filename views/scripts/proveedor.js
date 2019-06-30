var tabla;

function init() {
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();



    })
}

function limpiar() {
    $("#title_proveedor").text("Nuevo Proveedor");
    $("#id_proveedor").val("");
    $("#persona_id").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#razonsocial").val("");
    $("#nro_doc").val("");
    $("#fecha_nac").val("");
    $("#barrio").val("");
    $("#calle").val("");
    $("#manzana").val("");
    $("#altura").val("");
    $("#nro_piso").val("");
    $("#nro_dpto").val("");

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
}

function cerrar() {
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiar();
    });
}

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
                alertify.alert('RESULTADO SATISFACTORIO', ['SE GUARDO EL PROVEEDOR!', 'NO SE PUDO GUARDAR LA DIRECCION']);
            } else if (datos == 3) {
                alertify.alert('RESULTAOO SATISFACTORIO', 'SE GUARDARON LOS DATOS CON EXITO');
            } else if (datos == 4) {
                alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON LOS DATOS CON EXITO');
            } else if (datos == 5) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO ACTUALIZAR');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiar();
}

// function mostrar(idmaterial) {
//     $.post("../ajax/material.php?op=mostrar", { id_material: idmaterial }, function(data, status) {
//         $("#title_material").text("Editar Material");
//         data = JSON.parse(data);
//         $("#id_material").val(data.id_material);
//         $("#nombre").val(data.nombre);
//     });
//     $("#cerrar").on("click", function() {
//         limpiar();
//     })
// }

function activar(idproveedor) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN ACTIVAR EL PROVEEDOR?",
        function() {
            $.post("../ajax/proveedor.php?op=activar", { id_proveedor: idproveedor }, function(e) {
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

function desactivar(idproveedor) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN DESACTIVAR EL PROVEEDOR?",
        function() {
            $.post("../ajax/proveedor.php?op=desactivar", { id_proveedor: idproveedor }, function(e) {
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
init();