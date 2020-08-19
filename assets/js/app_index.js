require('bootstrap-datepicker');


$(document).ready(function(){
    $(".js_datepicker1").datepicker({
        format: 'yyyy-mm-dd',
    })
    $(".js_datepicker2").datepicker({
        format: 'yyyy-mm-dd',
    })
    $('#chercher_evenement_type_evenement').selectpicker();
    $("#chercher_evenement_lieu_evenement").selectpicker();
    $(".interesse").on("click",function () {
        let id_event = $(this).data("id");
        axios.get(Routing.generate("interesse"),{
            user: id_utilisateur,
            evenement: id_event
        }).then(function(response){

        }).catch(function(error){

        })
    })
})