var tabla;
var cargardenuevo = '<div id="eliminarclave1">' +
    '<div class="form-group">' +
    '<label class="col-sm-4 col-sm-4 control-label">CONTRASEÑA (*)</label>' +
    '<div class="col-sm-8">' +
    '<input type="password" name="clave1" id="clave1" class="form-control"  required >' +
    '</div>' +
    '</div>' +
    '</div>' +
    '<div id="eliminarclave2">' +
    '<div class="form-group">' +
    '<label class="col-sm-4 col-sm-4 control-label">CONFIRMAR CONTRASEÑA (*)</label>' +
    '<div class="col-sm-8">' +
    '<input type="password" name="clave2" id="clave2" class="form-control" required>' +
    '</div>' +
    '</div>' +
    '</div>';
var cargarSelectMultple = '<div class="form-group" id="eliminarselect">' +
    '<label class="col-sm-4 col-sm-4 control-label">PERMISOS (*)</label>' +
    '<div class="col-sm-8">' +
    '<select multiple class="form-control" name="permiso[]" id="permiso_id">' +
    '</select>' +
    '</div>' +
    '</div>';

function init() {

    listar();
    //funcion para ver si hay cambios en el imput IMG para mostrar la imagen 
    $("#file-1").change(function() {
        filePreview(this);
    });
    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);

    })
    $("#formulario_Pass").on('submit', function(e) {
            actualizarPass(e);
        })
        // $("#permiso_id").chosen({
        //     placeholder_text_multiple: "Seleccione al menos 1 permiso",
        //     width: "100%"
        // });

}
//funcion para realizar preview de la imagen ,antes de guardar
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {

            if ($("#span").val() == "Seleccionar archivo") {
                $('#img_user').remove();
                var valor = $("#imagen").val();
                $('#cargarimagen').append('<img id="img_user" src="../files/images/usuarios/' + valor + '" width="150" height="100"/>');
            } else {
                $('#img_user').remove();
                $('#cargarimagen').append('<img id="img_user" src="' + e.target.result + '" width="150" height="100"/>');
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
//funcion para agregar los permisos de los usuarios
function agregarselect() {
    $(cargarSelectMultple).insertAfter($("#cargodiv"));
    $.post("../ajax/usuario.php?op=selectPermisos", function(s) {
        $("#permiso_id").append(s).chosen({
            placeholder_text_multiple: "Seleccione al menos 1 permiso",
            width: "100%"
        });
    });
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
            url: '../ajax/usuario.php?op=listar',
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
function limpiar() {
    $("#title_proveedor").text("NUEVO PROVEEEDOR");
    $("#id_usuario").remove();
    $("#eliminarselect").remove();
    $("#persona_id").val("");
    $("#nombres").val("");
    $("#apellidos").val("");
    $("#nro_doc").val("");
    $("#fecha_nac").val("");
    $("#nombre_usuario").val("");
    $("#cargo").val("");
    $("#img_user").remove();
    if ($("#clave1").length) {
        $("#clave1").val("");
        $("#clave2").val("");
    } else {
        $(cargardenuevo).insertAfter($("#nombreuser"));
    }
}

//dejar los campos vacios del formulario de password
function limpiarPass() {
    $("#clave111").prop('id', 'clave1');
    $("#clave222").prop('id', 'clave2');
    $("#remove").remove();
}

function cerrar() {
    $("#formulario").ready(function() {
        $("#cerrar").trigger("click");
        limpiar();
    });
}

function cerrarPass() {
    $("#formulario_Pass").ready(function() {
        $("#cerrarPass").trigger("click");
        limpiarPass();
    });
}

function actualizarPass(e) {
    e.preventDefault();
    var pass1 = $('#clave1').val();
    var pass2 = $('#clave2').val();
    if (pass1 != pass2) {
        var span = $('<span id="spanmnj" style="color:red;font-weight:bold"></span>').insertAfter($("#clave2"));
        span.show();
        span.text("No coinciden las contraseñas");
        $("#clave1").css('border', '2px solid red');
        $("#clave2").css('border', '2px solid red');
        e.preventDefault();
    } else if (pass1.length < 6 || pass1.length > 10) {
        var span = $('<span id="spanmnj" style="color:red;font-weight:bold"></span>').insertAfter($("#clave2"));
        span.show();
        span.text("La contraseña debe estar formada entre 6-10 carácteress");
        $("#clave1").css('border', '2px solid red');
        $("#clave2").css('border', '2px solid red');
        e.preventDefault();
    } else {
        var formData = new FormData($("#formulario_Pass")[0]);
        $.ajax({
            url: "../ajax/usuario.php?op=verificarPass",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos) {
                if (datos == 0) {
                    var span = $('<span style="color:red;font-weight:bold"></span>').insertAfter($("#clave"));
                    span.show();
                    span.text("La contraseña anterior no es la correcta");
                    $("#clave").css('border', '2px solid red');
                    e.preventDefault();
                } else if (datos == 1) {
                    cerrarPass();
                    alertify.alert('RESULTADO SATISFACTORIO', 'CONTRASEÑA ACTUALIZADA');
                }
            }
        });
    }
}

//funcion para guardar y editar el usuario
function guardaryeditar(e) {
    e.preventDefault();
    //validamos las contraseñas
    if ($("#clave").length) {
        var pass1 = $('#clave1').val();
        var pass2 = $('#clave2').val();
        if (pass1 != pass2) {
            var span = $('<span style="color:red;font-weight:bold"></span>').insertAfter($("#clave2"));
            span.show();
            span.text("No coinciden las contraseñas");
            $("#clave1").css('border', '2px solid red');
            $("#clave2").css('border', '2px solid red');
            e.preventDefault();
        } else if (pass1.length < 6 || pass1.length > 10) {
            var span = $('<span style="color:red;font-weight:bold"></span>').insertAfter($("#clave2"));
            span.show();
            span.text("La contraseña debe estar formada entre 6-10 carácteress");
            $("#clave1").css('border', '2px solid red');
            $("#clave2").css('border', '2px solid red');
            e.preventDefault();
        } else {
            var formData = new FormData($("#formulario")[0]);
            $.ajax({
                url: "../ajax/usuario.php?op=guardaryeditar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function(datos) {
                    alert(datos);
                    if (datos == 0) {
                        alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA PERSONA! ');
                    } else if (datos == 1) {
                        alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR EL USUARIO');
                    } else if (datos == 2) {
                        alertify.alert('RESULTAOO SATISFACTORIO', 'SE GUARDARON TODOS LOS DATOS CON EXITO');
                    } else if (datos == 3) {
                        alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON TODOS LOS DATOS CON EXITO');
                    }

                    $('#tablalistado').dataTable().api().ajax.reload();
                }
            });
            cerrar();
        }
    } else {
        //editar usuario
        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/usuario.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos) {
                if (datos == 0) {
                    alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA PERSONA! ');
                } else if (datos == 1) {
                    alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR EL USUARIO');
                } else if (datos == 2) {
                    alertify.alert('RESULTAOO SATISFACTORIO', 'SE GUARDARON TODOS LOS DATOS CON EXITO');
                } else if (datos == 3) {
                    alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON TODOS LOS DATOS CON EXITO');
                }

                $('#tablalistado').dataTable().api().ajax.reload();
            }
        });
        cerrar();
    }
    // fin de validacion de contraseña
}

