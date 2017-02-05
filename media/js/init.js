/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $(document).ready(function(){
      $('.parallax').parallax();
    });
    
$(document).ready(function(){
    $('.collapsible').collapsible();
});

(function($){
  $(function(){

    $('.button-collapse').sideNav();

  }); // end of document ready
})(jQuery); // end of jQuery name space

(function($){
  $(function(){

    $('.button-collapse-dropdown').sideNav();

  }); // end of document ready
})(jQuery); // end of jQuery name space

  $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15 // Creates a dropdown of 15 years to control year
  });
  $('#textarea1').val('');
  $('#textarea1').trigger('autoresize'); 

 $(document).ready(function(){
    $('.materialboxed').materialbox();
  });
$(".dropdown-button").dropdown();
 $(document).ready(function(){
    $('ul.tabs').tabs();
  });
 $(document).ready(function(){
    $('ul.tabs').tabs('select_tab', 'tab_id');
  });  