<?php

	Class fieldNumber extends Field {

		public function __construct(&$parent) {
			parent::__construct($parent);
			$this->_name = __('Number');
			$this->_required = true;
			$this->set('required', 'no');
		}

	/*-------------------------------------------------------------------------
		Setup:
	-------------------------------------------------------------------------*/

		public function isSortable() {
			return true;
		}

		public function canFilter() {
			return true;
		}

		public function allowDatasourceOutputGrouping() {
			return true;
		}

		public function allowDatasourceParamOutput() {
			return true;
		}

		public function canPrePopulate() {
			return true;
		}

		public function createTable() {
			return Symphony::Database()->query(
				"CREATE TABLE IF NOT EXISTS `tbl_entries_data_" . $this->get('id') . "` (
				  `id` int(11) unsigned NOT NULL auto_increment,
				  `entry_id` int(11) unsigned NOT NULL,
				  `value` double default NULL,
				  PRIMARY KEY  (`id`),
				  KEY `entry_id` (`entry_id`),
				  KEY `value` (`value`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
			);
		}

	/*-------------------------------------------------------------------------
		Settings:
	-------------------------------------------------------------------------*/

		public function displaySettingsPanel(&$wrapper, $errors=NULL) {
			parent::displaySettingsPanel($wrapper, $errors);

			$div = new XMLElement('div', NULL, array('class' => 'compact'));
			$this->appendRequiredCheckbox($div);
			$this->appendShowColumnCheckbox($div);
			$wrapper->appendChild($div);
		}

	/*-------------------------------------------------------------------------
		Input:
	-------------------------------------------------------------------------*/

		public function displayPublishPanel(&$wrapper, $data=NULL, $flagWithError=NULL, $fieldnamePrefix=NULL, $fieldnamePostfix=NULL){

			$value = $data['value'];
			$label = Widget::Label($this->get('label'));
			if($this->get('required') != 'yes') {
				$label->appendChild(new XMLElement('i', __('Optional')));
			}
			$label->appendChild(
				Widget::Input(
					'fields'.$fieldnamePrefix.'['.$this->get('element_name').']'.$fieldnamePostfix,
					(strlen($value) != 0 ? $value : NULL)
				)
			);

			if($flagWithError != NULL) {
				$wrapper->appendChild(Widget::wrapFormElementWithError($label, $flagWithError));
			}
			else {
				$wrapper->appendChild($label);
			}
		}

		public function checkPostFieldData($data, &$message, $entry_id=NULL) {
			$message = NULL;

			if($this->get('required') == 'yes' && strlen($data) == 0) {
				$message = __('This is a required field.');
				return self::__MISSING_FIELDS__;
			}

			if(strlen($data) > 0 && !is_numeric($data)) {
				$message = __('Must be a number.');
				return self::__INVALID_FIELDS__;
			}

			return self::__OK__;
		}

	/*-------------------------------------------------------------------------
		Filtering:
	-------------------------------------------------------------------------*/

		public function buildDSRetrivalSQL($data, &$joins, &$where, $andOperation=false) {

			// X to Y support
			if(preg_match('/^(-?(?:\d+(?:\.\d+)?|\.\d+)) to (-?(?:\d+(?:\.\d+)?|\.\d+))$/i', $data[0], $match)) {

				$field_id = $this->get('id');

				$joins .= " LEFT JOIN `tbl_entries_data_$field_id` AS `t$field_id` ON (`e`.`id` = `t$field_id`.entry_id) ";
				$where .= " AND `t$field_id`.`value` BETWEEN {$match[1]} AND {$match[2]} ";

			}

			// Equal to or less/greater than X
			else if(preg_match('/^(equal to or )?(less|greater) than (-?(?:\d+(?:\.\d+)?|\.\d+))$/i', $data[0], $match)) {
				$field_id = $this->get('id');

				$expression = " `t$field_id`.`value` ";

				switch($match[2]) {
					case 'less':
						$expression .= '<';
						break;

					case 'greater':
						$expression .= '>';
						break;
				}

				if($match[1]){
					$expression .= '=';
				}

				$expression .= " {$match[3]} ";

				$joins .= " LEFT JOIN `tbl_entries_data_$field_id` AS `t$field_id` ON (`e`.`id` = `t$field_id`.entry_id) ";
				$where .= " AND $expression ";

			}

			else parent::buildDSRetrivalSQL($data, $joins, $where, $andOperation);

			return true;
		}

	/*-------------------------------------------------------------------------
		Grouping:
	-------------------------------------------------------------------------*/

		public function groupRecords($records) {
			if(!is_array($records) || empty($records)) return;

			$groups = array($this->get('element_name') => array());

			foreach($records as $r) {
				$data = $r->getData($this->get('id'));

				$value = $data['value'];

				if(!isset($groups[$this->get('element_name')][$value])) {
					$groups[$this->get('element_name')][$value] = array(
						'attr' => array('value' => $value),
						'records' => array(),
						'groups' => array()
					);
				}

				$groups[$this->get('element_name')][$value]['records'][] = $r;

			}

			return $groups;
		}

	}
