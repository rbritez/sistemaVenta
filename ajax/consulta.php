<?php
    require_once "../models/Consultas.php";
    $consulta = new Consultas();

    switch($_GET["op"]){
        case 'comprasFecha':
            $fechaInicio = $_REQUEST["fechaInicio"];
            $fechaFin = $_REQUEST["fechaFin"];
            $respuesta = $consulta->comprasFecha($fechaInicio,$fechaFin);
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                $newDate = date("d-m-Y", strtotime($reg->fecha));
                $data[] = array(
                "0"=>$newDate,
                "1"=>$reg->nombre_proveedor.' '.$reg->apellido_proveedor,
                "2"=>$reg->nombre_usuario,
                "3"=>$reg->tipocomprobante,
                "4"=>$reg->serie.' | '.$reg->numcomprobante,
                "5"=>$reg->total_compra,
                "6"=>($reg->estado == "aceptado")? '<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>',

                ); 
            }
            $result = array(
                "sEcho" =>1, //Informacion para el data table
                "iTotalRecords"=>count($data), //enviamos el total de registros al data table
                "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
                "aaData"=>$data //aca se encuentra almacenado todos los registros
            );

            echo json_encode($result);
        break;
        case 'ventasFecha':
        $fechaInicio = $_REQUEST["fechaInicio"];
        $fechaFin = $_REQUEST["fechaFin"];
        $respuesta = $consulta->ventasFecha($fechaInicio,$fechaFin);
        $data = array();
        while ($reg = $respuesta->fetch_object()){
            $newDate = date("d-m-Y", strtotime($reg->fecha));
            $data[] = array(
            "0"=>$newDate,
            "1"=>$reg->nombre_cliente.' '.$reg->apellido_cliente,
            "2"=>$reg->nombre_usuario,
            "3"=>$reg->tipo_comprobante,
            "4"=>$reg->serie.' | '.$reg->codigo,
            "5"=>$reg->monto_total,
            "6"=>($reg->estado == "aceptado")? '<span class="label bg-green">Aceptado</span>':'<span class="label bg-red">Anulado</span>',

            ); 
        }
        $result = array(
            "sEcho" =>1, //Informacion para el data table
            "iTotalRecords"=>count($data), //enviamos el total de registros al data table
            "iTotalDisplayRecords"=>count($data), //enviamos el toal de registros a visualizar
            "aaData"=>$data //aca se encuentra almacenado todos los registros
        );

        echo json_encode($result);
        break;
    
        case 'GananciasDia':
            $respuesta = $consulta->GananciasDia();
            $data = array();
            $totalDiaGanancias=0;
            while ($reg = $respuesta->fetch_object()){
                $totalDiaGanancias += $reg->ganancia_producto;
            }
            echo $totalDiaGanancias;
    
        break;
        case 'ventasFechaGrafico':
        $fechaInicio = $_REQUEST["fechaInicio"];
        $fechaFin = $_REQUEST["fechaFin"];
        $respuesta = $consulta->ventasFechaGrafico($fechaInicio,$fechaFin);
        $fechaV = "";
        $totalesV="";
        $nombremes="";
        while ( $regfechaV = $respuesta->fetch_object()){
            list($dia,$mes)= explode("-",$regfechaV->fecha);
            switch ($mes) {
                case '1':
                    $nombremes="Ene";
                    break;
                case '2':
                    $nombremes="Feb";
                    break;
                case '3':
                    $nombremes="Mar";
                    break;
                case '4':
                    $nombremes="Abr";
                    break;
                case '5':
                    $nombremes="May";
                    break;
                case '6':
                    $nombremes="Jun";
                    break;
                case '7':
                    $nombremes="Jul";
                    break;
                case '8':
                    $nombremes="Ago";
                    break;
                case '9':
                    $nombremes="Sep";
                    break;
                case '10':
                    $nombremes="Oct";
                    break;
                case '11':
                    $nombremes="Nov";
                    break;
                case '12':
                    $nombremes="Dic";
                    break;
            }
            $fechaV = $fechaV."'$dia de $nombremes'".',';
            $totalesV = $totalesV.$regfechaV->total.',';
        }
        //quitamos la ultima coma
        $fechaV = substr($fechaV,0,-1);
        $totalesV = substr($totalesV,0,-1);
        $data = array();
        $data[]= array(
            "fechaV"=> $fechaV,
            "totalesV"=> $totalesV,
        );
        echo json_encode($data);
        break;
        case 'comprasFechaGrafico':
        $fechaInicio = $_REQUEST["fechaInicio"];
        $fechaFin = $_REQUEST["fechaFin"];
        $compras10 = $consulta->comprasFechaGrafico($fechaInicio,$fechaFin);
        $fechaC = "";
        $totalesC="";
        $nombremes="";
        while ( $regfechaC = $compras10->fetch_object()){
            list($dia,$mes)= explode("-",$regfechaC->fecha);
            switch ($mes) {
                case '1':
                    $nombremes="Ene";
                    break;
                case '2':
                    $nombremes="Feb";
                    break;
                case '3':
                    $nombremes="Mar";
                    break;
                case '4':
                    $nombremes="Abr";
                    break;
                case '5':
                    $nombremes="May";
                    break;
                case '6':
                    $nombremes="Jun";
                    break;
                case '7':
                    $nombremes="Jul";
                    break;
                case '8':
                    $nombremes="Ago";
                    break;
                case '9':
                    $nombremes="Sep";
                    break;
                case '10':
                    $nombremes="Oct";
                    break;
                case '11':
                    $nombremes="Nov";
                    break;
                case '12':
                    $nombremes="Dic";
                    break;
            }
            $fechaC = $fechaC."'$dia de $nombremes'" .',';
            $totalesC = $totalesC.$regfechaC->total.',';
        }
        //quitamos la ultima coma
        $fechaC = substr($fechaC,0,-1);
        $totalesC = substr($totalesC,0,-1);
        $data = array();
        $data[]= array(
            "fechaC"=> $fechaC,
            "totalesC"=> $totalesC,
        );
        echo json_encode($data);
        break;
    }
?>