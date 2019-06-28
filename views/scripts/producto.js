var tabla;

function init() {
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();
    });
    $("#formularioImagen").on("submit", function(e) {
        guardarImagen(e);
        cerrarformImagen();
    });
    //Cargamos los items al select categoria
    $.post("../ajax/producto.php?op=selectCategoria", function(r) {
        $("#categoria_id").html(r);
        $("#categoria_id").selectpicker('refresh');
    });
    $.post("../ajax/producto.php?op=selectMaterial", function(s) {
        $("#material_id").html(s);
        $("#material_id").selectpicker('refresh');
    })

}


//function para guardar imagenes y mande el Id del producto al que pertenence
function formImagen(idproducto) {

    $("#formularioImagen").ready(function() {
        $('#producto_id').val(idproducto);
    });
}
//deja limpio todos los campos al cerrar
function limpiar() {
    $("#title_product").text("Nuevo Producto");
    $("#id_producto").val("");
    $("#cod_producto").val("");
    $("#descripcion").val("");
    $("#stock").val("");
    $("#material_id").val("");
    $("#material_id").selectpicker('refresh');
    $("#categoria_id").val("");
    $("#categoria_id").selectpicker('refresh');
    $("#printbarcode").hide();
}

function limpiarimagen() {
    $("#file-1").val("");
    $("#file-1").selectpicker('refresh');
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
            url: '../ajax/producto.php?op=listar',
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
        $("#btnGuardarImagen").trigger("click");
        limpiar();
    })
}

function cerrarformImagen() {
    $("#formularioImagen").ready(function() {
        $("#cerrarformImagen").trigger("click");
        limpiarimagen();

    })
}

function guardarImagen(e) {
    e.preventDefault();
    var archivos = document.getElementById("file-1"); //Creamos un objeto con el elemento que contiene los archivos: el campo input file, que tiene el id = 'archivos'
    var archivo = archivos.files; //Obtenemos los archivos seleccionados en el imput
    //Creamos una instancia del Objeto FormDara.
    var archivos = new FormData($("#formularioImagen")[0]);
    /* Como son multiples archivos creamos un ciclo for que recorra la el arreglo de los archivos seleccionados en el input
    Este y añadimos cada elemento al formulario FormData en forma de arreglo, utilizando la variable i (autoincremental) como 
    indice para cada archivo, si no hacemos esto, los valores del arreglo se sobre escriben*/
    for (i = 0; i < archivo.length; i++) {
        archivos.append('archivo' + i, archivo[i]); //Añadimos cada archivo a el arreglo con un indice direfente
    }
    /*Ejecutamos la función ajax de jQuery*/
    $.ajax({
        url: '../ajax/producto.php?op=guardaryeditarImagen', //Url a donde la enviaremos
        type: 'POST', //Metodo que usaremos
        contentType: false, //Debe estar en false para que pase el objeto sin procesar
        data: archivos, //Le pasamos el objeto que creamos con los archivos
        processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
        cache: false, //Para que el formulario no guarde cache
        success: function(datos) {
            alertify.alert(datos);
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
}
//funcion para guardar nuevo y editado los productos
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/producto.php?op=guardaryeditar",
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
//function eliminar imagen 
function EliminarImagen(idimagen) {
    alertify.confirm("ATENCIÓN", "¿Esta segúro que quiere Eliminar la Imagen?", function() {
            $.post("../ajax/producto.php?op=EliminarImagen", { id_imagen: idimagen }, function(e) {
                if (e == 1) {
                    alertify.success('Se Eliminio con exito!');
                } else {
                    alertify.error('Hubo un error al Eliminar');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('Acción Cancelada')
        });
}
//funcion mostrar productos para editar
function mostrar(idproducto) {
    $.post("../ajax/producto.php?op=mostrar", { id_producto: idproducto },
        function(data, status) {
            $("#title_product").text("Editar Producto");
            data = JSON.parse(data);
            $("#id_producto").val(data.id_producto);
            $("#cod_producto").val(data.cod_producto);
            $("#descripcion").val(data.descripcion);
            $("#stock").val(data.stock);
            $("#material_id").val(data.material_id);
            $("#material_id").selectpicker('refresh');
            $("#categoria_id").val(data.categoria_id);
            $("#categoria_id").selectpicker('refresh');
            generarBarcode();
        });
    $("#cerrar").on("click", function() {
        limpiar();
    });
}
//function activar productos
function activar(idproducto) {
    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea activar el Producto?",
        function() {
            $.post("../ajax/producto.php?op=activar", { id_producto: idproducto }, function(e) {
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
//desactivar productos
function desactivar(idproducto) {
    alertify.confirm("ATENCIÓN", "¿Esta seguro que desea desactivar el Producto?",
        function() {
            $.post("../ajax/producto.php?op=desactivar", { id_producto: idproducto }, function(e) {
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
//Generar codigo de Barras
function generarBarcode() {
    $("#printbarcode").show();
    cod_producto = $("#cod_producto").val();
    JsBarcode('#barcode', cod_producto);
}
//funcion para imprimir codigo de barra
function printBarcode() {
    $('#printbarcode').printArea();
}
init();