<?PHP
echo '
<div class="span10">
<h2>'.$m['name'].'</h2>
</div>
<div class="span6">
';
echo $this->CrearListaUsuarios();
echo '
</div>
<div class="span4">
';
$ext="form".$m['name'];
?>
<form class="well hide" id="<?PHP echo($ext); ?>">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-usuario">Usuario</label>
            <div class="controls">
                <input type="text" class="input-xlarge focused" placeholder="Ej: johnDoes" name="<?PHP echo($ext); ?>-usuario" id="<?PHP echo($ext); ?>-usuario">
                <p class="help-block">Mínimo 5 caracteres, maximo 20.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-contra">Contraseña</label>
            <div class="controls">
                <input type="password" class="input-xlarge focused" placeholder="Ej: hjk123PHD" name="<?PHP echo($ext); ?>-contra" id="<?PHP echo($ext); ?>-contra">
                <p class="help-block">Mínimo 5 caracteres, maximo 20.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-email">Email</label>
            <div class="controls">
                <input type="email" class="input-xlarge focused" placeholder="Ej: johndoes@email.com" name="<?PHP echo($ext); ?>-email" id="<?PHP echo($ext); ?>-email">
                <p class="help-block">Mínimo 5 caracteres, maximo 20.</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="<?PHP echo($ext); ?>-estado">Estado</label>
            <div class="controls">
                <select class="input-xlarge" name="<?PHP echo($ext); ?>-estado" id="<?PHP echo($ext); ?>-estado">
                    <option value="1" seleted>Activo</option>
                    <option value="2">Inactivo</option>
                </select>
            </div>
        </div>
    </fieldset>
</form>
<?PHP
echo '
</div>
';
?>