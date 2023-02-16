/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 *
 * Only add imports of other files here, Javascript code defined here
 * will not be executed.
 * User symfony-mazer.js for your own JS code or import own files
 *
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

// Mazer
import './mazer/js/app';

// Bootstrap
import './mazer/js/bootstrap'

// Symfony-Mazer
import './symfony-mazer';


import 'datatables.net';


 // require jQuery normally
 const $ = require('jquery');

  // create global $ and jQuery variables
  global.$ = global.jQuery = $;


 $.ajax({
    type: 'GET',
    url: '/api/clients',
    
    dataType: "json",
    success: function (response) {
        console.log(response)
    }
})

let testConvert = $.ajax({
    type: 'GET',
    url: '/api/adresses',
        
    dataType: "json",
    
   
})


$("#tableclients").DataTable({
    serverside: true,
    ajax: {
        url: "api/clients",
        dataSrc: ''
    },
    columns: [
        {data:'nom'},
        {data:'prenom'},
        {data:'telephone'},
        {data:'commandes'}
    ]    
});
 

console.log(test);
