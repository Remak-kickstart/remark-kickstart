<?php

	class extension_ymaplocationfield extends Extension {
		public function about() {

			return array(
				'name'			=> 'Field: Yandex Map Location',
				'version'		=> '1.0.0',
				'release-date'	=> '2011-10-12',
				'author'		=> array(
					array(
						'name'		=> 'm-r Tarakanoff',
						'website'	=> 'http://jnet.kz/profile/tarakanoff/'
					)
				)
			);
		}
		
		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'AddCustomPreferenceFieldsets',
					'callback' => 'appendPreferences'
				),
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => '__SavePreferences'
				)
			);
		}

		public function install() {
			Symphony::Configuration()->set('api_key', '', 'yandex_map_location');
			Administration::instance()->saveConfig();
			
			return Symphony::Database()->query("CREATE TABLE `tbl_fields_ymaplocation` (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `field_id` int(11) unsigned NOT NULL,
			  `default_location` varchar(60) NOT NULL,
			  `default_location_coords` varchar(60) NOT NULL,
			  `default_zoom` int(11) unsigned NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `field_id` (`field_id`)
			) TYPE=MyISAM");
		}
		
		public function uninstall() {
			Symphony::Configuration()->remove('yandex_map_location');
			Symphony::Database()->query("DROP TABLE `tbl_fields_ymaplocation`");
		}
		
		public function appendPreferences($context) {
			$group = new XMLElement('fieldset');
			$group->setAttribute('class', 'settings');
			$group->appendChild(new XMLElement('legend', __('Field: Yandex Map Location')));

			$label = Widget::Label(__('Key (API)'));
			$label->appendChild(Widget::Input('yandex_maps_location_field[api_key]', Symphony::Configuration()->get('api_key', 'yandex_map_location')));

			$group->appendChild($label);

			$group->appendChild(new XMLElement('p', __('To be able to use the API Yandex.Maps, you need to <a href="http://api.yandex.ru/maps/form.xml">get a unique key</a>.'), array('class' => 'help')));

			$context['wrapper']->appendChild($group);
		}

		public function __SavePreferences($context) {
			$api_key = $_POST['yandex_maps_location_field']['api_key'];
			
			Symphony::Configuration()->set('api_key', $api_key, 'yandex_map_location');
			Administration::instance()->saveConfig();
		}
	}
