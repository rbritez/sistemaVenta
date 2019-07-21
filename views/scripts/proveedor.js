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
        cerrarcontacto();
    })
}
//Funcion para mandar el ID en el modal
function mandarid_direccion(id) {
    if ($('input#persona_iddd').length) {
        $('#persona_iddd').val(id);
    } else {
        $("#formulario_direccion").append("<input type='hidden' id='persona_iddd' value='' name='persona_id'>");
        $("#persona_iddd").val(id);
    }
}
//Funcion para mandar el ID en el modal
function mandarid_contacto(id) {
    if ($('input#persona_id_contacto').length) { //verifico si existe el campo , si existe cargo el dato , sino creo uno nuevo 
        $('#persona_id_contacto').val(id);
    } else {
        $("#formulario_contacto").append("<input type='hidden' id='persona_id_contacto' name='persona_id'>");
        $("#persona_id_contacto").val(id);
    }
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

function limpiarDireccion() {
    $("#id_direccion").val("");
    $("#persona_iddd").val("");
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

function limpiarContacto() {
    $("#id_contacto").val("");
    $("#persona_id_contacto").remove();
    $("#telefono").val('');
    $("#celular").val('');
    $("#email").val('');
    $("#fax").val('');
}

function cerrardireccion() {
    $("#formulario_direccion").ready(function() {
        $("#cerrardireccion").trigger("click");
        limpiarDireccion();
    });
}

function cerrarcontacto() {
    $("#formulario_contacto").ready(function() {
        $("#cerrarcontacto").trigger("click");
        limpiarContacto();
    });
}

function cerrar() {
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiarProveedor();
    });
}
//guardar y editar la direccion 
function guardaryeditarDireccion(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario_direccion")[0]);
    var idpersonaDireccion = $("#persona_iddd").val();
    $.ajax({
        url: "../ajax/direccion.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 0) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA DIRECCION! ');
            } else if (datos == 1) {
                alertify.alert('RESULTADO SATISFACTORIO', 'SE GUARDARON LOS DATOS DE LA DIRECCION CON EXITO!');
            } else if (datos == 2) {
                alertify.alert('RESULTAOO SATISFACTORIO', 'SE ACTUALIZARON LOS DATOS DE LA DIRECCION EXITO!');
                mostrarDireccion();
                mostrarDireccion(idpersonaDireccion);
            } else if (datos == 3) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO ACTUALIZAR LOS DATOS DE LA DIRECCION');
            }
            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiarDireccion();
}
//funcion para eliminar la direccion
function eliminarDireccion(iddireccion) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN ELIMINAR ESTA DIRECCION?",
        function() {
            $.post("../ajax/direccion.php?op=eliminar", { id_direccion: iddireccion }, function(e) {
                if (e = 1) {
                    alertify.success('SE ELIMINO CON EXITO!');
                    mostrarDireccion(0);
                } else {
                    alertify.error('HUBO UN ERROR AL INTENTAR ELIMINAR');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('ACCION CANCELADA');
        });
}
//funcion para eliminar el contacto
function eliminarContacto(idcontacto) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN ELIMINAR EL CONTACTO?",
        function() {
            $.post("../ajax/contacto.php?op=eliminar", { id_contacto: idcontacto }, function(e) {
                if (e = 1) {
                    alertify.success('SE ELIMINO EL CONTACTO CON EXITO!');
                    mostrarContacto(0);
                } else {
                    alertify.error('HUBO UN ERROR AL INTENTAR ELIMINAR');
                }
                $('#tablalistado').dataTable().api().ajax.reload();
            });
        },
        function() {
            alertify.error('ACCION CANCELADA');
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

function guardaryeditarContacto(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario_contacto")[0]);
    var idpersonaContacto = $("#persona_id_contacto").val();
    $.ajax({
        url: "../ajax/contacto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 0) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LOS DATOS DEL CONTACTO! ');
            } else if (datos == 1) {
                alertify.alert('RESULTADO SATISFACTORIO', 'SE GUARDARDO LOS DATOS DEL CONTACTO CON EXITO!');
            } else if (datos == 2) {
                alertify.alert('RESULTAOO SATISFACTORIO', 'SE ACTUALIZARON LOS DATOS DEL CONTACTO CON EXITO');
                mostrarContacto();
                mostrarContacto(idpersonaContacto);

            } else if (datos == 3) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE ACTUALIZARON LOS DATOS');
            }

            $('#tablalistado').dataTable().api().ajax.reload();
        }
    });
    limpiarContacto();
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
//datos que van al modal para ser editados
function mostrarDireccionEditar(iddireccion) {
    $.post("../ajax/direccion.php?op=mostrar", { id_direccion: iddireccion }, function(data, status) {
        $("#title_direccion").text("EDITAR DIRECCION");
        $("#formulario_direccion").append('<input type="hidden" id="persona_iddd" name="persona_id">');
        data = JSON.parse(data);
        $("#id_direccion").val(data.id_direccion);
        $('#provincia').val(data.provincia);
        $('#localidad').val(data.localidad);
        $("#barrio").val(data.barrio);
        $("#calle").val(data.calle);
        $("#manzana").val(data.manzana);
        $("#altura").val(data.altura);
        $("#nro_piso").val(data.nro_piso);
        $("#nro_dpto").val(data.nro_dpto);
        $('#info_add').val(data.info_add);
        $("#persona_iddd").val(data.persona_id);
    });
    $("#cerrardireccion").on("click", function() {
        limpiarDireccion();
    })
}
//datos que van al modal para ser editados
function mostrarContactoEditar(idcontacto) {
    $.post("../ajax/contacto.php?op=mostrar", { id_contacto: idcontacto }, function(data, status) {
        $("#title_contacto").text("EDITAR CONTACTO");
        data = JSON.parse(data);
        $("#id_contacto").val(data.id_contacto);
        $('#telefono').val(data.telefono);
        $('#celular').val(data.celular);
        $("#email").val(data.email);
        $("#fax").val(data.fax);
        $("#formulario_contacto").append('<input type="hidden" id="persona_id_contacto" name="persona_id">');
        $("#persona_id_contacto").val(data.persona_id);
    });
    $("#cerrardireccion").on("click", function() {
        limpiarDireccion();
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

function mostrarContacto(idpersona) {
    var caja_contenido = $("#caja_contenido");
    $.post("../ajax/contacto.php?op=listar", { persona_id: idpersona }, function(data, status) {
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
                    $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">CONTACTOS DE  ' + item[0][6] + ' ' + item[0][7] + '</b></div> <div class="col-md-6"><button onclick="mostrarContacto(0)" class="btn btn-block btn-info"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                } else {
                    $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">CONTACTO DE  ' + item[0][6] + ' ' + item[0][7] + '</b></div> <div class="col-md-6"><button onclick="mostrarContacto(0)" class="btn btn-block btn-info"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                }
                for (var a = 0; a < cantidad; a++) {
                    var num = a + 1;

                    $("#datos").append('<div class="col-md-12"><h2 style="font-weight: bold;">CONTACTO ' + num + '</h2></div>' + '<div name="telefono" id="telefono" class="col-md-3"></div>' + '<div name="celular" id="celular" class="col-md-3"></div>' + '<div name="email" id="email" class="col-md-3"></div>' + '<div name="fax" id="fax" class="col-md-3"></div>' + '<div class="col-md-12"><div class="col-md-6"><button  data-toggle="modal" data-target="#modal_contacto" class="btn btn-block btn-warning" onclick="mostrarContactoEditar(' + item[a][0] + ')"><i class="fa fa-pencil"></i> Editar</button></div><div class="col-md-6"><button class="btn btn-block btn-danger" onclick="eliminarContacto(' + item[a][0] + ')"><i class="fa fa-trash"></i> Eliminar</button></div></div> </br></br>'); //creo los divs

                    $("#telefono").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">TELEFONO: </b>' + item[a][1] + '</h4>'); //muestro los datos
                    $("#celular").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">CELULAR: </b>' + item[a][2] + '</h4>'); //muestro los datos
                    $("#email").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">EMAIL: </b>' + item[a][3] + '</h4>'); //muestro los datos   
                    $("#fax").html('<h4 style="text-transform:uppercase"><b style="font-weight:bold">FAX: </b>' + item[a][4] + '</h4>'); //muestro los datos

                    $("#telefono").prop('id', '');
                    $("#celular").prop('id', '');
                    $("#email").prop('id', '');
                    $("#fax").prop('id', '');
                }
            });
        }
    })
}
//funcion para dar forma y mostrar la vista de direcciones de un proveedor
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
                    $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">DIRECCIONES DE  ' + item[0][11] + ' ' + item[0][12] + '</b></div> <div class="col-md-6"><button onclick="mostrarDireccion(0)" class="btn btn-block btn-info"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                } else {
                    $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">DIRECCION DE  ' + item[0][11] + ' ' + item[0][12] + '</b></div> <div class="col-md-6"><button onclick="mostrarDireccion(0)" class="btn btn-block btn-info"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                }
                for (var a = 0; a < cantidad; a++) {
                    var num = a + 1;

                    $("#datos").append('<div class="col-md-12"><h2 style="font-weight: bold;">DIRECCION ' + num + '</h2></div>' + '<div name="provincia" id="provincia" class="col-md-4"></div><div name="localidad" id="localidad" class="col-md-4"></div><div name="barrio" id="barrio" class="col-md-4"></div><div name="calle" id="calle" class="col-md-4"></div><div name="manzana" id="manzana" class="col-md-4"></div><div name="altura" id="altura" class="col-md-4"></div><div name="nro_piso" id="nro_piso" class="col-md-4"></div><div name="nro_dpto" id="nro_dpto" class="col-md-4"></div><div name="info_add" id="info_add" class="col-md-4"></div><div class="col-md-12"><div class="col-md-6"><button  data-toggle="modal" data-target="#modal_direcciones" class="btn btn-block btn-warning" onclick="mostrarDireccionEditar(' + item[a][0] + ')"><i class="fa fa-pencil"></i> Editar</button></div><div class="col-md-6"><button class="btn btn-block btn-danger" onclick="eliminarDireccion(' + item[a][0] + ')"><i class="fa fa-trash"></i> Eliminar</button></div></div> </br></br>'); //creo los divs

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