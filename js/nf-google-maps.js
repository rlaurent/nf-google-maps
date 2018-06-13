jQuery(document).ajaxComplete(function (event, jqXHR, ajaxOptions) {
   var input = document.getElementById('nf-field-google-maps');
   autocomplete = new google.maps.places.Autocomplete(input);
});