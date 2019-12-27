<div class="out-selector-bundle">
        <label class="label-out-selector label" for="out">Salida</label>
        <select class="out-selector mdb-select form-control md-form colorful-select dropdown-primary" name="out">
            <option value="0" <?php if($programs[0]->out == 0){echo 'selected';}?>>Iluminación 1</option>
            <option value="1" <?php if($programs[0]->out == 1){echo 'selected';}?>>Iluminación 2</option>
            <option value="2" <?php if($programs[0]->out == 2){echo 'selected';}?>>Led placa</option>
            <option value="3" <?php if($programs[0]->out == 3){echo 'selected';}?>>Bomba de agua 2</option>
            <option value="4" <?php if($programs[0]->out == 4){echo 'selected';}?>>Extractor</option>
            <option value="5" <?php if($programs[0]->out == 5){echo 'selected';}?>>Ventilador</option>
            <option value="6" <?php if($programs[0]->out == 6){echo 'selected';}?>>Auxiliar 1</option>
            <option value="7" <?php if($programs[0]->out == 7){echo 'selected';}?>>Auxiliar 2</option>
        </select>
</div>
<div class="row days-bundle>
    <?php foreach ($programs[0]->days as $index => $day) :?>
        <form action="saveProgram.php" method="POST" class = "form-program day-bundle-<?=$index?> col-sm-6">      
        <div class = "day-selector-bundle-<?=$index?>">
            <label class="label-day-selector label" for="days">Dias</label>
            <br>
            <select class="day-selector-<?= $index?> mdb-select form-control md-form colorful-select dropdown-primary" name="days">
                <option value="7" <?php if($day  == 0){echo 'selected';}?>>Todos los días</option>
                <option value="1" <?php if($day  == 1){echo 'selected';}?>>Lunes</option>
                <option value="2" <?php if($day  == 2){echo 'selected';}?>>Martes</option>
                <option value="3" <?php if($day  == 3){echo 'selected';}?>>Miercoles</option>
                <option value="4" <?php if($day  == 4){echo 'selected';}?>>Jueves</option>
                <option value="5" <?php if($day  == 5){echo 'selected';}?>>Viernes</option>
                <option value="6" <?php if($day  == 6){echo 'selected';}?>>Sabado</option>
                <option value="0" <?php if($day  == 7){echo 'selected';}?>>Domingo</option>
            </select>
        </div>
        <div class = "row hour-bundle">
            <div class = "col h-on-bundle-<?= $index?>">
                <label class="label-h-on-<?= $index?> mdb-main-label " for="hour_on">Hora encendido</label>
                <input placeholder="Selected time" type="time" class="h-on-<?=$index?> form-control text-center" name="hour_on" value = <?=$programs[0]->hour_on[$index]?> >
            </div>
            <div class = "col h-off-bundle-<?= $index?>">
                <label class="label-h-off-<?= $index?> mdb-main-label" for="hour_off">Hora apagado</label>
                <input placeholder="Selected time" type="time" class="h-off-<?= $index?> form-control text-center" name="hour_off" value = <?=$programs[0]->hour_off[$index]?>>
            </div>
        </div>
        <br>
        <button type="submit" class="btn btn-primary" value="submit">Submit</button>
        </form>
    <?php endforeach;?>
</div>
<div class="container-fluid height-bar"></div>



