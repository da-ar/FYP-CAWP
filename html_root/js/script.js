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

$(window).load(function(){
    // load masonry
    $('#main').masonry({
        itemSelector: '.service',
        isFitWidth: true,
        isAnimated: true
    });
});


// deals with the macsniffer output
function displayMac(text){
    $("#loc_info").html($("#loc_info").html() + "<pre>" + text + "</pre>");
}





















