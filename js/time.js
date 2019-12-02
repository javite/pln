var input = $('#manual-operations-input').pickatime({
autoclose: true,
'default': 'now'
});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
e.stopPropagation();
input.pickatime('show').pickatime('toggleView', 'minutes');
});