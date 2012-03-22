/* Author: Dave Armstrong

*/

var showAnim = true;
var timer = null;

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
    
    timer = setTimeout('backgroundFetch()', 1200000);
       
}

// when the user initiates a location refresh
function reloadApp(){
    showAnim = true;
    document.applets[0].init();
}


// when the application initiates a location refresh
function backgroundFetch(){
    showAnim = false;
    if(document.applets[0]){
        document.applets[0].init();
    }
    
}

function loadServices(bssid){
    
    
      $.ajax({
           url : '/home/services/' + bssid,
           cache : false,
           success : function(data){
               
                 var obj = $.parseJSON(data);
                 output_services(obj);
                
           },
           error : function(){
                $("#service_content").html('<div id="service_load_error">Unable to load services</div>');                  
           }
        
    });
    
}

function output_services(jsonObj){
    
   $("#service_content").html("");
    
   $.each(jsonObj, function(index, value){
       
      html  = '<div class="service"><a href="/home/service_info/' + jsonObj[index]["service"]["id"] + '">';
      html += '<img src="/images/services/' + jsonObj[index]["service"]["image"] + '" />';
      html += '<h3>' + jsonObj[index]["service"]["name"] + '</h3></a></div>';
      
        /* html  =   "<h1>" + jsonObj[index]["service"]["name"] + "</h1><br />";
        html +=   '<p><a href="' + jsonObj[index]["service"]["url"] + '" class="button green"><b>Visit:</b> '  + jsonObj[index]["service"]["name"] + '</a></p><br />';
        html +=   '<div id="info_details">'  + jsonObj[index]["service"]["body"] + '</div>'; */
        
        $("#service_content").html($("#service_content").html() + html);
   });
   
   $("#service_content").imagesLoaded(function() {
        $('#main').masonry({
            itemSelector: '.service',
            isFitWidth: true,
            isAnimated: showAnim
            });
        attachInfoListener();      

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



















