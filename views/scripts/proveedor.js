var tabla;

function init() {
    listar();
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
        cerrar();
    })
    $("#formulario_direccion").on("submit", function(e) {
        guardaryeditarDireccion(e);
        cerrardireccion();
    })
    $("#formulario_contacto").on("submit", function(e) {
        guardaryeditarContacto(e);
        cerrarContacto();
    })
}
//Funcion para mandar el ID en el modal
function mandarid_direccion(id) {
    if ($('input#persona_id').length) {
        $('#persona_id').val(id);
    } else {
        $("#formulario_direccion").append("<input type='hidden' id='persona_id' value='' name='persona_id'>");
        $("#persona_id").val(id);
    }
}

function mandarid_contacto(id) {
    if ($('input#persona_id').length) {
        $('#persona_id').val(id);
    } else {
        $("#formulario_contacto").append("<input type='hidden' id='persona_id' value='' name='persona_id'>");
        $("#persona_id").val(id);
    }
}
// //funcion para modificar el tipo de input segun el select elegido
// function verselect() {
//     $(document).ready(function() {
//         $("#laveltipocontacto").hide();
//         $("select[name=tp]").change(function() {
//             var data = $('select[name=tp]').val();
//             if (data === 'TELEFONO') {
//                 $("#laveltipocontacto").show();
//                 $("#laveltipocontacto").html('<i class="fa fa-phone"></i>');
//                 //verificar si ya existe el input para no volver a crear de nuevo
//                 if ($("#valor")[0]) {
//                     $("#valorinput").val('TELEFONO');
//                     $("#valor").prop('type', 'number');
//                 } else {
//                     $("#lugarboton").append('<input type="hidden" name="tipocontacto" value="TELEFONO" id="valorinput"><input type="text" id="valor" name="valor" class="form-control" required>');
//                     $("#valor").prop('type', 'number');
//                 }
//             } else if (data === 'CELULAR') {
//                 $("#laveltipocontacto").show();
//                 $("#valor").show();
//                 $("#laveltipocontacto").html('<i class="fa fa-mobile"></i>');
//                 //verificar si ya existe el input para no volver a crear de nuevo
//                 if ($("#valor")[0]) {
//                     $("#valorinput").val('CELULAR');
//                     $("#valor").prop('type', 'number');
//                 } else {
//                     $("#lugarboton").append('<input type="hidden" name="tipocontacto" value="CELULAR" id="valorinput"><input type="text" id="valor" name="valor" class="form-control" required>');
//                     $("#valor").prop('type', 'number');
//                 }
//             } else if (data === 'CORREO') {
//                 $("#laveltipocontacto").show();
//                 $("#valor").show();
//                 $("#laveltipocontacto").html('<i class="fa fa-at"></i>');
//                 //verificar si ya existe el input para no volver a crear de nuevo
//                 if ($("#valor")[0]) {
//                     $("#valorinput").val('CORREO');
//                     $("#valor").prop('type', 'email');
//                 } else {
//                     $("#lugarboton").append('<input type="hidden" name="tipocontacto" value="CORREO" id="valorinput"><input type="text" id="valor" name="valor" class="form-control" required>');
//                     $("#valor").prop('type', 'email');
//                 }
//             } else if (data === 'FAX') {
//                 $("#laveltipocontacto").show();
//                 $("#valor").show();
//                 $("#laveltipocontacto").html('<i class="fa fa-fax"></i>');
//                 //verificar si ya existe el input para no volver a crear de nuevo
//                 if ($("#valor")[0]) {
//                     $("#valorinput").val('FAX');
//                     $("#valor").prop('type', 'number');
//                 } else {
//                     $("#lugarboton").append('<input type="hidden" name="tipocontacto" value="CORREO" id="valorinput"><input type="text" id="valor" name="valor" class="form-control" required>');
//                     $("#valor").prop('type', 'number');
//                 }
//             }
//         });

