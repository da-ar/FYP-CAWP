/* Author: Dave Armstrong

*/

$(document).ready(function(){


    // load in the MacSniffer Applet
    $("#applet").html([
	  '<object', 
	  'classid="java:com.B00528996.MacSniffer"',
	  'type="application/x-java-applet" width="1" height="1">',
		'<param name="archive" value="/util/MacSniffer.jar"></param>',
		'<param name="code" value="com.B00528996.MacSniffer"></param>',
		'<param name="mayscript" value="true"></param>',
		'<param name="id" value="sniffer"></param>',
	  '</object'].join('\n'));        
        

});


// deals with the macsniffer output
function displayMac(text){
    $("#loc_info").html($("#loc_info").html() + "<pre>" + text + "</pre>");
    // now that this is done we can load in the services
    loadServices();
}

function loadServices(){
    
    $("#service_content").load('/services.html', function(response, status, xhr) {
        
        if (status == "error") {
            
            $("#service_content").html('<div id="service_load_error">Unable to load services</div>');
            
        } else {
            
            console.log("ajax loaded");

            $("#service_content").imagesLoaded(function() {

                console.log("images loaded");

                    $('#main').masonry({
                        itemSelector: '.service',
                        isFitWidth: true,
                        isAnimated: true
                    });
                    
                    
                 attachInfoListener();   

            });
        }
       
    });    
    
}

function attachInfoListener(){
    $(".service a").click(function(){
        
         $("#info_modal").load($(this).attr("href"), function(response, status, xhr) {
        
            if (status == "error") {

                $("#info_modal").html('<div id="service_load_error">Unable to load information</div>');

            }

        });  
        
        $("#info_modal").modal({onOpen: function (dialog) {
	dialog.overlay.fadeIn('slow', function () {
		dialog.container.fadeIn('fast', function () {
			dialog.data.fadeIn('fast');
		});
            });
        }});
        return false;
        
    });
}



