<div class = "show-program">
        <div class="row justify-content-center">
            <?php foreach ($programs as $program) :?>
                <div class="col-sm-6 mb-2 out-container">
                    <label class="label" for="out">Salida</label>
                    <select disabled class="mdb-select form-control md-form colorful-select dropdown-primary" name="out">
                        <option value="0" <?php if($program->out == 0){echo 'selected';}?>>Iluminación 1</option>
                        <option value="1" <?php if($program->out == 1){echo 'selected';}?>>Iluminación 2</option>
                        <option value="2" <?php if($program->out == 2){echo 'selected';}?>>Led placa</option>
                        <option value="3" <?php if($program->out == 3){echo 'selected';}?>>Bomba de agua 2</option>
                        <option value="4" <?php if($program->out == 4){echo 'selected';}?>>Extractor</option>
                        <option value="5" <?php if($program->out == 5){echo 'selected';}?>>Ventilador</option>
                        <option value="6" <?php if($program->out == 6){echo 'selected';}?>>Auxiliar 1</option>
                        <option value="7" <?php if($program->out == 7){echo 'selected';}?>>Auxiliar 2</option>
                    </select>
                    
                    <?php foreach ($program->days as $index => $day) :?>         
                        <div class = "hora">
                            <label class="label" for="days">Dias</label>
                            <br>
                            <select disabled class="mdb-select form-control md-form colorful-select dropdown-primary" name="days">
                                <option value="7" <?php if($day  == 0){echo 'selected';}?>>Todos los días</option>
                                <option value="1" <?php if($day  == 1){echo 'selected';}?>>Lunes</option>
                                <option value="2" <?php if($day  == 2){echo 'selected';}?>>Martes</option>
                                <option value="3" <?php if($day  == 3){echo 'selected';}?>>Miercoles</option>
                                <option value="4" <?php if($day  == 4){echo 'selected';}?>>Jueves</option>
                                <option value="5" <?php if($day  == 5){echo 'selected';}?>>Viernes</option>
                                <option value="6" <?php if($day  == 6){echo 'selected';}?>>Sabado</option>
                                <option value="0" <?php if($day  == 7){echo 'selected';}?>>Domingo</option>
                            </select>
                        </div>
                        <div class = "row">
                            <div class = "col">
                                <label class="mdb-main-label " for="hour_on">Hora encendido</label>
                                <p class="form-control text-center"><?=$program->hour_on[$index]?></p>
                            </div>
                            <div class = "col">
                                <label class="mdb-main-label" for="hour_off">Hora apagado</label>
                                <p class="form-control text-center"><?=$program->hour_off[$index]?></p>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    
    <form action="saveProgram.php" method="POST" class = "form-program">
        <div class="row justify-content-center">
            <?php foreach ($programs as $program) :?>
                <div class="col-sm-6 mb-2 out-container">
                    <label class="label" for="out">Salida</label>
                    <select class="mdb-select form-control md-form colorful-select dropdown-primary" name="out">
                        <option value="0" <?php if($program->out == 0){echo 'selected';}?>>Iluminación 1</option>
                        <option value="1" <?php if($program->out == 1){echo 'selected';}?>>Iluminación 2</option>
                        <option value="2" <?php if($program->out == 2){echo 'selected';}?>>Led placa</option>
                        <option value="3" <?php if($program->out == 3){echo 'selected';}?>>Bomba de agua 2</option>
                        <option value="4" <?php if($program->out == 4){echo 'selected';}?>>Extractor</option>
                        <option value="5" <?php if($program->out == 5){echo 'selected';}?>>Ventilador</option>
                        <option value="6" <?php if($program->out == 6){echo 'selected';}?>>Auxiliar 1</option>
                        <option value="7" <?php if($program->out == 7){echo 'selected';}?>>Auxiliar 2</option>
                    </select>
                    
                    <?php foreach ($program->days as $index => $day) :?>         
                        <div class = "hora">
                            <label class="label" for="days">Dias</label>
                            <br>
                            <select class="mdb-select form-control md-form colorful-select dropdown-primary" name="days">
                                <option value="7" <?php if($day  == 0){echo 'selected';}?>>Todos los días</option>
                                <option value="1" <?php if($day  == 1){echo 'selected';}?>>Lunes</option>
                                <option value="2" <?php if($day  == 2){echo 'selected';}?>>Martes</option>
                                <option value="3" <?php if($day  == 3){echo 'selected';}?>>Miercoles</option>
                                <option value="4" <?php if($day  == 4){echo 'selected';}?>>Jueves</option>
                                <option value="5" <?php if($day  == 5){echo 'selected';}?>>Viernes</option>
                                <option value="6" <?php if($day  == 6){echo 'selected';}?>>Sabado</option>
                                <option value="0" <?php if($day  == 7){echo 'selected';}?>>Domingo</option>
                            </select>
                        </div>
                        <div class = "row">
                            <div class = "col">
                                <label class="mdb-main-label " for="hour_on">Hora encendido</label>
                                <input placeholder="Selected time" type="time" class="form-control text-center" name="hour_on" value = <?=$program->hour_on[$index]?> >
                            </div>
                            <div class = "col">
                                <label class="mdb-main-label" for="hour_off">Hora apagado</label>
                                <input placeholder="Selected time" type="time" class="form-control text-center" name="hour_off" value = <?=$program->hour_off[$index]?>>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>
            <br>
            <button type="submit" class="btn btn-primary" value="submit">Submit</button>
        </div>
    </form>