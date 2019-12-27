var outs_names;
var days_names;
var hasProgram = false;
var output;
var out_num = 0;
var device_id;
var program_id;

$(document).ready(function(){
    device_id = getCookie('device_id');
    if(device_id == null){
        error("no hay device id");
    }
    let reponse = getNames();
    
    $(".program-selector").change(function(){
        program_id = $(this).val();
        debug("program_id: ");
        debug(program_id);
        getOutputs($(this).val());  
    });
});

function getOutputs(_program_id){
    $.get("api/getOut.php","program_id=" + _program_id, function(data){
        outputs = JSON.parse(data);
        if(Object.entries(outputs).length === 0){ //no hay programa
            error("no hay salidas programas");
        } else {                                 //hay programa
            debug("hay salidas programas");
            getOut(_program_id, 0);
        }
    });
}

function getOut(_program_id, out_num){
    $.get("api/getOut.php","program_id=" + _program_id+ "&out_num=" + out_num, function(data){
        output = JSON.parse(data);
        if(isEmpty(output)){ //no hay programa
            debug("la salida no esta programada");
        } else {                                 //hay programa
            debug("la salida esta programada");
        }
        createOutSelector(out_num);
        createDays();
    });
}

function createOutSelector(out_num_){
    $('.out-bundle').html("<div class='out-selector-bundle mb-3'></div>");
    $('.out-selector-bundle').append("<form class ='form-program' id='program-form'></form>"); //action='saveProgram.php' method='POST'
    $('.form-program').append("<div class='out-label-selector-bundle d-flex justify-content-between'></div>");
    $('.form-program').append("<input type='hidden' id='hidden' name='output_id' value='"+output.id+"'>");
    $('.out-label-selector-bundle').append("<label class='label-out-selector label' for='out'>Salida</label>");
    $('.out-label-selector-bundle').append("<div class='icon-bundle'></div>");
    if(isEmpty(output)){
        // $('.icon-bundle').append("<img src='images/new.svg' id='btn-new-day' class='icon-out'>");
    } else{
        $('.icon-bundle').append("<img src='images/edit_2.svg' id='btn-edit-day' class='icon-out'>");
        // $('.icon-bundle').append("<img src='images/bin.svg' class='icon-out'>");
        $('#btn-edit-day').click(function(){
            editDays('ON');
        });
    }
    $('.form-program').append("<select class='out-selector form-control'  name='out'></select>");

    for (let i = 0; i < outs_names.length; i++) { //crea selector de salidas
        $('.out-selector').append("<option id = 'option-" + i + "' value=" + i + ">" + outs_names[i] + "</option>");
        if (out_num_ == i) {
            $('#option-' + i).attr("selected","selected");
        }
    }
    $('.out-selector').change(function(){
        out_num = $(this).val();
        getOut(program_id, out_num);
    });

}

function createDays(){
    if(isEmpty(output)){ //no hay programa
        $('.out-bundle').append("<div class='error'>La salida no tiene programa aun.</div>");
        $('.out-bundle').append("<div class='msg'>Programar un dia: <img src='images/new.svg' id='btn-new-day' class='icon-out'></div>");
        $('#btn-new-day').click(function(){
            alert("new day");
        });
    } else {
        $('.form-program').append("<div class='row days-bundle' style='display:none;'></div>");
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
        $('.form-program').append("<div class='submit-bundle'></div>");
        $('.submit-bundle').append("<br><button type='submit' class='btn btn-primary' id='submit' style='display:none;' value='submit'>Enviar</button>");
        $('#program-form').submit(e => submit_(e)); //event
    }
    $('.out-bundle').slideDown(500);
    $('.days-bundle').slideDown(500);
    
}

function eraseDay(index){
    $('.days-bundle').remove();
    $('.error').remove();
}

function editDays(on_off){
    let prop;
    if(on_off == 'ON'){
        prop = false;
        $("#submit").show();
    } else{
        prop = true;
        $("#submit").hide();
    }
    let cantidad = $(".day").length;
    for (let index = 0; index <cantidad  ; index++) {
        $(".day").prop("disabled", prop);
    }
    for (let index = 0; index <cantidad  ; index++) {
        $(".time").prop("disabled", prop);
    }
    
}

function submit_(e){
    e.preventDefault();
    let data = JSON.stringify($('#program-form').serializeArray());
    console.log(data);
    // $.post('saveProgram.php', data, function(data){
    //     console.log(data);
    // });
    fetch('updateProgram.php', {
        method: 'POST',
        body: data
    })
    .then(function(response) {
        if(response.ok) {
            return response.text()
        } else {
            throw "Error en la llamada Ajax";
        }
     
     })
     .then(function(texto) {
        editDays('OFF');
        console.log(texto);
     })
     .catch(function(err) {
        console.log(err);
     });
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
