var empty_output = '{"id":"0","program_id":"0","out":"0","hour_on":["00:30"],"hour_off":["01:30"],"days":["7"],"timerMode":"1","created_at":"2019-12-17 17:44:00","modified_at":"0000-00-00 00:00:00","sensor_id":null,"max_sensor":null,"min_sensor":null,"period":null,"duration":null}';
var outs_names;
var days_names;
var output;
var out_num = 0;
var device_id;
var program_id;
var flag_new_day = false;
var state_edit_program = "";
var programs;

$(document).ready(function(){
    device_id = getCookie('device_id');
    if(device_id == null){
        error("no hay device id");
    }
    getPrograms(0);
});

function submit_(e){
    let func;
    e.preventDefault();
    let data = JSON.stringify($('#program-form').serializeArray());
    debug(data);
    if(flag_new_day){
        flag_new_day = false;
        func = 'newOutput.php';
    } else {
        func = 'updateOutput.php';
    }

    fetch(func, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
          },
        body: data
    })
    .then(function(response) {
        if(response.ok) {
            return response.text()
        } else {
            throw "Error en: "+ func;
        }
     })
    .then(function(texto) {
        getOut(program_id, out_num);
        console.log(texto);
    })
    .catch(function(err) {
    popUp(err);
    console.log("Update or add Output: ", err);
    });
}

function saveProgramName(){
    let func;
    let form;
    switch (state_edit_program) {
        case 'EDIT':
            func = 'saveProgram.php';
            break;
        case 'NEW':
            func = 'newProgram.php';
            break;
        case 'ERASE':
            func = 'eraseProgram.php';
            break;
        default:
            func = '';
            break;
    }
    if(func == ''){
        error('Error in state_edit_program, empty.')
    } else {
        form = $('#program-form').serialize();
        $.post(func, form,function(prog_id){
            console.log(prog_id);
            endEditProgram();
            getPrograms(prog_id);
        })
    }
    state_edit_program = '';

    // fetch(func, {
    //     method: 'POST',
    //     body: form
    // })
    // .then(function(response) {
    //     if(response.ok) {
    //         return response.text()
    //     } else {
    //         throw "Error en: "+ func;
    //     }
    //  })
    // .then(function(texto) {
    // // getOut(program_id, out_num);
    // console.log(texto);
    // })
    // .catch(function(err) {
    // popUp(err);
    // console.log("Update or add Output: ", err);
    // });

}

function getPrograms(prog_selected){
    fetch('api/getProgram.php?device_id=' + device_id)
    .then(data =>data.json())
    .then(data => {
        programs = data;
        console.log(data);
        createProgramSelector(prog_selected);
    })
    .catch(error => console.log(error))
}

function getNames(){
    $(".program-selector").hide();
    fetch("api/getNames.php")
    .then(data =>data.json())
    .then(data => {
        outs_names = data[1];
        days_names = data[0];
        $(".program-selector").show();
        program_id = $(".program-selector").val();
        getOutputs(program_id);
    })
    .catch(error => console.error(error))
}

function getOutputs(_program_id){
    $.get("api/getOut.php","program_id=" + _program_id, function(data){
        outputs = JSON.parse(data);
        console.log(data);
        if(Object.entries(outputs).length === 0){ //no hay programa
            console.log("No hay salidas programas");
        } else {                                 //hay programa
            console.log("Hay salidas programas");
        }
        getOut(_program_id, 0);
    });
}

function getOut(_program_id, out_num){
    $.get("api/getOut.php","program_id=" + _program_id+ "&out_num=" + out_num, function(data){
        output = JSON.parse(data);
        if(isEmpty(output)){ //no hay programa
            console.log("la salida no esta programada");
        } else {                                 //hay programa
            console.log("la salida esta programada");
        }
        createOutSelector(out_num);
        createDays();
    });
}



