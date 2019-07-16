<?php
require 'header.php';
?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">Lista de Proveedores <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_proveedor"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right"></div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tablalistado" class="table table-bordered table-hover nowrap" style="width:100%">
                            <thead >
                                <th style="text-align: center;">Opciones</th>
                                <th style="text-align: center;">Razon Social</th>
                                <th style="text-align: center;">Nombres</th>
                                <th style="text-align: center;">Apellidos</th>
                                <th style="text-align: center;">Contactos</th>
                                <th style="text-align: center;">Direcciones</th>
                                <th style="text-align: center;">Estado</th>
                            </thead>
                            <tbody style="text-align: center;text-transform:uppercase">

                            </tbody>
                            <tfoot>
                                <th style="text-align: center;">Opciones</th>
                                <th style="text-align: center;">Razon Social</th>
                                <th style="text-align: center;">Nombres</th>
                                <th style="text-align: center;">Apellidos</th>
                                <th style="text-align: center;">Contactos</th>
                                <th style="text-align: center;">Direcciones</th>
                                <th style="text-align: center;">Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <!-- <div class="panel-body  style="height: 400px;" id="formularioregistros">
                    </div>
                    Fin centro -->
                </div>
                <div class="box" id="caja_contenido" style="display:none">
                    <div class="box-header with-border">
                        <h3  id="title_mostrar_direccion">DIRECCIONES DE "NOMBRE Y APELLIDO"</h3>
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
    <div class="modal fade" id="modal_proveedor"> <!-- modallllllllll-->
        <div class="modal-dialog">
            <div class="modal-content"> <!-- div content --> 
                <div class="modal-warning modal-header " style="background-color:#f39c12">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color:white">&times;</span>
                    </button>
                    <h4 style="color:white;" id="title_proveedor" class="modal-title">Nuevo Proveedor</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario" id="formulario" method="POST">
                                <div class="form-group">
                                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                                    <input type="hidden" name="persona_id" id="persona_id">
                                    <label class="col-sm-3 col-sm-3 control-label">NOMBRES (*)</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nombres" id="nombres" class="form-control" placeholder="" style="text-transform:uppercase" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">APELLIDOS (*)</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="apellidos" id="apellidos" class="form-control" style="text-transform:uppercase" maxlength="50" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">DNI</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nro_doc" id="nro_doc" class="form-control" maxlength="15">
                                    </div>
                                    <input type="hidden" name="fecha_nac" id="fecha_nac">
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">EMPRESA (*)</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="razonsocial" id="razonsocial" class="form-control" style="text-transform:uppercase" maxlength="50" required>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label id="label_contacto" class="col-sm-3 col-sm-3 control-label">TIPO CONTACTO (*)</label>
                                    <div id="divInput" class="col-sm-9">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-success" onclick="sumarInput()"> <i class="fa fa-plus"></i></button>
                                            </span>
                                                <select name="tp" id="tipocontacto" class="form-control" required>
                                                    <option value="0">Seleccionar...</option>
                                                    <option value="TELEFONO">TELEFONO</option>
                                                    <option value="CELULAR">CELULAR</option>
                                                    <option value="CORREO">CORREO</option>
                                                    <option value="FAX">FAX</option>
                                                </select>
                                                <span class="input-group-addon" id="laveltipocontacto">-</span>
                                                <p id="lugarboton"></p>
                                                  
                                        </div>
                                     
                                    </div>
                                </div>-->   
                        </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="cerrar" name="cerrar" onclick="limpiarProveedor()"><i class="fa fa-arrow-circle-left" ></i> Volver</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> Guardar</button>
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
                    <h4 style="color:white;" id="title_direccion" class="modal-title">Nueva Direccion</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form  class="form-horizontal"  name="formulario_direccion" id="formulario_direccion" method="POST">
                                <!-- CAMPOS PARA DIRECCION -->
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">PROVINCIA (*)</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="provincia" id="provincia" class="form-control" maxlength="50" required>
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
                                        <input type="text" name="manzana" id="manzana" class="form-control" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">ALTURA</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="altura" id="altura" class="form-control" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">NRO PISO</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nro_piso" id="nro_piso" class="form-control" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">NRO DPTO</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nro_dpto" id="nro_dpto" class="form-control" maxlength="50">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-sm-3 control-label">INFORMACION ADICIONAL</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="info_add" id="info_add" class="form-control" maxlength="50">
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" name="cerrardireccion" id="cerrardireccion" onclick="limpiarDireccion()"><i class="fa fa-arrow-circle-left"></i> Volver</button>
                    <button type="submit" class="btn btn-info"> <i class="fa fa-save" id="btnGuardar"></i> Guardar</button>
                </div>
                </form>
            </div><!-- div content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php
require 'footer.php';
?>
<script type="text/javascript" src="scripts/proveedor.js"></script>
