function init() {
    $("#fCliente").on("submit", function(f) {
        guardarCliente(f);
        cerrarCliente();
    })
}

function formcliente() {


}

function cerrarCliente() {
    $("#fCliente").ready(function() {
        $("#cerrarCliente").trigger("click");
    })
    eliminarFormCliente();
}

function eliminarFormCliente() {
    $("#eliminarformcliente").remove();
}

function guardarCliente(f) {
    f.preventDefault();
    var formData = new FormData($("#fCliente")[0]);
    $.ajax({
        url: "../ajax/cliente.php?op=guardarClienteVenta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            if (datos == 0) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR LA PERSONA! ');
            } else if (datos == 1) {
                alertify.alert('RESULTADO INCONCLUSO', 'NO SE PUDO GUARDAR AL CLIENTE!');
            } else if (datos == 2) {
                alertify.alert('RESULTADO SATISFACTORIO', 'SE GUARDARON LOS DATOS DEL CLIENTE CON EXITO!');
            } else if (datos == 3) {
                alertify.alert('RESULTADO SATISFACTORIO', ' SE ACTUALIZARON LOS DATOS CON EXITO!');
            }
            $.post("../ajax/venta.php?op=selectCliente", function(r) {
                $("#cliente_id").html(r);
                $("#cliente_id").selectpicker('refresh');
            });
        }
    });

    eliminarFormCliente();

}


init();