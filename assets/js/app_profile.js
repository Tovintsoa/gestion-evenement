require('bootstrap-datepicker');
const utilisateur_roles = '#utilisateur_roles';

$(document).ready(function(){

    $(".js_datepickerNaissance").datepicker({
        format: 'yyyy-mm-dd',
    })
    $(utilisateur_roles).selectpicker();
})