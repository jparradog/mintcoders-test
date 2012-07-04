<?php
$ext="form".$m['name'];
?>
<form class=" form-horizontal well" id="<?PHP echo($ext); ?>">
    <fieldset>
        <div class="alert alert-block" style="display: none;" id="<?PHP echo($ext); ?>-alerta">
            <h4 class="alert-heading"></h4>
            <p></p>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-buscar">Seleccione un Usuario</label>
            <div class="controls">
                <div class="input-append">
                    <select class="input-xlarge" name="<?PHP echo($ext); ?>-buscar" id="<?PHP echo($ext); ?>-buscar">
                        <option value="0" seleted>---</option>
<?PHP
$usuarios=$this->objUsuarios->CargarUsuarios();
if ($usuarios!=0) {
    for ($a=0; $a < $this->objUsuarios->conexion->numregistros(); $a++){
        echo '
            <option value="'.$usuarios[$a]['usuario'].'">'.$usuarios[$a]['nombre'].'</option>
        ';
    }
}
?>
                    </select>
                    <a href="#" class="toltip" id="<?PHP echo($ext); ?>-actualizar" rel="tooltip" data-original-title="Actualizar Lista"><span class="add-on"><i class="icon-refresh"></i></span></a>
                </div>
<?PHP
if ($usuarios==0) {
    echo '
        <span class="help-inline">Error: No hay usuarios creados</span>
    ';
}
?>
            </div>
            <div class="form-actions">
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-usuario">Usuario</label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" class="input-xlarge focused" placeholder="Ej: johnDoes" name="<?PHP echo($ext); ?>-usuario" id="<?PHP echo($ext); ?>-usuario" required="required" maxlength=30 minlength=5 pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,30}$">
                    <a href="#" class="toltip" rel="tooltip" data-original-title="Mínimo 5 caracteres, maximo 30."><span class="add-on"><i class="icon-exclamation-sign"></i></span></a>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-contra">Contraseña</label>
            <div class="controls">
                <div class="input-append">
                    <input type="password" class="input-xlarge focused" placeholder="Ej: hjk123PHD" name="<?PHP echo($ext); ?>-contra" id="<?PHP echo($ext); ?>-contra" required="required" maxlength=30 minlength=5 pattern="(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{4,30})$">
                    <a href="#" class="toltip" rel="tooltip" data-original-title="Mínimo 5 caracteres, maximo 30, por lo menos un digito y un alfanumérico, y no puede contener caracteres espaciales."><span class="add-on"><i class="icon-exclamation-sign"></i></span></a>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-email">Email</label>
            <div class="controls">
                <div class="input-append">
                    <input type="email" class="input-xlarge focused" placeholder="Ej: johndoes@email.com" name="<?PHP echo($ext); ?>-email" id="<?PHP echo($ext); ?>-email" required="required" maxlength=40 minlength=5 pattern="^[a-z]+@[a-z]+\.[a-z]{2,4}$">
                    <a href="#" class="toltip" rel="tooltip" data-original-title="Mínimo 5 caracteres, maximo 40."><span class="add-on"><i class="icon-exclamation-sign"></i></span></a>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-estado">Estado</label>
            <div class="controls">
                <div class="input-append">
                    <select class="input-xlarge" name="<?PHP echo($ext); ?>-estado" id="<?PHP echo($ext); ?>-estado" required="required">
<?PHP
$estados=$this->objUsuarios->CargarEstados();
if ($estados!=0) {
    for ($a=0; $a < $this->objUsuarios->conexion->numregistros(); $a++){
        echo '
            <option value="'.$estados[$a]['estado'].'">'.$estados[$a]['nombre'].'</option>
        ';
    }
}
?>
                </select>
<?PHP
if ($estados==0) {
    echo '
        <span class="help-inline">Error: No hay Estados creados</span>
    ';
}
?>
                    </select>
                    <a href="#" class="toltip" rel="tooltip" data-original-title=""><span class="add-on"><i class="icon-exclamation-sign"></i></span></a>
                </div>
            </div>
        </div>
    </fieldset>
</form>