$( document ).ready(function() {

    $( "#one" ).hover(
        function() {
          $( this ).addClass( "etoile" );
        }, function() {
          $( this ).removeClass( "etoile" );
        }
    );

    $( "#two" ).hover(
        function() {
          $("#one").addClass( "etoile" );
          $( this ).addClass( "etoile" );
        }, function() {
          $("#one").removeClass( "etoile" );
          $( this ).removeClass( "etoile" );
        }
    );

    $( "#three" ).hover(
        function() {
          $("#one").addClass( "etoile" );
          $("#two").addClass( "etoile" );
          $( this ).addClass( "etoile" );
        }, function() {
          $("#one").removeClass( "etoile" );
          $("#two").removeClass( "etoile" );
          $( this ).removeClass( "etoile" );
        }
    );

    $( "#four" ).hover(
        function() {
          $("#one").addClass( "etoile" );
          $("#two").addClass( "etoile" );
          $("#three").addClass( "etoile" );
          $( this ).addClass( "etoile" );
        }, function() {
          $("#one").removeClass( "etoile" );
          $("#two").removeClass( "etoile" );
          $("#three").removeClass( "etoile" );
          $( this ).removeClass( "etoile" );
        }
    );

    $( "#five" ).hover(
        function() {
          $("#one").addClass( "etoile" );
          $("#two").addClass( "etoile" );
          $("#three").addClass( "etoile" );
          $("#four").addClass( "etoile" );
          $( this ).addClass( "etoile" );
        }, function() {
          $("#one").removeClass( "etoile" );
          $("#two").removeClass( "etoile" );
          $("#three").removeClass( "etoile" );
          $("#four").removeClass( "etoile" );
          $( this ).removeClass( "etoile" );
        }
    );

});