function createProgramSelector(prog_selected){
    let selected = '';
    $('#program-container').html("<form class ='form-program' id='program-form'></form>");
    $('.form-program').append("<div class='program-selector-bundle border_1'></div>");
    $('.form-program').append("<input type='hidden' name='device_id' value='" + device_id + "'>");
    $('.program-selector-bundle').append("<div class='program-label-selector-bundle '></div>");
    $('.program-label-selector-bundle').append("<label class='label-program-selector label' for='out'>Programas</label>");
    $('.program-label-selector-bundle').append("<div class='icon-bundle-program'></div>");
    $('.icon-bundle-program').append("<img src='images/new.svg' id='btn-new-program' class='icon-out' style='display:none;' role='button'  onclick='newProgram()'>");
    $('.icon-bundle-program').append("<img src='images/edit_2.svg' id='btn-edit-program' class='icon-out' style='display:none;' role='button' onclick='editProgram()'>");
    $('.icon-bundle-program').append("<img src='images/bin.svg' id='btn-erase-program' class='icon-out' style='display:none;' role='button' onclick='eraseProgram()'>");
    if(programs.length == 0){
        $('.program-selector-bundle').append("<div class='error'>No hay programas creados aun</div>");
    } else {
        $('.program-selector-bundle').append("<select class='program-selector form-control' name='program'></select>");
        for (let i = 0; i < programs.length; i++){
            if(prog_selected == programs[i].id){
                selected = 'selected';
            } else {
                selected = '';
            }
            $('.program-selector').append("<option value=" + programs[i].id + " "+ selected + ">" + programs[i].name + "</option>");
        }
    $('.form-program').append('<div class="out-bundle border_1" style="display: none"></div>');
    }
    $('#btn-edit-program').fadeIn();
    $('#btn-erase-program').fadeIn();
    $('#btn-new-program').fadeIn();
    $('.program-selector').change(function(){
        out_num = 0;
        program_id = $(this).val();
        getOut(program_id, out_num);
    });
    getNames();
}

function createOutSelector(out_num_){
    $('.out-bundle').html("<div class='out-selector-bundle mb-3'></div>"); //reemplaza el contenido del html del out-bundle
    $('.out-selector-bundle').append("<div class='out-label-selector-bundle d-flex justify-content-between'></div>");
    $('.out-selector-bundle').append("<input type='hidden' id='hidden' name='output_id' value='"+output.id+"'>");
    $('.out-label-selector-bundle').append("<label class='label-out-selector label' for='out'>Salida</label>");
    $('.out-label-selector-bundle').append("<div class='icon-bundle'></div>");
    $('.icon-bundle').append("<img src='images/edit_2.svg' id='btn-edit-day' class='icon-out' style='display:none;' role='button' aria-pressed='false' onclick='editDays()'>");
    $('.out-selector-bundle').append("<select class='out-selector form-control' name='out'></select>");

    for (let i = 0; i < outs_names.length; i++) { //crea selector de salidas
        $('.out-selector').append("<option id = 'option-" + i + "' value=" + i + ">" + outs_names[i] + "</option>");
        if (out_num_ == i) {
            $('#option-' + i).attr("selected","selected");
        }
    }

    $('.out-selector').change(function(){ //crea evento de change para el selector de salida.
        out_num = $(this).val();
        getOut(program_id, out_num);
    });

}

function createDays(){
    if(isEmpty(output)){ //no hay programa
        $('.out-bundle').append("<div class='error' id='error_empty_output'>La salida no tiene programa aun.</div>");
        $('.out-bundle').append("<div class='msg'>Programar un dia: <img src='images/new.svg' class='icon-out id='btn-new-day' role='button'onclick='addDay()''></div>");
    } else {
        $('#error_empty_output').hide();
        $('.out-bundle').append("<div class='row days-bundle' style='display:none;'></div>");
        for (let i = 0; i < output.days.length ; i++) { //recorre days con i
            $('.days-bundle').append("<div class = 'day-bundle-" + i + " col-sm-6'></div>");
            $('.day-bundle-'+i).append("<div class = 'day-selector-bundle-" + i + "'></div>");
            $('.day-selector-bundle-'+i).append("<label class='label-day-selector label' for='days'>Dia</label><br>");
            $('.day-selector-bundle-'+i).append("<select class='day-selector-"+ i + " form-control day' disabled name='day-" + i + "'></select>");
            for (let index = 0; index < days_names.length; index++) { //CREA OPTIONS DEL SELECTOR DE DIAS recorre array de names con index
                $('.day-selector-' + i).append("<option id = 'day-" + i +"-"+ index + "' value='" + index + "'>" + days_names[index] + "</option>");
                if (output.days[i] == index) {
                    $('#day-'+i+"-"+index).attr("selected","selected");
                }
            }
            $('.day-bundle-'+i).append("<div class = 'row hour-bundle-" + i + "'></div>");
            $('.hour-bundle-' + i).append("<div class = 'col h-on-bundle-" + i + "'></div>");
            $('.h-on-bundle-' + i).append("<label class='label-h-on' for='hour_on'>Hora encendido</label>");
            $('.h-on-bundle-' + i).append("<input type='time' class='h-on form-control text-center time' disabled name='hour_on-"+i+"' value = " + output.hour_on[i] + " >");
            $('.hour-bundle-' + i).append("<div class = 'col h-off-bundle-" + i + "'></div>");
            $('.h-off-bundle-' + i).append("<label class='label-h-off' for='hour_off'>Hora apagado</label>");
            $('.h-off-bundle-' + i).append("<input type='time' class='h-off form-control text-center time' disabled name='hour_off-"+i+"' value = " + output.hour_off[i] + " >");
        }
        $('.out-bundle').append("<div class='submit-bundle'></div>");
        $('.submit-bundle').append("<br><button type='submit' class='btn btn-primary mr-2' id='submit' style='display:none;' value='submit'>Enviar</button>");
        $('.submit-bundle').append("<button type='button' class='btn btn-danger' id='cancel-day' style='display:none;'>Cancelar</button>");
        $('#program-form').submit(e => submit_(e)); //event SUBMIT
        $('#cancel-day').click(function(){
            editDays();
        })
        if(!flag_new_day){
            $('#btn-edit-day').fadeIn();
        }
    } 

    $('.out-bundle').slideDown(500);
    $('.days-bundle').slideDown(500);
    
}

