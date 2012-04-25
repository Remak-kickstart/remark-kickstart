<?php
	
	/**
	 * @package pinnable_field
	 */
	
	if (!defined('__IN_SYMPHONY__')) die('<h2>Symphony Error</h2><p>You cannot directly access this file</p>');
	
	class FieldPinnable extends Field {
		protected $_driver = null;
		public $_ignore = array();
		
	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/
		
		public function __construct(&$parent) {
			parent::__construct($parent);
			
			$this->_name = 'Pinnable';
			$this->_required = true;
		}
		
		public function createTable() {
			$field_id = $this->get('id');
			
			return Symphony::Database()->query("
				CREATE TABLE IF NOT EXISTS `tbl_entries_data_{$field_id}` (
					`id` INT(11) NOT NULL auto_increment,
					`entry_id` INT(11) UNSIGNED NOT NULL,
					`position_x` decimal(6,3) DEFAULT NULL,
					`position_y` decimal(6,3) DEFAULT NULL,
					PRIMARY KEY  (`id`),
					KEY `entry_id` (`entry_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			");
		}
		
	/*-------------------------------------------------------------------------
		Settings:
	-------------------------------------------------------------------------*/
		
		public function checkFields(&$errors, $checkForDuplicates = true) {
			if (!filter_var($this->get('image_url'), FILTER_VALIDATE_URL)) {
				$errors['image_url'] = 'Please enter a valid URL.';
			}

			parent::checkFields($errors, $checkForDuplicates);
		}

		public function displaySettingsPanel($wrapper, $errors = null) {
			parent::displaySettingsPanel($wrapper, $errors);
			
			$order = $this->get('sortorder');
			$label = Widget::Label(__('Image URL'));
			$label->appendChild(Widget::Input(
				"fields[{$order}][image_url]",
				$this->get('image_url')
			));

			if (isset($errors['image_url'])) {
				$label = Widget::wrapFormElementWithError($label, $errors['image_url']);
			}

			$wrapper->appendChild($label);
			
			$this->appendShowColumnCheckbox($wrapper);
		}
		
		public function commit() {
			if (!parent::commit()) return false;

			$field_id = $this->get('id');
			$table = 'tbl_fields_' . $this->handle();

			$fields = array(
				'field_id'	=> $field_id,
				'image_url'	=> $this->get('image_url')
			);

			Symphony::Database()->query(sprintf("
				DELETE FROM
					`%s`
				WHERE
					`field_id` = %d
				LIMIT 1
				",
				$table,
				$field_id
			));

			return Symphony::Database()->insert($fields, $table);
		}
		
	/*-------------------------------------------------------------------------
		Publish:
	-------------------------------------------------------------------------*/
		
		public function displayPublishPanel($wrapper, $data = null, $error = null, $prefix = null, $suffix = null, $entry_id = null) {
			$handle = $this->get('element_name');
			$driver = Symphony::ExtensionManager()->create('pinnable_field');
			$driver->addHeaders(Symphony::Engine()->Page);
			
			$name_x = sprintf(
				'fields%s[%s][position_x]%s',
				$prefix, $handle, $suffix
			);
			$name_y = sprintf(
				'fields%s[%s][position_y]%s',
				$prefix, $handle, $suffix
			);
			$value_x = (
				isset($data['position_x'])
					? $data['position_x']
					: null
			);
			$value_y = (
				isset($data['position_y'])
					? $data['position_y']
					: null
			);
			
			$label = Widget::Label($this->get('label'));
			$wrapper->appendChild($label);
			
			$map = new XMLElement('div');
			$map->setAttribute('class', 'map');
			$map->setAttribute('data-position-x', $value_x);
			$map->setAttribute('data-position-y', $value_y);
			
			$map->appendChild(Widget::Input(
				$name_x, $value_x, 'hidden'
			));
			$map->appendChild(Widget::Input(
				$name_y, $value_y, 'hidden'
			));
			
			$image = new XMLElement('img');
			$image->setAttribute('src', $this->get('image_url'));
			$map->appendChild($image);
			$wrapper->appendChild($map);
		}
		
	/*-------------------------------------------------------------------------
		Input:
	-------------------------------------------------------------------------*/
		
		public function processRawFieldData($data, &$status, $simulate = false, $entry_id = null) {
			$field_id = $this->get('id');
			$status = self::__OK__;
			
			if (!is_array($data)) $data = array($data);
			
			if (empty($data)) return null;
			
			$result = array(
				'position_x'	=> (
					isset($data['position_x'])
						? $data['position_x']
						: null
				),
				'position_y'	=> (
					isset($data['position_y'])
						? $data['position_y']
						: null
				)
			);
			
			return $result;
		}
		
	/*-------------------------------------------------------------------------
		Output:
	-------------------------------------------------------------------------*/
		
		public function appendFormattedElement($wrapper, $data) {
			$element = new XMLElement($this->get('element_name'));
			$element->setAttribute('position-x', $data['position_x']);
			$element->setAttribute('position-y', $data['position_y']);
			$element->setAttribute('image-url', $this->get('image_url'));
			
			$wrapper->appendChild($element);
		}
		
		public function prepareTableValue($data, XMLElement $link = null) {
			if (empty($data) || !isset($data['position_x']) || !isset($data['position_y'])) {
				return parent::prepareTableValue(null, $link);
			}
			
			return parent::prepareTableValue(
				array(
					'value'		=> sprintf('%dx%d', $data['position_x'], $data['position_y'])
				), $link
			);
		}
	}
	
?>
