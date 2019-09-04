<?php
    require_once "../models/Cuenta.php";
    $cuenta = new Cuenta();
    // $nombres = isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
    // $apellidos = isset($_POST["apellidos"])? limpiarCadena($_POST["apellidos"]):"";
    // $nro_doc = isset($_POST["nro_doc"])? limpiarCadena($_POST["nro_doc"]):"";
    // $fecha_nac = isset($_POST["fecha_nac"])? limpiarCadena($_POST["fecha_nac"]):"";
    switch($_GET["op"]){
        case 'guardar':
            $num_elementos = 0;
            $res = "0";
           $id_cuota = $_POST['id_cuota'];
            while ($num_elementos < count($id_cuota)){
              $respuesta = $cuenta->insertar($id_cuota[$num_elementos]);
                $num_elementos = $num_elementos +1;
                $res= $respuesta ? '1' : '0';
            }
           echo $res;
        break;
        case 'mostrar':
            $id_cuenta = $_GET['idcuenta'];
            $respuesta = $cuenta->mostrar($id_cuenta);
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                $mostrar = '';
                if($reg->estado =='pendiente'){
                    $mostrar = '<span class="label bg-orange-active">Pendiente</span>';
                }
                if($reg->estado == 'mora'){
                    $mostrar = '<span class="label bg-red-active">Mora</span>';
                }
                if($reg->estado == 'pagado'){
                    $mostrar = '<span class="label bg-green-active">Pagado</span>';
                }
                $newDate = date("d-m-Y", strtotime($reg->fecha_v));
                $data[] = array(
                "0" =>"",
                "1"=>$reg->nro_cuota,
                "2"=>$newDate,
                "3"=>($reg->fecha_pago)? $reg->fecha_pago : 'No Pagado',
                "4"=>'$ '.$reg->interes,
                "5"=>'$ '.$reg->monto,
                "6"=>$mostrar,
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
        case 'mostrarProducto':
        $id_cuenta = $_POST['idcuenta'];
        $respuesta = $cuenta->mostrarProducto($id_cuenta);
        while($reg = $respuesta->fetch_object())
        {
            echo '<p style="text-transform:uppercase; font-size:20px">'.$reg->descripcion.'  ||  '.$reg->nombre.'</p>';
        }
        break;
        case 'mostrarProductoTotal':
        $id_cuenta = $_POST['idcuenta'];
        $respuesta = $cuenta->mostrarProductoTotal($id_cuenta);
        while($reg = $respuesta->fetch_object())
        {
            echo '<p style="text-transform:uppercase; font-size:20px">$ '.$reg->monto_total.'</p>';
        }
        break;
        case 'selectCliente':
            $respuesta= $cuenta->selectClientes();
            echo '<option value="">Seleccionar... </option>';
            while($reg = $respuesta->fetch_object())
            {
                echo '<option value="'.$reg->id_clientes.'" >'.$reg->nombres.' '.$reg->apellidos.' | DNI: '.$reg->nro_doc.'</option>';
            }
        break;
        case 'selectCuentaCliente':
        $cliente_id = $_REQUEST['cliente_id'];
        $respuesta= $cuenta->selectCuenta($cliente_id);
        echo '<option value="">Seleccionar... </option>';
        while($reg = $respuesta->fetch_object())
        {
            $newDate = date("d-m-Y", strtotime($reg->fecha_cuenta));
            if(isset($reg->estado) && !empty($reg->estado) && $reg->estado =="1"){
                $estado = "Abierto";
                echo '<option value="'.$reg->id_cuenta.'" >Fecha de Cuenta: '.$newDate.' | Total Cuotas: '.$reg->total_cuotas.' | Estado: '.$estado.'</option>';
            }
        }
        break;
        case 'selectCuotaCliente':
        $cuenta_id = $_REQUEST['cuenta_id'];
        $respuesta= $cuenta->selectCuota($cuenta_id);
        echo '<option value="">Seleccionar... </option>';
        while($reg = $respuesta->fetch_object())
        {
            $newDate = date("d-m-Y", strtotime($reg->fecha_v));
            echo '<option value="'.$reg->id_cuota.'" >Fecha Vto: '.$newDate.' | Interes: $'.$reg->interes.' | Monto: $ '.$reg->monto.' | Estado: '.$reg->estado.'</option>';
        }
        break;
        case 'detallarCuota':
        $id_cuota = $_REQUEST['id_cuota'];
        $respuesta = $cuenta->detallarCuota($id_cuota);
        echo json_encode($respuesta);
        break;

        case 'listar':
        $respuesta = $cuenta->listar();
            $data = array();
            while ($reg = $respuesta->fetch_object()){
                $newDate = date("d-m-Y", strtotime($reg->fecha_cuenta));
                $data[] = array(
                "0"=>($reg->estado) ?'<button class="btn btn-info" data-toggle="modal" data-target="#modal_cuenta" onclick="mostrar('.$reg->id_cuenta.')"><i class="fa fa-eye"></i></button>'.' <button class="btn btn-danger" onclick="desactivar('.$reg->id_cuenta.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-info" data-toggle="modal" data-target="#modal_cuenta" onclick="mostrar('.$reg->id_cuenta.')"><i class="fa fa-eye"></i></button>'.' <button class="btn btn-success" onclick="activar('.$reg->id_cuenta.')"><i class="fa fa-check"></i></button>',
                "1"=>$newDate,
                "2"=>$reg->nombres.' '.$reg->apellidos,
                "3"=>$reg->nro_doc,
                "4"=>$reg->nombre_usuario,
                "5"=>$reg->total_cuotas,
                "6"=>($reg->estado) ? '<span class="label bg-green-active">Abierto</span>':'<span class="label bg-red-active">Cerrado</span>',
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
        case 'datosfactura':
        $id=$_POST['id_cuenta'];
        $respuesta=$cuenta->encabezadoFacturaCuota($id);
        echo json_encode($respuesta);
        break;
    }
?>