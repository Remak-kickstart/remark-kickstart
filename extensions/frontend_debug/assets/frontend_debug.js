jQuery(function($){
	// Get the eventdata:
	var eventData = document.body.lastChild.data;
	if(String(eventData).match(/\<events/) == null)
	{
		eventData = "No eventdata found!\n\nhave you set 'display_event_xml_in_source' set to 'yes' in your 'manifest/config.php'-file?";
	} else {
		// Trim the string:
		eventData = eventData.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
	}
	$("body").append('<div id="frontend_debug_container"><iframe /><a href="#" class="frontend_debug_expand">+</a></div>');
	$("body").append('<div id="frontend_debug_events_container"><div><pre><code></code></pre></div><a href="#" class="frontend_debug_expand">+</a></div>');
	$("body").append('<a href="#" id="frontend_debug_show">debug</a>');
	$("body").append('<a href="#" id="frontend_debug_events">events</a>');
	$("#frontend_debug_events_container code").text(eventData);
	// Hide iFrame:
	$("#frontend_debug_container, #frontend_debug_events_container").hide();
	
	// Attach functionality to the show-button:
	$("a#frontend_debug_show").click(function(){
        $("a#frontend_debug_show,a#frontend_debug_events").removeClass("active");
		$("#frontend_debug_events_container").hide();
		if(document.getElementById("frontend_debug_container").style.display == 'none')
		{
            $("a#frontend_debug_show").addClass("active");
			var location = String(window.location).split('#')[0];
			location += location.split('?').length > 1 ? '&debug' : '?debug';
			$("#frontend_debug_container").show();
			frontend_debug_resize();			
			$("#frontend_debug_container iframe").attr("src", location);
		} else {
			$("#frontend_debug_container").hide();
		}
		return false;	
	});
	
	$("#frontend_debug_container a.frontend_debug_expand").click(function(){
		if($(this).text()=='+') {
			$(this).text('-');
			$("#frontend_debug_container").css({width: $(window).width()-60});
			$("#frontend_debug_container iframe").css({width: $(window).width()-62});
		} else {
			$(this).text('+');
			$("#frontend_debug_container").css({width: $(window).width()/2});
			$("#frontend_debug_container iframe").css({width: ($(window).width()/2)-2});
		}
		return false;
	});
	
	// Attach functionality to the events-button:
	$("a#frontend_debug_events").click(function(){
        $("a#frontend_debug_show,a#frontend_debug_events").removeClass("active");
		$("#frontend_debug_container").hide();
		if(document.getElementById("frontend_debug_events_container").style.display == 'none')
		{
            $("a#frontend_debug_events").addClass("active");
			var location = String(window.location).split('#')[0];
			location += location.split('?').length > 1 ? '&debug' : '?debug';
			$("#frontend_debug_events_container").show();
			frontend_debug_resize();
		} else {
			$("#frontend_debug_events_container").hide();
		}
		return false;	
	});
	
	$("#frontend_debug_events_container a.frontend_debug_expand").click(function(){
		if($(this).text()=='+') {
			$(this).text('-');
			$("#frontend_debug_events_container").css({width: $(window).width()-60});
			$("#frontend_debug_events_container div").css({width: $(window).width()-62});
		} else {
			$(this).text('+');
			$("#frontend_debug_events_container").css({width: $(window).width()/2});
			$("#frontend_debug_events_container div").css({width: ($(window).width()/2)-2});
		}
		return false;
	});
	
	$(window).resize(frontend_debug_resize);
});

function frontend_debug_resize()
{
	if(document.getElementById("frontend_debug_container").style.display != 'none')
	{
		$("#frontend_debug_container").css({top: 30, right: 10, height: $(window).height()-50, width: $(window).width()/2});
		$("#frontend_debug_container iframe").css({width: ($(window).width()/2)-2, height: $(window).height()-52});
	}
	if(document.getElementById("frontend_debug_events_container").style.display != 'none')
	{
		$("#frontend_debug_events_container").css({top: 30, right: 10, height: $(window).height()-50, width: $(window).width()/2});
		$("#frontend_debug_events_container div").css({width: ($(window).width()/2)-2, height: $(window).height()-52});
	}	
}