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
        let val = $(this).children()[0];
        if(id_utilisateur === 0){
           /* $("i", this).toggleClass("far fa-star fas fa-star");*/
            /**
             * Modal pour inciter à la connexion
             */
           /* $("#modalConnexion").modal("toggle");*/
        }
        else {
            if($(val).hasClass('far fa-star')){
                axios.get(Routing.generate("interesse")+"/"+id_utilisateur+"/"+id_event+"/add", {

                }).then(function (response) {
                    $("i", "#interesse-"+id_event).toggleClass("far fa-star fas fa-star");
                }).catch(function (error) {

                })
            }
            else{
                axios.get(Routing.generate("interesse")+"/"+id_utilisateur+"/"+id_event+"/delete", {

                }).then(function (response) {
                    $("i", "#interesse-"+id_event).toggleClass("far fa-star fas fa-star");
                }).catch(function (error) {

                })
            }

        }
    })
})