function init() {
    $("#formulario_direccion").on("submit", function(e) {
        guardaryeditarDireccion(e);
        cerrardireccion();
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

function cerrardireccion() {
    $("#contactobtn").attr("enabled", true);
    $("#formulario_direccion").ready(function() {
        $("#cerrardireccion").trigger("click");

        limpiarDireccion();
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
//funcion para dar forma y mostrar la vista de direcciones de un proveedor
function mostrarDireccion(idpersona) {
    if (idpersona > 0) {
        $("#direccionbtn").attr("disabled", true);
        $("#contactobtn").attr("disabled", true);
    } else {
        $("#direccionbtn").attr("disabled", false);
        $("#contactobtn").attr("disabled", false);
    };
    var caja_contenido = $("#caja_contenido");
    var valor = "";
    $.post("../ajax/direccion.php?op=listar", { persona_id: idpersona }, function(data, status) {
        valor = JSON.parse(data);
        if (valor['aaData'].length == "") { //vericamos si existe direcciones para mostrar
            //si no existe direcciones para mostrar ***
            if (caja_contenido.is(":visible")) {
                caja_contenido.hide(); //oculto el contenido 
                $("#datos").remove(); //remuevo los datos mostrados
            } else {
                caja_contenido.show();
                $("#contenido_extra").append("<div id='datos'></div>");
                $("#title_mostrar_direccion").html('<div class="col-md-6"><b style="text-transform:uppercase;">NO HAY DIRECCIONES PARA MOSTRAR</b></div> <div class="col-md-6"><button onclick="mostrarDireccion(0)" class="btn btn-block btn-info"><i class="fa fa-chevron-circle-up"></i>  Cerrar</button></div>');
                $("#datos").append('<div class="col-md-12"><div class="col-md-6"><button  data-toggle="modal" data-target="#modal_direcciones" onclick="mandarid_direccion(' + idpersona + ')" class="btn btn-block btn-warning"><i class="fa fa-pencil"></i>Nueva Direccion</button></div> </br></br>'); //creo los divs
            }
        } else {
            //si existe direcciones para mostrar ****
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
        }

    })
}
init();