//     });
// }
//function para agregar inputs de manera dinamica
// function sumarInput() {
//     $("select[name=tp]").val('0');
//     if ($("#valor").val().length == 0) {
//         alertify.alert('MENSAJE DE ALERTA!!', 'SELECCIONE UNA OPCION Y COMPLETE EL CAMPO PARA CONTINUAR');
//     } else {
//         $("#valor").prop('name', 'valor[]');
//         $("#valorinput").prop('name', 'tipocontacto[]');
//         $('span#laveltipocontacto').removeAttr('id');
//         $("input#valor").removeAttr('id');
//         $("#valorinput").removeAttr('id');
//         $("#divInput").append('<div class="input-group"><span class="input-group-addon" id="laveltipocontacto">-</span><input type="hidden" value="" name="tipocontacto[]" id="valorinput"><input class="form-control" name="valor[]" id="valor" type="text" placeholder="SELECCIONE TIPO DE CONTACTO" required><span id="quitar" class="input-group-btn"><button class="btn btn-danger" id="botonquitar" onclick="quitarInput()"><i class="fa fa-minus"></i></button></span></div>')
//     }

// }

// function quitarInput() {
//     var cantidad = $('div > span#quitar').length;
//     if (cantidad >= 1) {
//         $("#laveltipocontacto").remove();
//         $("#valor").remove();
//         $("#botonquitar").remove();

//     }
// }

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
//dejar los campos vacios
function limpiarProveedor() {
    $("#title_proveedor").text("Nuevo Proveedor");
    $("#id_proveedor").val("");
    $("#persona_id").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#razonsocial").val("");
    $("#nro_doc").val("");
    $("#fecha_nac").val("");
}

function limpiarDireccion() {
    $('#persona_id').remove();
    $('#provincia').val("");
    $('#localidad').val("");
    $("#barrio").val("");
    $("#calle").val("");
    $("#manzana").val("");
    $("#altura").val("");
    $("#nro_piso").val("");
    $("#nro_dpto").val("");
    $('#info_add').val("");
}

function cerrardireccion() {
    $("#formulario_direccion").ready(function() {
        $("#cerrardireccion").trigger("click");
        limpiarDireccion();
    });
}

function cerrar() {
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiarProveedor();
    });
}

