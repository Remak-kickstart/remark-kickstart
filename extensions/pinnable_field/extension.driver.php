<?php
	
	/**
	 * @package pinnable_field
	 */
	
	/**
	 * Place a pin on a custom map image.
	 */
	class Extension_Pinnable_Field extends Extension {
		protected $addedHeaders = false;
		
		/**
		 * Extension information.
		 */
		public function about() {
			return array(
				'name'			=> 'Field: Pinnable',
				'version'		=> '0.1',
				'release-date'	=> '2011-05-31',
				'author'		=> array(
					'name'			=> 'Rowan Lewis',
					'website'		=> 'http://rowanlewis.com/',
					'email'			=> 'me@rowanlewis.com'
				),
				'description'	=> 'Place a pin on a custom map image.'
			);
		}
		
		/**
		 * Cleanup installation.
		 */
		public function uninstall() {
			$this->_Parent->Database->query("DROP TABLE `tbl_fields_pinnable`");
		}
		
		/**
		 * Create tables and configuration.
		 */
		public function install() {
			$this->_Parent->Database->query("
				CREATE TABLE IF NOT EXISTS `tbl_fields_pinnable` (
					`id` int(11) unsigned NOT NULL auto_increment,
					`field_id` int(11) unsigned NOT NULL,
					`image_url` text NOT NULL,
					PRIMARY KEY  (`id`),
					KEY `field_id` (`field_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
			
			return true;
		}
		
		public function addHeaders($page) {
			if (!is_null($page) && !$this->addedHeaders) {
				$page->addStylesheetToHead(URL . '/extensions/pinnable_field/assets/publish.css');
				$page->addScriptToHead(URL . '/extensions/pinnable_field/assets/publish.js');
				
				$this->addedHeaders = true;
			}
		}
	}
	
?>