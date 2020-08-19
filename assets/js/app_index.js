require('bootstrap-datepicker');
const routes = require('../../web/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js';
Routing.setRoutingData(routes);
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

        if(id_utilisateur === 0){

        }
        else {
            axios.get(Routing.generate("interesse")+"/"+id_utilisateur+"/"+id_event, {

            }).then(function (response) {

            }).catch(function (error) {

            })
        }
    })
})