require('bootstrap-datepicker');
const routes = require('../../web/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js';
Routing.setRoutingData(routes);
$(document).ready(function(){

    getMyPosition();

    $(".js_datepicker1").datepicker({
        format: 'yyyy-mm-dd',
    })
    $(".js_datepicker2").datepicker({
        format: 'yyyy-mm-dd',
    })

    $('#chercher_evenement_type_evenement').selectpicker();
    $("#chercher_evenement_lieu_evenement").selectpicker();
    $("#chercher_evenement_current_position").on("change",function () {

        if(this.checked){
            $("#chercher_evenement_lieu_evenement").attr("disabled",true);
            $("#chercher_evenement_position_value").val(region);
        }
        else{
            $("#chercher_evenement_lieu_evenement").removeAttr('disabled');
            $("#chercher_evenement_position_value").val("");
        }
    })
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
function maPosition(position) {
    let lat = position.coords.latitude;
    let long = position.coords.longitude;
    axios.get("https://us1.locationiq.com/v1/reverse.php?key=db5bcae7acd7cf&lat="+lat+"&lon="+long+"&format=json", {
    }).then(function (response) {
        region = response.data.address['city'];

       console.log(response.data);
    }).catch(function (error) {

    })
}
function getMyPosition(){

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(maPosition);
    } else {
        alert("aucun");
    }
}