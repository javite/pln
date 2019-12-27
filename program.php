
<?php
require_once("init.php");
if ($_GET) {
    $device_selected = $_GET["device_id"];
    $programs = json_decode($db->getPrograms($_GET));
}
?>

<?php include('head.php')?>
<link rel="stylesheet" type="text/css" media="screen" href="css/style_main.css" />
<script src="js/functions.js"></script>
<script src="js/program.js"></script>

<body>
    <?php include('navbar.php')?>
    <input id="device_id" type="hidden" value = <?=$device_selected?>>
    <!-- <div class="container-fluid">
        <h4>Programa: </h4>
    </div> -->
    <div class="container">
        <div class='program-selector-bundle border_1'>
            <label class='label-program-selector label' for='out'>Programas</label>
            <?php if(sizeof($programs) == 0):?>
                <div class='error'>No hay programas creados aun</div>
            <?php else:?>
                <select class='program-selector mdb-select form-control md-form colorful-select dropdown-primary'  name='program'>
                    <?php foreach ($programs as $key => $program):?>
                        <option id = "program-<?=$key?>" value="<?=$program->id?>"><?=$program->name?></option>
                    <?php endforeach ;?>
                </select>
            <?php endif ?>
        </div>
        <div class="out-bundle border_1" style="display: none"></div>
    </div>
    <?php include('footer.php')?>

</body>
</html>


