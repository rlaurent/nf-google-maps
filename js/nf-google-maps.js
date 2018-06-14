jQuery(document).on( 'nfFormReady', function( e, layoutView ) {
  var input = document.getElementById('nf-field-google-maps');
  autocomplete = new google.maps.places.Autocomplete(input, {types: ['geocode']});
  autocomplete.addListener('place_changed', fillInAddress);

  function fillInAddress(){
    jQuery( '#nf-field-google-maps' ).val( autocomplete.getPlace().formatted_address ).change();
  }
});