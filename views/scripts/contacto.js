//funcion inicial
function init() {
    $("#formulario_contacto").on("submit", function(e) {
        guardaryeditarContacto(e);
        cerrarcontacto();
    })
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

function limpiarContacto() {
    $("#id_contacto").val("");
    $("#persona_id_contacto").remove();
    $("#telefono").val('');
    $("#celular").val('');
    $("#email").val('');
    $("#fax").val('');
}

function cerrarcontacto() {
    $("#formulario_contacto").ready(function() {
        $("#cerrarcontacto").trigger("click");
        limpiarContacto();
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

function mostrarContacto(idpersona) {
    if (idpersona > 0) {
        $("#direccionbtn").attr("disabled", true);
        $("#contactobtn").attr("disabled", true);
    } else {
        $("#direccionbtn").attr("disabled", false);
        $("#contactobtn").attr("disabled", false);
    };
    var caja_contenido = $("#caja_contenido");
    var valor = "";
    $.post("../ajax/contacto.php?op=listar", { persona_id: idpersona }, function(data, status) {
        valor = JSON.parse(data);
        if (valor['aaData'].length == "") { //vericamos si existe contactos para mostrar
            //si no existe contactos para mostrar****
            //verifico si esta visible la caja de contenido

            if (caja_contenido.is(":visible")) {
                caja_contenido.hide(); //oculto el contenido 
                $("#datos").remove(); //remuevo los datos mostrados
            } else {
                caja_contenido.show(); //muestro el contenido
                $("#contenido_extra").append("<div id='datos'></div>"); //creo una caja donde mostrara los datos
                $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">NO HAY CONTACTOS PARA MOSTRAR</b></div> <div class="col-md-6"><button onclick="mostrarContacto(0)" class="btn btn-block btn-info"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');

                $("#datos").append('<div class="col-md-12"><div class="col-md-6"><button  data-toggle="modal" data-target="#modal_contacto" onclick="mandarid_contacto(' + idpersona + ')" class="btn btn-block btn-warning"><i class="fa fa-pencil"></i>Nuevo Contacto</button></div> </br></br>'); //creo los divs
            }
        } else {
            //si no existe contactos para mostrar***
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
        }

    })
}
init();