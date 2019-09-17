var tabla;

function init() {
    listar();
    $("#fechaInicio").change(listar);
    $("#fechaFin").change(listar);

}

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */
    var zero = "0"; /* String de cero */

    if (width <= length) {
        if (number < 0) {
            return ("-" + numberOutput.toString());
        } else {
            return numberOutput.toString();
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString());
        }
    }
}

function listar() {
    var fechaInicio = $("#fechaInicio").val();
    var fechaFin = $("#fechaFin").val();
    var newdateInicio = fechaInicio.split("-").reverse().join("-");
    var newdateFin = fechaFin.split("-").reverse().join("-");
    var f = new Date();
    var fechahoy = f.getFullYear() + "-" + zfill((f.getMonth() + 1), 2) + "-" + zfill(f.getDate(), 2);
    if (fechaFin > fechahoy) {
        alertify.alert('CUIDADO!!', 'NO PUEDES SELECCIONAR UNA FECHA MAYOR A LA ACTÚAL!!', function() {
            $("#fechaFin").val(fechahoy);
        });
        return false;
    }
    if (fechaInicio > fechahoy) {
        alertify.alert('CUIDADO!!', 'NO PUEDES SELECCIONAR UNA FECHA MAYOR A LA ACTÚAL!!', function() {
            $("#fechaInicio").val(fechahoy);
        });
        return false;
    }
    if (fechaFin < fechaInicio) {
        alertify.alert("LA FECHA INICIAL NO PUEDE SER MENOR A LA FECHA FINAL!!");
        $("#fechaInicio").val(fechahoy);
        $("#fechaFin").val(fechahoy);
        return false;
    } else {
        console.log("fecha valida")
    }

    $("#textofecha").text('Total de Ventas diario desde ' + newdateInicio + ' hasta ' + newdateFin);

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
            url: '../ajax/consulta.php?op=ventasFecha',
            data: { fechaInicio: fechaInicio, fechaFin: fechaFin },
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
    $.post("../ajax/consulta.php?op=ventasFechaGrafico", { fechaInicio: fechaInicio, fechaFin: fechaFin }, function(data, status) {
        datas = JSON.parse(data);
        $("#titlebtn").html('<h1 class="box-title">CONSULTA DE VENTAS <button type="button" style="background-color:rgba(255,255,255, 0.6); border:none; color:rgba(255,255,255, 0.6);cursor:default;" onclick="myFunction([' + datas[0]['fechaV'] + '],[' + datas[0]['totalesV'] + '])" id="verGrafico">Ver Grafico</button></h1>' +
            '<div class="box-tools pull-right"></div>')
        $('#verGrafico').trigger('click');
    });
}
init();