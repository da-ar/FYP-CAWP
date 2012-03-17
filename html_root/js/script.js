/* Author: Dave Armstrong

*/

var showAnim = true;
var timer = null;
var lastFetch = null;

$(document).ready(function(){


    // load in the MacSniffer Applet
    $("#applet").html([
	  '<object', 
	  'classid="java:com.B00528996.MacSniffer" id="sniffer"',
	  'type="application/x-java-applet" width="1" height="1">',
		'<param name="archive" value="/util/MacSniffer.jar"></param>',
		'<param name="code" value="com.B00528996.MacSniffer"></param>',
		'<param name="mayscript" value="true"></param>',
		'<param name="id" value="sniffer"></param>',
	  '</object'].join('\n'));        
        

});

// deals with the macsniffer output
function displayMac(bssid){
    
    $.ajax({
           url : '/home/location/' + bssid,
           cache : false,
           success : function(data){
               $("#loc_info").html("Your location: " + data);
           }
    });
    // now that this is done we can load in the services
    
    loadServices(bssid);
    clearTimeout(timer);
    timer = setTimeout('backgroundFetch()', 30000);
    
}

// when the user initiates a location refresh
function reloadApp(){
    showAnim = true;
    document.applets[0].init();
}


// when the application initiates a location refresh
function backgroundFetch(){
    showAnim = false;
    document.applets[0].init();
}

function loadServices(bssid){
    
    
      $.ajax({
           url : '/home/services/' + bssid,
           cache : false,
           success : function(data){

                
                
           },
           error : function(){
                $("#service_content").html('<div id="service_load_error">Unable to load services</div>');                  
           }
        
    });
    
}
    
/*    $.ajax({
           url : '/services.html',
           cache : false,
           success : function(data){

                if(lastFetch == null){
                    $("#service_content").html(data);
                   
                    $("#service_content").imagesLoaded(function() {
                        $('#main').masonry({
                            itemSelector: '.service',
                            isFitWidth: true,
                            isAnimated: showAnim
                            });
                        attachInfoListener();      
                            
                    });    
                        
                    lastFetch = data;    
                    
                } else if(data !== lastFetch){
                   
                   $("#service_content").html(data);
                   
                    $("#service_content").imagesLoaded(function() {
                        $('#main').append( data ).masonry( 'appended', data );
                        attachInfoListener();   
                    });
                    lastFetch = data;
                }
                
           },
           error : function(){
                $("#service_content").html('<div id="service_load_error">Unable to load services</div>');                  
           }
        
    });

*/


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



















