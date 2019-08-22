<?php
//activamos el almacenamietno en el buffer
ob_start();
session_start();
if(!isset($_SESSION["nombres"])){
    header("Location: login.html");
}else{


require 'header.php';
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
       <!-- centro -->
    <section class="content" >
        <div class="row">
            <div class="col-md-12" style="padding-bottom:30px;">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title" style=" text-transform:uppercase"><p style="font-size:30px">PERFIL DE <?php echo $_SESSION['nombres'].' '. $_SESSION['apellidos'];?></p></h1>
                        <div class="box-tools pull-right"></div>
                    </div >
                   
                    <div class="container-fluid"  style="font-size:33px;text-transform:uppercase;border-radius:10px;border: 2px solid gray; padding:0;margin-bottom:10px;">
                        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12" style="padding:0;border-radius:10px">
                        <div class="col-md-4"style="text-align:center">
                        <?php 
                            if( isset($_SESSION['imagen']) && !empty($_SESSION['imagen']) ){
                                echo '<img src="../files/images/usuarios/'.$_SESSION['imagen'].'"  width="300" style="border: 5px solid gray;margin-top:10px;margin-bottom:10px" class="img-circle" alt="User Image">';
                            }else{
                                echo '<img src="../files/images/usuarios/usuario.jpg.jpg" width="300" style="border: 5px solid gray;margin-top:10px;margin-bottom:10px" class="img-circle" alt="User Image">';
                            }
                        ?>
                        </div>
                        <div class="col-md-8" style="padding:0;border-radius:10px">
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="padding: 10px;background-color:#d0d5dd;margin-bottom:2px;border-top-right-radius:10px">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">nombres:</div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;color:#f39c12"><?php echo $_SESSION['nombres'];?></div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="padding: 10px;;background-color:#d0d5dd;margin-bottom:2px;">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">Apellidos:</div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;color:#f39c12"><?php echo $_SESSION['apellidos'];?></div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="padding: 10px;background-color:#d0d5dd;margin-bottom:2px;">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">DNI:</div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;color:#f39c12"><?php echo  $_SESSION['nro_doc'];?></div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="padding: 10px;background-color:#d0d5dd;margin-bottom:2px;">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">nombre de usuario:</div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="text-align:right;color:#f39c12"><?php echo  $_SESSION['nombre_usuario'];?></div>
                            </div>
                            <div class="col-sm-12 col-lg-12 col-md-12 col-xs-12" style="padding: 10px;background-color:#d0d5dd;border-bottom-right-radius:10px;text-align:center;">
                                <div class="col-md-3 col-sm-3">
                                    <button class="btn btn-warning" data-toggle="modal" data-target="#modal_Pass" onclick="mostrarFormPass(<?php echo $_SESSION['id_usuario']?>)"><i class="fa fa-key"></i> EDITAR CLAVE</button>
                                </div>
                                <div class="col-md-3 col-sm-3" style="color:#f39c12;">
                                <button class="btn btn-warning"data-toggle="modal" data-target="#modal_usuario" onclick="mostrar(<?php echo $_SESSION['id_usuario']?>)"><i class="fa fa-pencil"></i> EDITAR DATOS</button>
                                </div>
                                <div class="col-md-3 col-sm-3" style="color:#f39c12">
                                    <button id="direccionbtn" class="btn btn-warning" onclick="mostrarDireccion(<?php echo $_SESSION['id_persona']?>)"><i class="fa fa-location-arrow" ></i> VER DIRECCIONES</button>
                                </div>
                                <div class="col-md-3 col-sm-3" style="color:#f39c12">
                                    <button id="contactobtn" class="btn btn-warning" onclick="mostrarContacto(<?php echo $_SESSION['id_persona']?>)"><i class="fa fa-book"></i> VER CONTACTOS</button>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                </div>
                    <!-- /.box-header -->
                    <br>

                   <!-- Fin centro -->
            </div>
                <div class="box" id="caja_contenido" style="display:none">
                    <div class="box-header with-border">
                        <h3  id="title_mostrar_direccion"></h3>
                    </div>
                    <div class="panel-body">
                    <div class="row">
                        <div id="contenido_extra">
                        </div>
                    </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
    <div class="modal fade" id="modal_usuario"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_usuario" class="modal-title">NUEVO USUARIO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="hidden" name="persona_id" id="persona_id">
                                    <label class="col-sm-4 col-sm-4 control-label">NOMBRES (*)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nombres" id="nombres" class="form-control" placeholder="" style="text-transform:uppercase" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label">APELLIDOS (*)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="apellidos" id="apellidos" class="form-control" style="text-transform:uppercase" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label">NRO DOC/CUIL (*)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nro_doc" id="nro_doc" class="form-control" style="text-transform:uppercase" maxlength="50"onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label">FECHA DE NACIMIENTO</label>
                                    <div class="col-sm-8">
                                        <input type="date" name="fecha_nac" id="fecha_nac" class="form-control" style="text-transform:uppercase" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group" id="nombreuser">
                                    <label class="col-sm-4 col-sm-4 control-label">NOMBRE USUARIO (*)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" style="text-transform:uppercase" required>
                                    </div>
                                </div>
                                <div id="eliminarclave1">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label">CONTRASEÑA (*)</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="clave1" id="clave1" class="form-control"  required >   
                                        </div>
                                    </div>
                                </div>
                                <div id="eliminarclave2">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-sm-4 control-label">CONFIRMAR CONTRASEÑA (*)</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="clave2" id="clave2" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="cargodiv">
                                    <label class="col-sm-4 col-sm-4 control-label">CARGO (*)</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="cargo" id="cargo" class="form-control" style="text-transform:uppercase" maxlength="50" required>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-sm-4 col-sm-4 control-label">IMAGEN (*)</label>
                                    <div class="col-sm-8">
                                    <div id="cargarimagen"></div>
                                    <input type="file" id="file-1" class="inputfile inputfile-1" name="imagen_usuario" accept="image/x-png,image/jpg,image/jpeg"/>
                                    <label  for="file-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="iborrainputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
                                    <span id="span_2" class="iborrainputfile">Seleccionar archivo</span>
                                    </label>           
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrar" name="cerrar" onclick="limpiar()"><i class="fa fa-arrow-circle-left" ></i> VOLVER</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> GUARDAR</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal_Pass"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_usuario" class="modal-title">ACTUALIZAR CONTRASEÑA</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario_Pass" id="formulario_Pass" method="POST">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrarPass" name="cerrarPass" onclick="limpiarPass()"><i class="fa fa-arrow-circle-left" ></i> VOLVER</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> GUARDAR</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" id="modal_direcciones"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_direccion" class="modal-title">NUEVA DIRECCION</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario_direccion" id="formulario_direccion" method="POST">
                                <!-- CAMPOS PARA DIRECCION -->
                                <div class="form-group" id="agregardiv">
                                    <input type="hidden" id="id_direccion" name="id_direccion">
                                   
                                    <label class="col-sm-3 col-sm-3 control-label">PROVINCIA (*)</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="provincia" id="provincia" class="form-control" maxlength="20" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">LOCALIDAD (*)</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="localidad" id="localidad" class="form-control" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">BARRIO </label>
                                    <div class="col-sm-9">
                                        <input type="text" name="barrio" id="barrio" class="form-control" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">CALLE</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="calle" id="calle" class="form-control" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">MANZANA</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="manzana" id="manzana" class="form-control" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">ALTURA</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="altura" id="altura" class="form-control" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">NRO PISO</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nro_piso" id="nro_piso" class="form-control" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">NRO DPTO</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nro_dpto" id="nro_dpto" class="form-control" maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">INFORMACION ADICIONAL</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="info_add" id="info_add" class="form-control" maxlength="100">
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" name="cerrardireccion" id="cerrardireccion" onclick="limpiarDireccion()"><i class="fa fa-arrow-circle-left"></i> VOLVER</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> GUARDAR</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <div class="modal fade" id="modal_contacto"> <!-- modallllllllll CONTACTO-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_contacto" class="modal-title">NUEVO CONTACTO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario_contacto" id="formulario_contacto" method="POST">
                            <input type="hidden" id="id_contacto" name="id_contacto">
                            <div class="form-group">
                                    <label for="" class="col-sm-3 col-md-3 control-label">TELEFONO (*)</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="number" name="telefono" id="telefono" class="form-control" placeholder="" required maxlength="12">
                                            <span class="input-group-addon"><i class=" fa fa-phone"></i></span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="" class="col-sm-3 col-md-3 control-label">CELULAR</label>
                                        <div class="col-sm-9 col-md-9"> 
                                        <div class="input-group">
                                            <input type="number" name="celular" id="celular" class="form-control" placeholder="" maxlength="12" >
                                            <span class="input-group-addon" style="font-size:22px"><i class=" fa fa-mobile"></i></span>
                                        </div> 
                                    </div>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-3 col-md-3 control-label"> EMAIL</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="ejemplo@ejemplo.com" maxlength="50">
                                            <span class="input-group-addon"><i class=" fa fa-at"></i></span>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label for="" class="col-sm-3 col-md-3 control-label">FAX</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <input type="number" name="fax" id="fax" class="form-control" placeholder="" maxlength="12">
                                            <span class="input-group-addon"><i class=" fa fa-fax"></i></span>
                                        </div>
                                    </div>
                                </div>  
                        </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" name="cerrarcontacto" id="cerrarcontacto" onclick="limpiarContacto()"><i class="fa fa-arrow-circle-left"></i> VOLVER</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> GUARDAR</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
<?php
require 'footer.php';
?>
<script type="text/javascript" src="scripts/usuario_editar.js"></script>
<script type="text/javascript" src="scripts/contacto.js"></script>
<script type="text/javascript" src="scripts/direccion.js"></script>
<?php
};
ob_end_flush();?>