//funcion para mostrar el proveedor a la hora de editar
function mostrar(idusuario) {
    $.post("../ajax/usuario.php?op=mostrar", { id_usuario: idusuario }, function(data, status) {
        $("#title_usuario").text("EDITAR USUARIO");
        $("#eliminarclave1").remove();
        $("#eliminarclave2").remove();
        $("#eliminarselect").remove();
        data = JSON.parse(data);
        $("#formulario").append('<input type="hidden" name="id_usuario" id="id_usuario"><input type="hidden" id="imagen_anterior" name="imagen_anterior" value="' + data.imagen_usuario + '">');
        $("#id_usuario").val(data.id_usuario);
        $("#persona_id").val(data.id_persona);
        $("#nombres").val(data.nombres);
        $("#apellidos").val(data.apellidos);
        $("#nro_doc").val(data.nro_doc);
        $("#fecha_nac").val(data.fecha_nac);
        $("#nombre_usuario").val(data.nombre_usuario);
        $("#cargo").val(data.cargo);
        $("#cargarimagen").append('<img id="img_user" src="../files/images/usuarios/' + data.imagen_usuario + '" width="150" height="100">');
    });
    $.post("../ajax/usuario.php?op=selectPermisos", { id_usuario: idusuario }, function(data, status) {
        $(cargarSelectMultple).insertAfter($("#cargodiv"));
        $("#permiso_id").append(data).chosen({
            placeholder_text_multiple: "Seleccione al menos 1 permiso",
            width: "100%"
        });
    });
    $("#cerrar").on("click", function() {
        limpiar();
    })
}

function mostrarFormPass(idusuario) {
    $("#title_proveedor").text("EDITAR CONTRASEÑA");
    $("#clave1").prop('id', 'clave111');
    $("#clave2").prop('id', 'clave222');
    $("#formulario_Pass").append(
        '<div id="remove">' +
        '<input type="hidden" name="id_usuario" id="id_usuario" value="' + idusuario + '">' +
        '<div class="form-group">' +
        '<label class="col-sm-3 col-sm-3 control-label">CONTRASEÑA ANTERIOR (*)</label>' +
        '<div class="col-sm-9">' +
        '<input type="password" name="clave" id="clave" class="form-control" required>' +
        '</div>' +
        '</div>' +
        '<div class="form-group">' +
        '<label class="col-sm-3 col-sm-3 control-label">CONTRASEÑA ACTUAL (*)</label>' +
        '<div class="col-sm-9">' +
        '<input type="password" name="clave1" id="clave1" class="form-control" required>' +
        '</div>' +
        '</div>' +
        '<div class="form-group">' +
        '<label class="col-sm-3 col-sm-3 control-label">CONFIRMAR CONTRASEÑA (*)</label>' +
        '<div class="col-sm-9">' +
        '<input type="password" name="clave2" id="clave2" class="form-control"  required>' +
        '</div>' +
        '</div></div>');
}

function activar(idusuario) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN ACTIVAR EL PROVEEDOR?",
        function() {
            $.post("../ajax/usuario.php?op=activar", { id_usuario: idusuario }, function(e) {
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

function desactivar(idusuario) {
    alertify.confirm("ATENCIÓN", "¿ESTA SEGURO EN DESACTIVAR EL usuario?",
        function() {
            $.post("../ajax/usuario.php?op=desactivar", { id_usuario: idusuario }, function(e) {
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