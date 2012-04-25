<?php

	require_once(CORE . '/class.cacheable.php');

	class fieldYMapLocation extends Field {

		/*
		 * http://api.yandex.ru/maps/form.xml
		 */
		private $_api_key;
	
		private $_geocode_cache_expire = 60; // minutes

		// defaults used when user doesn't enter defaults when adding field to section
		private $_default_location = 'Almaty';
		private $_default_coordinates = '76.912335, 43.28081'; // Almaty, Kazakhstan
		private $_default_zoom = 10;

		private $_filter_origin = array();

		public function __construct(&$parent) {
			parent::__construct($parent);
			
			$this->_name = 'Yandex Map Location';
			$this->_api_key = Symphony::Configuration()->get('api_key', 'yandex_map_location');
			
			if($this->_api_key == null)
				$this->_api_key = '';
		}

	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/

		public function mustBeUnique() {
			return true;
		}

		public function canFilter() {
			return false;
		}

	/*-------------------------------------------------------------------------
		Setup:
	-------------------------------------------------------------------------*/

		public function createTable(){
			return Symphony::Database()->query(
				"CREATE TABLE IF NOT EXISTS `tbl_entries_data_" . $this->get('id') . "` (
				  `id` int(11) unsigned NOT NULL auto_increment,
				  `entry_id` int(11) unsigned NOT NULL,
				  `latitude` double default NULL,
				  `longitude` double default NULL,
				  `centre` varchar(255) default NULL,
				  `zoom` int(11) default NULL,
				  `address` varchar(255) default NULL,
				  PRIMARY KEY  (`id`),
				  KEY `entry_id` (`entry_id`),
				  KEY `latitude` (`latitude`),
				  KEY `longitude` (`longitude`)
				) TYPE=MyISAM;"
			);
		}

	/*-------------------------------------------------------------------------
		Utilities:
	-------------------------------------------------------------------------*/

		private function __geocodeAddress($address, $can_return_default=true) {
		
			$coordinates = null;

			$cache_id = md5('ymaplocationfield_' . $address);
			$cache = new Cacheable($this->_engine->Database);
			$cachedData = $cache->check($cache_id);

			// no data has been cached
			if(!$cachedData) {

				include_once(TOOLKIT . '/class.gateway.php');

				$ch = new Gateway;
				$ch->init();
				$ch->setopt('URL', 'http://geocode-maps.yandex.ru/1.x/?format=json&geocode=' . urlencode($address) . '&key=' . $this->_api_key);
				$response = json_decode($ch->exec());
				
				$coordinates = $response->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;

				if ($coordinates) {
					$cache->write($cache_id, $coordinates, $this->_geocode_cache_expire); // cache lifetime in minutes
				}

			}
			// fill data from the cache
			else {
				$coordinates = $cachedData['data'];
			}

			// coordinates is an array, split and return
			if ($coordinates) {
				return $coordinates;
			}
			// return default coordinates
			else {
				return $this->_default_coordinates;
			}
		}

	/*-------------------------------------------------------------------------
		Settings:
	-------------------------------------------------------------------------*/

		public function displaySettingsPanel(&$wrapper, $errors=NULL) {
			parent::displaySettingsPanel($wrapper, $errors);

			$label = Widget::Label('Default Address Location');
			$label->appendChild(Widget::Input('fields[' . $this->get('sortorder') . '][default_location]', $this->get('default_location')));
			$wrapper->appendChild($label);
			
			$label = Widget::Label('Default Marker Location');
			$label->appendChild(Widget::Input('fields['.$this->get('sortorder').'][default_location_coords]', $this->get('default_location_coords')));
			$wrapper->appendChild($label);

			$label = Widget::Label('Default Zoom Level');
			$label->appendChild(Widget::Input('fields['.$this->get('sortorder').'][default_zoom]', $this->get('default_zoom')));
			$wrapper->appendChild($label);

			$this->appendShowColumnCheckbox($wrapper);
		}

		public function commit() {
			if(!parent::commit()) 
				return false;

			$id = $this->get('id');

			if($id === false) 
				return false;

			$fields = array();

			$fields['field_id'] = $id;
			$fields['default_location'] = $this->get('default_location');
			$fields['default_zoom'] = $this->get('default_zoom');

			if(!$fields['default_location']) 
				$fields['default_location'] = $this->_default_location;
				
			$fields['default_location_coords'] = self::__geocodeAddress($fields['default_location']);

			if(!$fields['default_zoom']) 
				$fields['default_zoom'] = $this->_default_zoom;

			Symphony::Database()->query("DELETE FROM `tbl_fields_".$this->handle()."` WHERE `field_id` = '$id' LIMIT 1");

			return Symphony::Database()->insert($fields, 'tbl_fields_' . $this->handle());
		}

	/*-------------------------------------------------------------------------
		Publish:
	-------------------------------------------------------------------------*/

		public function displayPublishPanel(&$wrapper, $data=NULL, $flagWithError=NULL, $fieldnamePrefix=NULL, $fieldnamePostfix=NULL, $entry_id=NULL) {
			if (class_exists('Administration') && Administration::instance()->Page) {
				Administration::instance()->Page->addScriptToHead('http://api-maps.yandex.ru/1.1/index.xml?key=' . $this->_api_key, 79);
				Administration::instance()->Page->addStylesheetToHead(URL . '/extensions/ymaplocationfield/assets/ymaplocationfield.publish.css', 'screen', 78);
				Administration::instance()->Page->addScriptToHead(URL . '/extensions/ymaplocationfield/assets/ymaplocationfield.publish.js', 80);
			}

			// input values
			$coordinates = array($data['longitude'], $data['latitude']);
			$centre = $data['centre'];
			$zoom = $data['zoom'];
			$address = $data['address'];

			// get defaults for new entries
			if (reset($coordinates) == null) 
				$coordinates = explode(',', $this->get('default_location_coords'));
			if ($centre == null) 
				$centre = $this->get('default_location_coords');
			if ($zoom == null) 
				$zoom = $this->get('default_zoom');
			if($address == null)
				$address = $this->get('default_location');

			$label = Widget::Label('Address');
			$label->setAttribute('class', 'address');
			$label->appendChild(Widget::Input('fields' . $fieldnamePrefix . '[' . $this->get('element_name') . '][address]' . $fieldnamePostfix, $address));
			
			$button = new XMLElement('input');
			$button->setAttribute('type', 'button');
			$button->setAttribute('value', 'Find');
			$button->setAttribute('name', 'fields' . $fieldnamePrefix . '[' . $this->get('element_name') . '][find]' . $fieldnamePostfix);

			$label->appendChild($button);
			$wrapper->appendChild($label);
				
			$label = Widget::Label('Marker Longitude/Latitude');
			$label->setAttribute('class', 'coordinates');
			$label->appendChild(Widget::Input('fields'.$fieldnamePrefix.'['.$this->get('element_name').'][coordinates]'.$fieldnamePostfix, join(', ', $coordinates)));
			$wrapper->appendChild($label);

			$label = Widget::Label('Centre Longitude/Latitude');
			$label->setAttribute('class', 'centre');
			$label->appendChild(Widget::Input('fields'.$fieldnamePrefix.'['.$this->get('element_name').'][centre]'.$fieldnamePostfix, $centre));
			$wrapper->appendChild($label);

			$label = Widget::Label('Zoom Level');
			$label->setAttribute('class', 'zoom');
			$label->appendChild(Widget::Input('fields'.$fieldnamePrefix.'['.$this->get('element_name').'][zoom]'.$fieldnamePostfix, $zoom));
			$wrapper->appendChild($label);
		}

		public function processRawFieldData($data, &$status, $simulate=false, $entry_id=NULL) {
			$status = self::__OK__;

			if (is_array($data)) {
				$coordinates = split(',', $data['coordinates']);

				$data = array(
					'longitude' => trim($coordinates[0]),
					'latitude' => trim($coordinates[1]),
					'centre' => $data['centre'],
					'zoom' => $data['zoom'],
					'address' => $data['address'],
				);
			}
			else {
				// Check that the $centre is actually a coordinate
				if (!preg_match('/^(-?[.0-9]+),\s?(-?[.0-9]+)$/', $data)) {
					$data = self::__geocodeAddress($data);
				}

				$coordinates = split(',', $data);

				$data = array(
					'longitude' => trim($coordinates[0]),
					'latitude' => trim($coordinates[1]),
					'centre' => $data,
					'zoom' => $this->get('default_zoom')
				);
			}

			return $data;
		}

	/*-------------------------------------------------------------------------
		Output:
	-------------------------------------------------------------------------*/

		public function appendFormattedElement(&$wrapper, $data, $encode = false, $mode = null, $entry_id = null) {
			$field = new XMLElement($this->get('element_name'), null, array(
				'longitude' => $data['longitude'],
				'latitude' => $data['latitude'],
				'address' => $data['address'],
			));

			$map = new XMLElement('map', null, array(
				'zoom' => $data['zoom'],
				'centre' => $data['centre']
			));
			$field->appendChild($map);

			if (count($this->_filter_origin['latitude']) > 0) {
				$distance = new XMLElement('distance');
				$distance->setAttribute('from', $this->_filter_origin['latitude'] . ',' . $this->_filter_origin['longitude']);
				$distance->setAttribute('distance', extension_maplocationfield::geoDistance($this->_filter_origin['latitude'], $this->_filter_origin['longitude'], $data['latitude'], $data['longitude'], $this->_filter_origin['unit']));
				$distance->setAttribute('unit', ($this->_filter_origin['unit'] == 'k') ? 'km' : 'miles');
				$field->appendChild($distance);
			}

			$wrapper->appendChild($field);
		}

		public function prepareTableValue($data, XMLElement $link = null, $entry_id = null) {
			if (empty($data)) 
				return;

			$zoom = (int)$data['zoom'] - 2;
			
			if ($zoom < 1) 
				$zoom = 1;
				
			$lngLat = implode(',', array($data['longitude'], $data['latitude']));
			$address = $data['address'];

			return sprintf(
				"<p><b>%s</b></p><img src='http://static-maps.yandex.ru/1.x/?ll=%s&size=150,150&z=%d&l=map&pt=%s,pmyws&key=%s' alt=''/>",
				$address,
				$lngLat,
				$zoom,
				$lngLat,
				$this->_api_key
			);
		}
	}
