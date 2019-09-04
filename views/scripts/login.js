$("#frmAceeso").on('submit', function(e) {
    e.preventDefault();
    var loginA = $("#loginA").val();
    var claveA = $("#claveA").val();
    $.post("../ajax/usuario.php?op=verificar", { "loginA": loginA, "claveA": claveA }, function(data) {
        if (data == "    no existe este usuario") {
            alertify.alert("RESULTADO INCONCLUSO", "EL USUARIO INGRESADO NO EXISTE");
            return false;
        } else if (data == "    clave incorrecta") {
            alertify.alert("RESULTADO INCONCLUSO", " LA CONTRASEÑA INGRESADA NO ES CORRECTA");
            return false;
        } else {
            data = JSON.parse(data);
            var id_usuario = data.id_usuario;
            $.post("../ajax/usuario.php?op=permisoUser", { id_usuario: id_usuario }, function(datos) {
                datos = JSON.parse(datos);
                for (let index = 0; index < datos.length; index++) {

                    switch (datos[0][index]) {
                        case "1":
                            $(location).attr("href", "escritorio.php");
                            break;
                        case "2":
                            $(location).attr("href", "index_producto.php");
                            break;
                        case "3":
                            $(location).attr("href", "index_compras.php");
                            break;
                        case "4":
                            $(location).attr("href", "index_ventas.php");
                            break;
                        case "5":
                            $(location).attr("href", "index_usuario.php");
                            break;
                        case "6":
                            $(location).attr("href", "compras_fecha.php");
                            break;
                        case "7":
                            $(location).attr("href", "ventas_fecha.php");
                            break;
                    }
                }
            });

        }
    });
})