var tabla;

function init() {
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();
    })
}

function limpiar() {
    $("#title_material").text("Nuevo Material");
    $("#id_material").val("");
    $("#nombre").val("");
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
            url: '../ajax/material.php?op=listar',
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
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiar();
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/material.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

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
    limpiar();
}

function mostrar(idmaterial) {
    $.post("../ajax/material.php?op=mostrar", { id_material: idmaterial }, function(data, status) {
        $("#title_material").text("Editar Material");
        data = JSON.parse(data);
        $("#id_material").val(data.id_material);
        $("#nombre").val(data.nombre);
    });
    $("#cerrar").on("click", function() {
        limpiar();
    })
}

function activar(idmaterial) {
    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea activar el Material?",
        function() {
            $.post("../ajax/material.php?op=activar", { id_material: idmaterial }, function(e) {
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

function desactivar(idmaterial) {
    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea desactivar el Material?",
        function() {
            $.post("../ajax/material.php?op=desactivar", { id_material: idmaterial }, function(e) {
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