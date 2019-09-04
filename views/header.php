<?php
if(strlen(session_id())< 1 )
    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GestionSy | FormosaAberturas</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="../public/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../public/css/font-awesome.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../public/css/_all-skins.min.css">
        <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">
        <link rel="shortcut icon" href="../public/img/favicon.ico">
        <!-- DATATABLES-->
        <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../public/datatables/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css">
        <!-- chosen select multiple -->
        <link rel="stylesheet" href="../public/plugins/chosen_v1.8.7/chosen.css">
        <!-- include the style ALERTIFY -->
        <link rel="stylesheet" href="../public/alertify/css/alertify.css" />
        <!-- include a theme -->
        <link rel="stylesheet" href="../public/alertify/css/themes/default.css" />
        <!-- bootstrap-select -->
        <link rel="stylesheet" href="../public/css/bootstrap-select.min.css">
        <!-- smoothbox css carousel -->
        <link rel="stylesheet" href="../public/Smoothbox-master/css/smoothbox.css">
        <!-- input file -->
        <link rel="stylesheet" href="../public/input-file/css/file-input.css">
    </head>
    <body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="escritorio.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>GSy</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>FA</b> <i style="font-size:18px">Formosa Aberturas</i></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Navegación</span></a>
                    <?php
                        if($_SESSION['ventas']==1){
                    ?>
                    <ul class="nav navbar-nav">
                    <li>&nbsp;</li>
                     <li><a href="index_factura.php" type="button" role="button" class="btn btn-success"><i class="fa fa-arrow-circle-right"></i> Nueva Venta</a></li>
                    </ul>
                    <?php
                        }
                    ?>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php 
                                    if( isset($_SESSION['imagen']) && !empty($_SESSION['imagen']) ){
                                        echo '<img src="../files/images/usuarios/'.$_SESSION['imagen'].'" class="user-image" alt="User Image">';
                                    }else{
                                        echo '<img src="../files/images/usuarios/usuario.jpg.jpg" class="user-image" alt="User Image">';
                                    }
                                ?>
                                
                                <span class="hidden-xs" style="text-transform:uppercase"><?php echo $_SESSION['nombre_usuario'] ?> </span>
                                <input type="hidden" id="valorUsuarioParaFactura" value="<?php echo $_SESSION['id_usuario'];?>"> 
                            </a>
                            <ul class="dropdown-menu">
                                    <!-- User image -->
                                <li class="user-header">
                                    <?php 
                                        if( isset($_SESSION['imagen']) && !empty($_SESSION['imagen']) ){
                                            echo '<img src="../files/images/usuarios/'.$_SESSION['imagen'].'"  class="img-circle" alt="User Image">';
                                        }else{
                                            echo '<img src="../files/images/usuarios/usuario.jpg.jpg" class="img-circle" alt="User Image">';
                                        }
                                    ?>
                                    <p>Administrador<small> <a href="usuario_editar.php">Editar Datos</a></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                    <a href="../ajax/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
      <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">       
          <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header"></li>
                <!-- li escritorio -->
                <?php
                if($_SESSION['escritorio']==1){
                ?>
                    <li>
                    <a href="escritorio.php">
                        <i class="fa fa-tasks"></i> <span>Escritorio</span>
                    </a>
                </li>
                <?php  
                }//cerramos if
                ?>
                <!-- Fin li escritorio -->
                <!-- inicio li almacen -->
                <?php
                if($_SESSION['almacen']==1){
                ?>       
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span>Almacén</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index_producto.php"><i class="fa fa-circle-o"></i> Productos</a></li>
                        <li><a href="index_categoria.php"><i class="fa fa-circle-o"></i> Categorías</a></li>
                        <li><a href="index_material.php"><i class="fa fa-circle-o"></i> Materiales</a></li>
                    </ul>
                </li>
                <?php
                }//cerramos if
                ?>
                <!-- Fin li almacen -->
                <!-- inicio li compras -->
                <?php
                if($_SESSION['compras']==1){
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th"></i>
                        <span>Compras</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index_compras.php"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                        <li><a href="index_proveedor.php"><i class="fa fa-circle-o"></i> Proveedores</a></li>
                    </ul>
                </li>
                <?php
                }//cerramos if
                ?>
                <!-- fin li compras -->
                <!-- inicio li ventas -->
                <?php
                if($_SESSION['ventas']==1){
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Ventas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index_ventas.php"><i class="fa fa-circle-o"></i> Ventas</a></li>
                        <li><a href="index_cuentas.php"><i class="fa fa-circle-o"></i> Cuentas</a></li>
                        <li><a href="index_cliente.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                    </ul>
                </li>            
                <?php
                }//cerramos if
                ?>    
                <!-- fin li ventas -->
                <!-- inicio li acceso -->
                <?php
                if($_SESSION['acceso']==1){
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>Acceso</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index_usuario.php"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                        <li><a href="index_permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>
                    </ul>
                </li>
                <?php
                }//cerramos if
                ?>
                <!-- fin li acceso -->
                <!-- inicio consulta compras -->
                <?php
                if($_SESSION['consultac']==1){
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i> <span>Consulta Compras</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="compras_fecha.php"><i class="fa fa-circle-o"></i> Consulta Compras</a></li>
                        <li><a href="consultaAumentoProducto.php"><i class="fa fa-circle-o"></i>Historial de Precios</a></li>                     
                    </ul>
                </li>
                <?php
                }//cerramos if
                ?>
                <!-- fin li consultas compras -->
                <!-- inicio li consulta ventas-->
                <?php
                if($_SESSION['consultav']==1){
                ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bar-chart"></i> <span>Consulta Ventas</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="ventas_fecha.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a></li>                
                    </ul>
                </li>
                <?php
                }//cerramos if
                ?>
                <!-- cerramos li consulta ventas -->
                <li>
                    <a href="#">
                        <i class="fa fa-plus-square"></i> <span>Ayuda</span>
                        <small class="label pull-right bg-red">PDF</small>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                        <small class="label pull-right bg-yellow">IT</small>
                    </a>
                </li>       
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

