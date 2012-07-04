<?php
$ext="form".$m['name'];
?>
<form class=" form-horizontal well" id="<?PHP echo($ext); ?>">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-buscar">Seleccione un Usuario</label>
            <div class="controls">
                <select class="input-xlarge" name="<?PHP echo($ext); ?>-buscar" id="<?PHP echo($ext); ?>-buscar">
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
<?PHP
if ($usuarios==0) {
    echo '
        <span class="help-inline">Error: No hay usuarios creados</span>
    ';
}
?>
            </div>
            <div class="form-actions">
                <a href="#" class="btn btn-primary" name="<?PHP echo($ext); ?>-eliminar" id="<?PHP echo($ext); ?>-eliminar">Eliminar</a>
            </div>
        </div>
    </fieldset>
</form>