/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
//import $ from 'jquery';
const $ = require('jquery');
global.axios = require('axios');
require ("bootstrap");
import '../css/global.scss';
global.$ = global.jQuery = $;
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';
require('bootstrap-select/dist/js/bootstrap-select.min');
import 'bootstrap-select/dist/css/bootstrap-select.min.css'
global.id_utilisateur = $(".body").data("connected");
global.region = "";
console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

