/* Author: Dave Armstrong

*/

var showAnim = true;
var timer = null;
var initialised = false;

function reset(){
    console.log("resettting");
    // ensure these are reset upon page load
    showAnim = true;
    timer = null;
    initialised = false;
}


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
    
    timer = setTimeout('backgroundFetch()', 15000);
       
}

// when the user initiates a location refresh
function reloadApp(){
    showAnim = true;
    if(document.applets.length > 0){
        document.applets[0].init();
    } else {
        hard_load();
    }
}


// when the application initiates a location refresh
function backgroundFetch(){
    console.log("fetch");
    showAnim = false;
    if(document.applets.length > 0){
        console.log("applet");
        document.applets[0].init();
    } else {
        console.log("hard");
        hard_load();
    }
    
}

function loadServices(bssid){
    
    
      $.ajax({
           url : '/home/services/' + bssid,
           cache : false,
           success : function(data){
                 var obj = $.parseJSON(data);
                 
                 // dont do anything unless the data is intact
                 if(obj["remove"] !== 'undefined' && 
                     obj["add"] !== 'undefined' &&
                        obj["data"] !== 'undefined'){
                    // now check to see if this is an update    
                    if(initialised == false){
                        // this isnt an update
                            console.log("create");
                            output_services(obj["data"]);                     
                    } else {
                        console.log("updating");
                        // things have changed but we want to make small adjustments
                        update_services(obj["add"], obj["remove"], obj["update"], obj["data"]);
                    }
                        
                        
                 }
                 
           },
           error : function(){
                $("#service_content").html('<div id="service_load_error">Unable to load services</div>');                  
           }
        
    });
    
}

function output_services(jsonObj){
   console.log("initialise");
    
   html = ""; 
   
   $('#service_content').html("");
    
   $.each(jsonObj, function(index, value){
      html += create_html_string(jsonObj, index);
   });
   
   $('#service_content').html(html);
   
    $("#service_content").imagesLoaded(function() {
        console.log("loading isotope");     
        $('#service_content').isotope({
                itemSelector: '.service',
                resizable: false,
                sortBy : 'weight',
                sortAscending : false,
                getSortData : {
                    weight : function ( $elem ) {
                        return parseInt($elem.find('.weight').text(), 10);
                    }
                },
                 masonry: { columnWidth: $("#service_content").width() / 330 }
            });
        attachInfoListener();      

    });
    
    initialised = true;
 
}

$(window).smartresize(function(){
  $("#service_content").isotope({
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $("#service_content").width() / 330 }
  });
});


function create_html_string(data, index){
    html = "";
    html += '<div class="service" id="service_' + data[index]["service"]["id"] +  '">';  
    html += '<a href="/home/service_info/' + data[index]["service"]["id"] + '">';
    html += '<div class="weight">' + data[index]["weight"] + '</div>';
    html += '<img src="/images/services/' + data[index]["service"]["image"] + '" />';
    html += '<h3>' + data[index]["service"]["name"] + '</h3></a></div>';   
    return html;
}

function update_services(add, remove, update, data){
    
    // remove
        remove_items = new Array();
        $.each(remove, function(index, value){
                console.log("removing", value);
                obj = $("#service_" + value);
                $('#service_content').isotope( 'remove', obj );
                //$(obj).remove();
                
        });    
    
    html = "";
    
    $.each(data, function(index, value){
      if($.inArray(data[index]["service"]["id"], add) != -1){
          // add the new items
         console.log("adding", data[index]["service"]["id"]);
         html += create_html_string(data, index);
      } 
      
   });
   
   newItems = $(html);
   
   newItems.imagesLoaded(function(){
        $('#service_content').isotope('insert', newItems);
   });
   
        
        
        
        // update services
        $.each(data, function(index, value){
            if($.inArray(data[index]["service"]["id"], update) != -1){
                // add the new items
                console.log("updating", data[index]["service"]["id"]);
                obj = $("#service_" + data[index]["service"]["id"]);
                $("img", obj).attr("src", "/images/services/" + data[index]["service"]["image"]);
                $("h3", obj).html(data[index]["service"]["name"]);
                $("a", obj).attr("href", "/home/service_info/" + data[index]["service"]["id"]);
                $(".weight", obj).html(data[index]["weight"]);
            }       
        });
        
        $('#service_content').isotope( 'updateSortData', $('.service','#service_content') ).isotope({ sortBy : 'weight', sortAscending : false });
        
        $('#service_content').imagesLoaded(function(){
           // dont forget to attach the info click events to the new services
            attachInfoListener();
            $('#service_content').isotope('reLayout');
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




  $.Isotope.prototype._getCenteredMasonryColumns = function() {
    this.width = this.element.width();
    
    var parentWidth = this.element.parent().width();
    
                  // i.e. options.masonry && options.masonry.columnWidth
    var colW = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  parentWidth;
    
    var cols = Math.floor( parentWidth / colW );
    cols = Math.max( cols, 1 );

    // i.e. this.masonry.cols = ....
    this.masonry.cols = cols;
    // i.e. this.masonry.columnWidth = ...
    this.masonry.columnWidth = colW;
  };
  
  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getCenteredMasonryColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  };

  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevColCount = this.masonry.cols;
    // get updated colCount
    this._getCenteredMasonryColumns();
    return ( this.masonry.cols !== prevColCount );
  };
  
  $.Isotope.prototype._masonryGetContainerSize = function() {
    var unusedCols = 0,
        i = this.masonry.cols;
    // count unused columns
    while ( --i ) {
      if ( this.masonry.colYs[i] !== 0 ) {
        break;
      }
      unusedCols++;
    }
    
    return {
          height : Math.max.apply( Math, this.masonry.colYs ),
          // fit container to columns that have been used;
          width : (this.masonry.cols - unusedCols) * this.masonry.columnWidth
        };
  };














