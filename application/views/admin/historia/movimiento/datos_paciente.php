<div id="HistoriaContenidoDatosPaciente" class="panel panel-primary">
  <div class="panel-heading">Datos del paciente</div>
  <div class="panel-body">
    <form id="FormHistoriaMovimientoDatosPaciente" action="<?= base_url('historia/movimiento/guardarDatosPaciente') ?>" method="POST">
      <input type="hidden" name="paciente" value="<?= $this->uri->segment(4) ?>">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Apellidos:</label>
            <input type="text" name="apellidos" class="form-control input-sm" value="<?= $paciente->apel_pac ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Nombres:</label>
            <input type="text" name="nombres" class="form-control input-sm" value="<?= $paciente->nomb_pac ?>">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label class="control-label">F. de Nac:</label>
            <input type="text" name="fechaNacimiento" class="form-control input-sm" value="<?= $paciente->fena_pac ?>">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label class="control-label">Edad:</label>
            <input type="text" name="edad" class="form-control input-sm" value="<?= $paciente->edad_pac ?>">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label class="control-label">DNI:</label>
            <input type="text" name="dni" class="form-control input-sm" value="<?= $paciente->dni_pac ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Dirección:</label>
            <input type="text" name="direccion" class="form-control input-sm" value="<?= $paciente->dire_pac ?>">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Género:</label>
            <div>
              <label class="radio-inline">
                <input type="radio" name="genero" value="M" <?= ($paciente->sexo_pac=='M')?'checked':'' ?>> Masculino
              </label>
              <label class="radio-inline">
                <input type="radio" name="genero" value="F" <?= ($paciente->sexo_pac=='F')?'checked':'' ?>> Femenino
              </label>
            </div>
          </div>
        </div>
    
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Ocupación</label>
            <input type="text" name="ocupacion" class="form-control input-sm" value="<?= $paciente->ocupacion ?>">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Estudios</label>
            <select name="estudios" class="form-control input-sm">
              <option value="S" <?= ($paciente->estudios_pac=='S')?'selected':'' ?>>SECUNDARIA COMPLETA</option>
              <option value="U" <?= ($paciente->estudios_pac=='U')?'selected':'' ?>>SUPERIOR</option>
              <option value="P" <?= ($paciente->estudios_pac=='P')?'selected':'' ?>>PRIMARIA COMPLETA</option>
              <option value="N" <?= ($paciente->estudios_pac=='N')?'selected':'' ?>>NO ESPECIFICA</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Estado Civil</label>
            <select name="estadoCivil" class="form-control input-sm">
              <option value="C" <?= ($paciente->civi_pac=='C')?'selected':'' ?>>Casado(a)</option>
              <option value="S" <?= ($paciente->civi_pac=='S')?'selected':'' ?>>Soltero(a)</option>
              <option value="V" <?= ($paciente->civi_pac=='V')?'selected':'' ?>>Viudo(a)</option>
              <option value="D" <?= ($paciente->civi_pac=='D')?'selected':'' ?>>Divorciado(a)</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label">Email</label>
            <input type="text" name="email" class="form-control input-sm" value="<?= $paciente->emai_pac ?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Pais</label>
            <select name="pais" class="form-control select2 input-sm" style="width: 100%">
              <option value=""></option>
              <?php foreach ($paises as $p): ?>
              <option value="<?= $p->id ?>" <?= ($p->id==$paciente->pais_id)?'selected':'' ?>><?= $p->nombre ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label class="control-label">Departamento</label>
            <select name="departamento" class="form-control input-sm">
              <?php foreach ($departamentos as $d): ?>
                <option value="<?= $d->departamento_id ?>" <?= ($paciente->departamento_id==$d->departamento_id)?'selected':'' ?>><?= $d->departamento_nombre ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Provincia</label>
            <select name="provincia" class="form-control input-sm">
              <?php foreach ($provincias as $p): ?>
              <option value="<?= $p->provincia_id ?>" <?= ($paciente->provincia_id==$p->provincia_id)?'selected':'' ?>><?= $p->provincia_nombre ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">Distrito</label>
            <select name="distrito" class="form-control input-sm">
              <?php foreach ($distritos as $d): ?>
              <option value="<?= $d->distrito_id ?>" <?= ($d->distrito_id==$paciente->distrito_id)?'selected':'' ?>><?= $d->distrito_nombre ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="control-label">Observacion:</label>
            <textarea name="observacion" class="form-control" rows="3" value="<?= $paciente->observacion ?>"></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group pull-right">
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
        </div>
      </div>

   
    </form>
  </div>
</div>