function guardaryeditarDireccion(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario_direccion")[0]);
    $.ajax({
        url: "../ajax/direccion.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            // if (datos == 0) {
            //     alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA PERSONA! ');
            // } else if (datos == 1) {
            //     alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR EL PROVEEDOR');
            // } else if (datos == 2) {
            //     alertify.alert('RESULTAOO SATISFACTORIO', 'SE GUARDARON LOS DATOS CON EXITO');
            // } else if (datos == 3) {
            //     alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON LOS DATOS CON EXITO');
            // } else if (datos == 4) {
            //     alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO ACTUALIZAR');
            // }
            alertify.alert(datos);
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiarDireccion();
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
                alertify.alert('RESULTAOO SATISFACTORIO', 'SE GUARDARON LOS DATOS CON EXITO');
            } else if (datos == 3) {
                alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON LOS DATOS CON EXITO');
            } else if (datos == 4) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO ACTUALIZAR');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiarProveedor();
}

function mostrar(idproveedor) {
    $.post("../ajax/proveedor.php?op=mostrar", { id_proveedor: idproveedor }, function(data, status) {
        $("#title_proveedor").text("Editar Proveedor");
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

function mostrarDireccionEditar(iddireccion) {
    $.post("../ajax/direccion.php?op=mostrar", { id_direccion: iddireccion }, function(data, status) {
        $("#title_direccion").text("Editar Direccion");
        data = JSON.parse(data);
        $("#id_direccion").val(data.id_direccion);
        $("#persona_id").val("");
        $('#provincia').val(data.provincia);
        $('#localidad').val(data.localidad);
        $("#barrio").val(data.barrio);
        $("#calle").val(data.calle);
        $("#manzana").val(data.manzana);
        $("#altura").val(data.altura);
        $("#nro_piso").val(data.nro_piso);
        $("#nro_dpto").val(data.nro_dpto);
        $('#info_add').val(data.info_add);
    });
    $("#cerrardireccion").on("click", function() {
        limpiarDireccion();
    })
}

function mostrarDireccion(idpersona) {
    var caja_contenido = $("#caja_contenido");
    $.post("../ajax/direccion.php?op=listar", { persona_id: idpersona }, function(data, status) {

        //verifico si esta visible la caja de contenido
        if (caja_contenido.is(":visible")) {
            caja_contenido.hide(); //oculto el contenido 
            $("#datos").remove(); //remuevo los datos mostrados
        } else {
            caja_contenido.show(); //muestro el contenido

            $("#contenido_extra").append("<div id='datos'></div>"); //creo una caja donde mostrara los datos

            $.each(JSON.parse(data), function(i, item) {
                var cantidad = item.length;
                if (cantidad > 1) {
                    $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">DIRECCIONES DE  ' + item[0][11] + ' ' + item[0][12] + '</b></div> <div class="col-md-6"><button onclick="mostrarDireccion(0)" class="btn btn-block btn-danger"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                } else {
                    $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">DIRECCION DE  ' + item[0][11] + ' ' + item[0][12] + '</b></div> <div class="col-md-6"><button onclick="mostrarDireccion(0)" class="btn btn-block btn-danger"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                }

                for (var a = 0; a < cantidad; a++) {
                    var num = a + 1;

                    $("#datos").append('<h2 style="font-weight: bold;">DIRECCION ' + num + '</h2>' + '<div name="provincia" id="provincia" class="col-md-4"></div><div name="localidad" id="localidad" class="col-md-4"></div><div name="barrio" id="barrio" class="col-md-4"></div><div name="calle" id="calle" class="col-md-4"></div><div name="manzana" id="manzana" class="col-md-4"></div><div name="altura" id="altura" class="col-md-4"></div><div name="nro_piso" id="nro_piso" class="col-md-4"></div><div name="nro_dpto" id="nro_dpto" class="col-md-4"></div><div name="info_add" id="info_add" class="col-md-4"></div><button  data-toggle="modal" data-target="#modal_direcciones" class="btn btn-block btn-warning" onclick="mostrarDireccionEditar(' + item[a][0] + ')"><i class="fa fa-pencil"></i> Editar</button> <br><br>'); //creo los divs

                    $("#provincia").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">PROVINCIA: </b>' + item[a][1] + '</h4>'); //muestro los datos

                    $("#localidad").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">LOCALIDAD: </b>' + item[a][2] + '</h4>'); //muestro los datos

                    $("#barrio").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">BARRIO: </b>' + item[a][3] + '</h4>'); //muestro los datos   

                    $("#calle").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">CALLE: </b>' + item[a][4] + '</h4>'); //muestro los datos

                    $("#manzana").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">MANZANA: </b>' + item[a][5] + '</h4>'); //muestro los datos

                    $("#altura").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">ALTURA: </b>' + item[a][6] + '</h4>'); //muestro los datos

                    $("#nro_piso").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">nro_piso: </b>' + item[a][7] + '</h4>'); //muestro los datos

                    $("#nro_dpto").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">nro_dpto: </b>' + item[a][8] + '</h4>'); //muestro los datos

                    $("#info_add").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">info_add: </b>' + item[a][9] + '</h4>'); //muestro los datos 

                    $("#provincia").prop('id', '');
                    $("#localidad").prop('id', '');
                    $("#barrio").prop('id', '');
                    $("#calle").prop('id', '');
                    $("#manzana").prop('id', '');
                    $("#altura").prop('id', '');
                    $("#nro_piso").prop('id', '');
                    $("#nro_dpto").prop('id', '');
                    $("#info_add").prop('id', '');
                }

            });


        }
    })
}
init();