function newProgram() {
    state_edit_program = 'NEW';
    $('.program-label-selector-bundle').hide();
    $('.program-selector').hide();
    $('.out-bundle').slideUp(200);
    $('.program-selector-bundle').append("<div class='edit-bundle' style='display: none'></div>");
    $('.edit-bundle').prepend('<label for="program_name">Nombre: </label><input class="form-control" type="text" name="program_name" value="">');
    $('.edit-bundle').append("<br><button type='button' class='btn btn-primary mr-2' id='prog-name' onclick='saveProgramName()'>Guardar</button>");
    $('.edit-bundle').append("<button type='button' class='btn btn-danger mr-2' id='' onclick='endEditProgram()'>Cancelar</button>");
    $('.edit-bundle').fadeIn(500);
}

function editProgram() {
    state_edit_program = 'EDIT';
    let program_name = $('.program-selector option:selected').text();
    let program_id = $('.program-selector option:selected').val();
    $('.program-label-selector-bundle').hide();
    $('.program-selector').hide();
    $('.out-bundle').slideUp(200);
    $('.program-selector-bundle').append("<div class='edit-bundle' style='display: none'></div>");
    $('.edit-bundle').prepend('<label for="program_name">Nombre: </label><input class="form-control" type="text" name="program_name" value=' + program_name + '><input type="hidden" name="program_id" value=' + program_id + '>');
    $('.edit-bundle').append("<br><button type='button' class='btn btn-primary mr-2' id='prog-name' onclick='saveProgramName()'>Guardar</button>");
    $('.edit-bundle').append("<button type='button' class='btn btn-danger mr-2' id='' onclick='endEditProgram()'>Cancelar</button>");
    $('.edit-bundle').fadeIn(500);
}


function eraseProgram() {
    state_edit_program = 'ERASE';
    let program_name = $('.program-selector').text();
    // console.log(popUp("Seguro que desea borrar el programa " + program_name + "?", 2));
    saveProgramName();
}

function endEditProgram(){
    $('.edit-bundle').fadeOut(500);
    $('.edit-bundle').remove();
    $('.program-label-selector-bundle').fadeIn();
    $('.program-selector').fadeIn();
    $('.out-bundle').slideDown(500);
}

function addDay(){
    flag_new_day = true;
    output = JSON.parse(empty_output);
    createDays(); //crea dia y horas
    grayDayTimeControls(false); // desgrisa controles de dia y horas
    $("#btn-edit-day").fadeOut();
    $("#submit").fadeIn();

}

function editDays(){
    let pressed = ($('#btn-edit-day').attr("aria-pressed") === "true");
    $('#btn-edit-day').attr("aria-pressed",!pressed);
    if(!pressed){
        prop = false;
        $("#submit").fadeIn();
        $('#cancel-day').fadeIn();

    } else{
        prop = true;
        $("#submit").fadeOut();
        $('#cancel-day').fadeOut();
    }
    grayDayTimeControls(prop);
}

function eraseDay(index){

}

function grayDayTimeControls(prop){
    let cantidad = $(".day").length;
    for (let index = 0; index <cantidad  ; index++) {
        $(".day").prop("disabled", prop);
    }
    for (let index = 0; index <cantidad  ; index++) {
        $(".time").prop("disabled", prop);
    }
}

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
        return false;
    }
    return true;
}

function error(message){
    let error = "Error: " + message;
    console.log(error);
}

function debug(message){
    let debug = "debug: " + message;
    console.log(debug);
}

function popUp(message, btn){
    let msg;
    if(btn == 0){
        msg = '<div id="popup"><div id="message"><p>' + message + '</p><button type="button" class="btn" id="accept">Aceptar</button></div></div>';
    } else {
        msg = '<div id="popup"><div id="message"><p>' + message + '</p><div class="buttons-bundle"><button type="button" class="btn btn-success" id="accept">Aceptar</button><button type="button" class="btn btn-danger" id="cancel">Cancelar</button></div></div></div>';
    }
    $("body").prepend(msg);
    $('#accept').click(function(){
        $('#popup').remove();
        return true;
    })
    $('#cancel').click(function(){
        $('#popup').remove();
        return false;
    })

}