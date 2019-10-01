var tabla;

function init() {
    $("#divgrafico").hide();
    listar();
    $("#id_producto").change(listar);
    $.post("../ajax/producto.php?op=selectProducto", function(r) {
        $("#id_producto").html(r);
        $("#id_producto").selectpicker('refresh');
    });

}

function traerdatosgrafico(id_producto) {
    if (id_producto) {

        $.post("../ajax/producto.php?op=datosGrafico", { id_producto: id_producto }, function(datos, status) {
            datos = JSON.parse(datos);
            $("#titlebtn").html('<h1 class="box-title">HISTORIAL DE PRECIOS POR PRODUCTO <button type="button"  onclick="myFunction([' + datos[0]['fechas'] + '],[' + datos[0]['precios'] + '],[' + datos[0]['aumentoenteros'] + '],[' + datos[0]['aumentoporcentaje'] + '])" id="verGrafico" style="background-color:rgba(255,255,255, 0.6); border:none; color:rgba(255,255,255, 0.6);cursor:default;">V</button></h1>' +
                '<div class="box-tools pull-right"></div>')
            console.log([datos[0]['fechas']]);
            $("#verGrafico").show();
            $("#fechas").val(datos[0]['fechas']);
            $("#precios").val(datos[0]['aumentoenteros']);
            $("#verGrafico").trigger('click');


        });
    } else {
        console.log("no se selecciono ningun producto")
    }

}

function listar() {
    var id_producto = $("#id_producto option:selected").val();
    traerdatosgrafico(id_producto);
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
            'pdf'
        ],
        "ajax": {
            url: '../ajax/producto.php?op=aumentoProducto',
            data: { id_producto: id_producto },
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
    $(".dt-button.buttons-copy.buttons-html5").attr('id', 'botonCopia');
    $("#botonCopia").html('<span><i class="fa fa-copy"></i> Copia</span>');
    $(".dt-button.buttons-excel.buttons-html5").attr('id', 'botonExcel');
    $("#botonExcel").html('<span><i class="fa fa-file-excel-o"></i> Excel</span>');
    $("#botonExcel").css('color', 'white');
    $("#botonExcel").css('background', 'green');
    $(".dt-button.buttons-pdf.buttons-html5").attr('id', 'botonPdf');
    $("#botonPdf").html('<span><i class="fa fa-file-pdf-o"></i> PDF</span>');
    $("#botonPdf").css('color', 'white');
    $("#botonPdf").css('background', '#D33724');
}

init();