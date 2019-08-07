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
            $(location).attr("href", "index_categoria.php");
        }
    });
})