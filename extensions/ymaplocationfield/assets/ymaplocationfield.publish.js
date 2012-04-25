jQuery(document).ready(function() {	
	jQuery('fieldset .field-ymaplocation').each(function() {
		var field = new YMapLocationField(jQuery(this));
	});
});

function YMapLocationField(field) {
	
	// cache the field container DOM element (jQuery)
	this.field = field;
	
	// initial options
	this.options = {
		initial_zoom: 11,
		geocode_zoom: 10
	};
	
	// placeholders
	this.map = null;
	this.marker = null;
	
	this.inputs = {
		marker: field.find('label.coordinates input'),
		centre: field.find('label.centre input'),
		zoom: field.find('label.zoom input')
	}
	
	this.init();
};

YMapLocationField.prototype.init = function() {
	var self = this;
	
	// build field HTML
	var html = jQuery(
		'<div class="tab-panel tab-map">' +
			'<div id="YMapsID" class="ymap"></div>' +
		'</div>'
	).prependTo(this.field);
	
	// get initial map values from the DOM
	var initial_coordinates = this.parseLatLng(this.inputs.marker.val());
	var initial_centre = this.parseLatLng(this.inputs.centre.val());
	var initial_zoom = parseInt(this.inputs.zoom.val());
	
	var marker_latlng = new YMaps.GeoPoint(initial_coordinates[0], initial_coordinates[1]);
	var centre_latlng = new YMaps.GeoPoint(initial_coordinates[0], initial_coordinates[1]);
	
	/*
	 * http://api.yandex.ru/maps/intro/concepts/intro.xml
	 */
	// add the map
	this.map = new YMaps.Map(this.field.find('#YMapsID')[0]);
	this.map.setCenter(centre_latlng, initial_zoom);
	this.map.addControl(new YMaps.Zoom());
	
	// add the marker
	this.marker = new YMaps.Placemark(marker_latlng, {draggable: true, hasBalloon: false, style: "default#houseIcon"});
	this.map.addOverlay(this.marker);
	
	// store the updated values to the DOM
	self.storeCoordinates(self.marker.getGeoPoint());
	self.storeCentre();
	self.storeZoom();
	
	// bind events to store new values
	YMaps.Events.observe(this.marker, this.marker.Events.Drag, function(obj) {
		self.storeCoordinates(obj.getGeoPoint());
	});
	YMaps.Events.observe(this.marker, this.marker.Events.DragEnd, function (obj) {
        self.moveMarker(obj.getGeoPoint(), true);
    });
	YMaps.Events.observe(this.map, this.map.Events.Move, function(obj) {
		self.storeCentre();
	});
	YMaps.Events.observe(this.map, this.map.Events.Update, function(obj) { 
		self.storeZoom();
	});
	
	this.field.find('label.address input[type=text]').bind('keypress', function(e) {
		if(e.keyCode == 13) {
			e.preventDefault();
			self.editAddress();
		}
	});
	this.field.find('label.address input[type=button]').bind('click', function() {
		self.editAddress();
	});
};

YMapLocationField.prototype.moveMarker = function(position, centre, zoom) {
	this.marker.setGeoPoint(position);
	this.storeCoordinates(this.marker.getGeoPoint());
	if (centre) 
	{
		this.map.panTo(position, {
			speed: 10,
			startSpeed: 10,
			speedUpTime: 200
			});
	}
	if(zoom)
		this.map.setCenter(position, zoom);
};

YMapLocationField.prototype.storeCoordinates = function(latLng) {
	this.inputs.marker.val(latLng.getLng() + ', ' + latLng.getLat());
}

YMapLocationField.prototype.storeZoom = function() {
	this.inputs.zoom.val(this.map.getZoom());
}

YMapLocationField.prototype.storeCentre = function() {
	var centre = this.map.getCenter();
	this.inputs.centre.val(centre.getLng() + ', ' + centre.getLat());
}

YMapLocationField.prototype.parseLatLng = function(string) {
	return string.match(/-?\d+\.\d+/g);
}

YMapLocationField.prototype.editAddress = function() {
	var self = this;
	var address_field = self.field.find('label.address input[type=text]');
	var button_field = self.field.find('label.address input[type=button]');
	
	address_field.attr('disabled', 'disabled');
	button_field.attr('disabled', 'disabled');
	
	/* 
	 * http://api.yandex.ru/maps/geocoder/doc/desc/concepts/About.xml
	 */
	var geocoder = new YMaps.Geocoder(address_field.val(), {results: 1, boundedBy: self.map.getBounds()});

	YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
		if (this.length()) {
			geoResult = this.get(0);
			self.moveMarker(geoResult.getGeoPoint(), true);
			self.map.setBounds(geoResult.getBounds());
			self.storeCentre();
		} else {
			address_field.val(address_field.val() + " (not found)");
		}
	});
	YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
		alert("Error: " + error);
	});

	address_field.removeAttr('disabled');
	button_field.removeAttr('disabled');
}