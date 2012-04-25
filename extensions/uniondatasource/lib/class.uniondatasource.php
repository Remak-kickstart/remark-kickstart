<?php

require_once(TOOLKIT . '/class.entrymanager.php');
require_once(TOOLKIT . '/class.datasourcemanager.php');

Class UnionDatasource extends Datasource {

	/**
	 * An array of Field objects, used to stop unnecessary creation of field objects
	 * @var array
	 */
	public static $field_pool = array();

	/**
	 * @var DatasourceManager
	 */
	public static $datasourceManager = null;

	/**
	 * @var EntryManager
	 */
	public static $entryManager = null;

	/**
	 * An associative array of the datasources that should become one.
	 * This has two keys, `datasource` and `entries`
	 * @var array
	 */
	public $datasources = array();

	/**
	 * Called from the Datasource, this function will loop over `dsParamUNION`
	 * and create new Datasource objects.
	 *
	 * @param array $param_pool
	 * @return XMLElement
	 */
	public function grab(&$param_pool = null) {
		if(!isset(self::$datasourceManager)) {
			self::$datasourceManager = new DatasourceManager(Symphony::Engine());
		}

		if(!isset(self::$entryManager)) {
			self::$entryManager = new EntryManager(Symphony::Engine());
		}

		// Loop over all the unions and get a Datasource object
		foreach($this->dsParamUNION as $handle) {
			$this->datasources[$handle]['datasource'] = self::$datasourceManager->create(
				str_replace('-','_', $handle), $this->_env, true
			);

			$this->datasources[$handle]['section'] = self::$entryManager->sectionManager->fetch(
				$this->datasources[$handle]['datasource']->getSource()
			);
		}

		$this->data = array();
		// Loop over all the datasource objects, getting the Entry ID's
		foreach($this->datasources as $handle => $datasource) {
			$data = $this->grab_sql($datasource['datasource']);

			if(!isset($data['section'])) continue;

			$this->data['section'][key($data['section'])] = current($data['section']);
			$this->data['sort'][] = $data['sort'];
			$this->data['sql'][] = $data['sql'];
		}

		$entries = $this->fetchByPage(1, $this->dsParamLimit);

		/**
		 * Immediately after building entries allow modification of the Data Source entry list
		 *
		 * @delegate DataSourceEntriesBuilt
		 * @param string $context
		 * '/frontend/'
		 * @param Datasource $datasource
		 * @param array $entries
		 * @param array $filters
		 */
		Symphony::ExtensionManager()->notifyMembers('DataSourceEntriesBuilt', '/frontend/', array(
			'datasource' => &$this,
			'entries' => &$entries,
			'filters' => $this->dsParamFILTERS
		));

		return $this->output($entries, $param_pool);
	}

	/**
	 * Given a Datasource, return an array of Entry objects. This takes into account
	 * all filtering, sorting of each of the datasources before the union takes place.
	 * The majority of this code is sliced from Symphony's `datasource.section.php` file.
	 *
	 * @param Datasource $datasource
	 * @return array
	 *  An array of Entry objects for the given `$datasource`
	 */
	public function grab_sql(Datasource $datasource) {
		$where = NULL;
		$joins = NULL;
		$group = false;

		if(!$section = self::$entryManager->sectionManager->fetch($datasource->getSource())){
			$about = $datasource->about();
			trigger_error(__('The section associated with the data source <code>%s</code> could not be found.', array($about['name'])), E_USER_ERROR);
		}

		if(is_array($datasource->dsParamFILTERS) && !empty($datasource->dsParamFILTERS)){
			foreach($datasource->dsParamFILTERS as $field_id => $filter){
				if((is_array($filter) && empty($filter)) || trim($filter) == '') continue;

				if(!is_array($filter)){
					$filter_type = $this->__determineFilterType($filter);

					$value = preg_split('/'.($filter_type == DS_FILTER_AND ? '\+' : '(?<!\\\\),').'\s*/', $filter, -1, PREG_SPLIT_NO_EMPTY);
					$value = array_map('trim', $value);
					$value = array_map(array('Datasource', 'removeEscapedCommas'), $value);
				}

				else $value = $filter;

				if(!isset(self::$field_pool[$field_id]) || !is_object(self::$field_pool[$field_id]))
					self::$field_pool[$field_id] =& self::$entryManager->fieldManager->fetch($field_id);

				if($field_id != 'id' && $field_id != 'system:date' && !(self::$field_pool[$field_id] instanceof Field)){
					throw new Exception(
						__(
							'Error creating field object with id %1$d, for filtering in data source "%2$s". Check this field exists.',
							array($field_id, $datasource->dsParamROOTELEMENT)
						)
					);
				}

				if($field_id == 'id') {
					$where = " AND `e`.id IN ('".implode("', '", $value)."') ";
				}
				else if($field_id == 'system:date') {
					require_once(TOOLKIT . '/fields/field.date.php');
					$date = new fieldDate(Frontend::instance());

					// Create an empty string, we don't care about the Joins, we just want the WHERE clause.
					$empty = "";
					$date->buildDSRetrievalSQL($value, $empty, $where, ($filter_type == DS_FILTER_AND ? true : false));

					$where = preg_replace('/`t\d+`.value/', '`e`.creation_date', $where);
				}
				else{
					// For deprecated reasons, call the old, typo'd function name until the switch to the
					// properly named buildDSRetrievalSQL function.
					if(!self::$field_pool[$field_id]->buildDSRetrivalSQL($value, $joins, $where, ($filter_type == DS_FILTER_AND ? true : false))){ $this->_force_empty_result = true; return; }
					if(!$group) $group = self::$field_pool[$field_id]->requiresSQLGrouping();
				}
			}
		}

		/**
		 * Instead of building Entries individually, build the where and join statements
		 * and return them. We'll make a custom `fetchByPage` function that can return
		 * the entry ID's and the values of the sort field.
		 */
		$data = array(
			'section' => array(
				$datasource->getSource() => array()
			),
			'sort' => ''
		);

		// SORTING
		$sort_field = null;

		// Handle random
		if($datasource->dsParamORDER == 'random') {
			$data['sort'] = 'ORDER BY RAND()';
		}
		// Handle 'system:id' or 'system:date' psuedo fields
		else if($datasource->dsParamSORT == 'system:id') {
			$data['sort'] = 'ORDER BY id ' . $datasource->dsParamORDER;
		}
		else if($datasource->dsParamSORT == 'system:date') {
			$data['sort'] = 'ORDER BY creation_date ' . $datasource->dsParamORDER;
		}
		// Handle real field instances
		else {
			$field = self::$entryManager->fieldManager->fetch(
				 self::$entryManager->fieldManager->fetchFieldIDFromElementName($datasource->dsParamSORT, $datasource->getSource())
			);

			$field->buildSortingSQL($joins, $where, $data['sort'], $datasource->dsParamORDER);

			if(!empty($data['sort'])) {
				// We just want the column that the field uses internally to sort by with MySQL
				// We'll use this field and sort in PHP instead
				preg_match('/ORDER BY[\s\S]*(`ed`\..*)[\s\S]*(ASC|DESC)$/i', $data['sort'], $sort_field);

				// The new ORDER BY syntax in Symphony 2.2.2 isn't compatible with what
				// we want for the purposes of UNION, so lets rewrite the ORDER BY to
				// what we do want (that is, if we have to)
				if(preg_match('/\(+/i', $data['sort'])) {
					$data['sort'] = 'ORDER BY ' . $sort_field[1] . ' ' . $sort_field[2];
				}

				$data['sort'] = preg_replace('/`ed`\./', '', $data['sort']);

				// New changes to sorting mean that there possibly wont't be a join
				// on the `ed` table. `ed` is commonly used to entries_data_. If the
				// join is omitted from `$joins`, we'll add the default join ourselves
				if(!preg_match('/`ed`/', $joins)) {
					$joins .= "LEFT OUTER JOIN `tbl_entries_data_" . $field->get('id') . "` AS `ed` ON (`e`.`id` = `ed`.`entry_id`)";
				}
			}
		}

		// combine INCLUDEDELEMENTS and PARAMOUTPUT into an array of field names
		$datasource_schema = $datasource->dsParamINCLUDEDELEMENTS;
		if (!is_array($datasource_schema)) $datasource_schema = array();
		if ($datasource->dsParamPARAMOUTPUT) $datasource_schema[] = $datasource->dsParamPARAMOUTPUT;
		if ($datasource->dsParamGROUP) $datasource_schema[] = self::$entryManager->fieldManager->fetchHandleFromID($datasource->dsParamGROUP);

		$data['section'][$datasource->getSource()] = $datasource_schema;
		$data['sql'] = sprintf("
				SELECT `e`.id as id, `e`.section_id, e.`author_id`, UNIX_TIMESTAMP(e.`creation_date`) AS `creation_date`%s
				FROM `tbl_entries` AS `e`
				%s
				WHERE `e`.`section_id` = %d
				%s
			",
			(is_array($sort_field) ? ', ' . $sort_field[1] : ''),
			$joins,
			$datasource->getSource(),
			$where
		);

		return $data;
	}

	/**
	 * Given an associative array containing the total rows that could be found
	 * for these datasources, and an array of Entries for the current pagination
	 * settings, output the Entries as XML. This uses the Entry datasources, not
	 * this datasource to create Parameters and uses their `dsParamINCLUDEDELEMENTS`.
	 * The majority of this code is sliced from Symphony's `datasource.section.php` file.
	 *
	 * @param array $entries
	 * @param array $param_pool
	 * @todo Grouping
	 *  Grouping will be very difficult with UnionDS. The current Grouping works on an
	 *  array level, rather then the springs to mind SQL GROUP BY. Grouping calls the
	 *  grouped field's `groupRecords` function, which loops over the `$entries` array
	 *  getting the data for the grouped field. The problem is that this uses the field_id,
	 *  so it cannot apply to other entries who are in different sections. This code untouchable
	 *  inside the Field class, so it would require something fairly crude I'd imagine to
	 *  replicate. Perhaps the `$entries` would have to be dissolved into same section groups and
	 *  run a group on each section before merging the array together... which has it's own set
	 *  of problems, not happening anytime soon unfortunately.
	 */
	public function output($entries, &$param_pool) {
		if(!isset($entries['records'])) {
			if($this->dsParamREDIRECTONEMPTY == 'yes'){
				throw new FrontendPageNotFoundException;
			}
			$result = $this->emptyXMLSet();
		}
		else {
			$result = new XMLElement($this->dsParamROOTELEMENT);
		}

		// Add Pagination
		if(is_array($this->dsParamINCLUDEDELEMENTS) && in_array('system:pagination', $this->dsParamINCLUDEDELEMENTS)) {
			$pagination_element = General::buildPaginationElement(
				isset($entries['total-entries']) ? $entries['total-entries'] : 0,
				max(1, ceil($entries['total-entries'] * (1 / $this->dsParamLIMIT))),
				$this->dsParamLIMIT,
				$this->dsParamSTARTPAGE
			);

			if($pagination_element instanceof XMLElement && $result instanceof XMLElement){
				$result->prependChild($pagination_element);
			}
		}

		foreach($this->datasources as $handle => $datasource) {
			$result->appendChild(
				new XMLElement('section', $datasource['section']->get('name'), array(
					'id' => $datasource['section']->get('id'),
					'handle' => $datasource['section']->get('handle')
				))
			);
		}

		// If there is no records, return early
		if(!isset($entries['records'])) {
			return $result;
		}

		foreach($entries['records'] as $entry) {
			$datasource = null;
			$data = $entry->getData();

			$xEntry = new XMLElement('entry');
			$xEntry->setAttribute('id', $entry->get('id'));

			// Set the appropriate datasource for this entry
			foreach($this->datasources as $ds) {
				if($entry->get('section_id') !== $ds['datasource']->getSource()) continue;

				$datasource = $ds['datasource'];
				$section = $ds['section'];
			}

			$xEntry->setAttribute('section-handle', $section->get('handle'));
			$key = 'ds-' . $datasource->dsParamROOTELEMENT;

			// Add Associated Entry counts to the entry
			if (!isset($datasource->dsParamASSOCIATEDENTRYCOUNTS) || $datasource->dsParamASSOCIATEDENTRYCOUNTS == 'yes') {
				$associated_sections = $section->fetchAssociatedSections();

				if (is_array($associated_sections)) {
					$associated_entry_counts = $entry->fetchAllAssociatedEntryCounts($associated_sections);
					if(is_array($associated_entry_counts) && !empty($associated_entry_counts)){
						foreach($associated_entry_counts as $section_id => $count){
							foreach($associated_sections as $section) {
								if ($section['id'] == $section_id) $xEntry->setAttribute($section['handle'], (string)$count);
							}
						}
					}
				}
			}

			// Add the Symphony 'system:*' parameters to the param pool
			if(isset($datasource->dsParamPARAMOUTPUT)){
				if($datasource->dsParamPARAMOUTPUT == 'system:id') $param_pool[$key][] = $entry->get('id');
				elseif($datasource->dsParamPARAMOUTPUT == 'system:date') $param_pool[$key][] = DateTimeObj::get('c', $entry->creationDate);
				elseif($datasource->dsParamPARAMOUTPUT == 'system:author') $param_pool[$key][] = $entry->get('author_id');
			}

			foreach($data as $field_id => $values){
				// Check to see if we have a Field object already, if not create one
				if(!isset(self::$field_pool[$field_id]) || !self::$field_pool[$field_id] instanceof Field) {
					self::$field_pool[$field_id] =& self::$entryManager->fieldManager->fetch($field_id);
				}

				// Add the Datasource's parameters to the param pool.
				if(isset($datasource->dsParamPARAMOUTPUT) && $datasource->dsParamPARAMOUTPUT == self::$field_pool[$field_id]->get('element_name')){
					if(!isset($param_pool[$key]) || !is_array($param_pool[$key])) $param_pool[$key] = array();

					$param_pool_values = self::$field_pool[$field_id]->getParameterPoolValue($values);

					if(is_array($param_pool_values)){
						$param_pool[$key] = array_merge($param_pool_values, $param_pool[$key]);
					}
					else{
						$param_pool[$key][] = $param_pool_values;
					}
				}

				// Loop over the included elements and run appendFormattedElement
				if(is_array($datasource->dsParamINCLUDEDELEMENTS)) foreach ($datasource->dsParamINCLUDEDELEMENTS as $handle) {
					list($handle, $mode) = preg_split('/\s*:\s*/', $handle, 2);
					if(self::$field_pool[$field_id]->get('element_name') == $handle) {
						self::$field_pool[$field_id]->appendFormattedElement($xEntry, $values, ($datasource->dsParamHTMLENCODE ? true : false), $mode, $entry->get('id'));
					}
				}
			}

			$result->appendChild($xEntry);

			// Add in the system:date to the output
			if(is_array($datasource->dsParamINCLUDEDELEMENTS) && in_array('system:date', $datasource->dsParamINCLUDEDELEMENTS)){
				$xEntry->appendChild(
					General::createXMLDateObject(
						DateTimeObj::get('U', $entry->creationDate),
						'system-date'
					)
				);
			}
		}

		return $result;
	}

	/**
	 * 	This function `UNION ALL`'s the datasource SQL and then applies sorting
	 * and pagination to the query. Returns an array of Entry objects, with
	 * pagination given the number of Entry's to return and the current starting
	 * offset. eg. if there are 60 entries in a section and the pagination
	 * dictates that 15 entries per page are to be returned, by passing 2 to
	 * the `$page` parameter you could return entries 15-30.
	 *
	 * @param integer $page
	 *  The page to return, defaults to 1
	 * @param integer $entriesPerPage
	 *  The number of entries to return per page.
	 * @return array
	 *  Either an array of Entry objects, or an associative array containing
	 *  the total entries, the start position, the entries per page and the
	 *  Entry objects
	 */
	public function fetchByPage($page = 1, $entriesPerPage) {
		$group = false;
		$joins = '';
		$wheres = '';
		$order = '';

		if(empty($this->data['sql'])) return array();

		$sql = implode(" UNION ALL ", $this->data['sql']);

		// Add SQL_CALC_FOUND_ROWS to the first SELECT.
		$sql = preg_replace('/^SELECT `e`.id/', 'SELECT SQL_CALC_FOUND_ROWS `e`.id', $sql, 1);

		// Add the ORDER BY clause
		$sql = $sql . $this->data['sort'][0];

		// Apply Pagination
		if($this->dsParamPAGINATERESULTS == 'yes') {
			$sql = $sql . sprintf(' LIMIT %d, %d',
				($this->dsParamSTARTPAGE == 1) ? 0 : ($this->dsParamSTARTPAGE - 1) * $this->dsParamLIMIT,
				$this->dsParamLIMIT
			);
		}

		$rows = Symphony::Database()->fetch($sql);

		// Get the total rows for this query
		$total_rows = Symphony::Database()->fetchCol('total_rows', 'SELECT FOUND_ROWS() AS `total_rows`');
		$total_rows = $total_rows[0];

		// Build Entry objects
		return $this->buildEntries($rows, $total_rows, $this->data['section']);
	}

	/**
	 * Given an array of Entry data from `tbl_entries` and a section ID, return an
	 * array of Entry objects. For performance reasons, it's possible to pass an array
	 * of field handles via `$element_names`, so that only a subset of the section schema
	 * will be queried. This function currently only supports Entry from one section at a
	 * time.
	 *
	 * @param array $rows
	 *  An array of Entry data from `tbl_entries` including the Entry ID, Entry section,
	 *  the ID of the Author who created the Entry, and a Unix timestamp of creation
	 * @param integer $total_rows
	 *  The number of rows found without any pagination applied.
	 * @param array $element_names
	 *  Choose whether to get data from a subset of fields or all fields in a section,
	 *  by providing an array of field names. Defaults to null, which will load data
	 *  from all fields in a section.
	 * @return array
	 */
	public function buildEntries(array $id_list, $total_rows, $element_names = null){
		$entries = array();
		$schema_sql = array();

		if (empty($id_list)) return $entries;

		$field_names = array();

		// choose whether to get data from a subset of fields or all fields in a section
		if (!is_null($element_names) && is_array($element_names)){
			// allow for pseudo-fields containing colons (e.g. Textarea formatted/unformatted)
			foreach ($element_names as $section_id => $fields) {
				foreach($fields as $index => $name) {
					$parts = explode(':', $name, 2);

					if(count($parts) == 1) continue;

					unset($element_names[$section_id][$index]);

					if($parts[0] == "system") continue;

					$element_names[$section_id][$index] = trim($parts[0]);
				}

				if(!empty($element_names[$section_id])) {
					$schema_sql[] = sprintf(
						"SELECT `id` FROM `tbl_fields` WHERE `parent_section` = %d AND `element_name` IN ('%s')",
						$section_id,
						implode("', '", array_unique($element_names[$section_id]))
					);
				}
			}
		}
		else {
			// allow for pseudo-fields containing colons (e.g. Textarea formatted/unformatted)
			foreach ($element_names as $section_id => $fields) {
				$schema_sql[] = sprintf(
					"SELECT `id` FROM `tbl_fields` WHERE `parent_section` = %d",
					$section_id
				);
			}
		}

		$schema = array();
		foreach($schema_sql as $sql) {
			$schema = array_merge($schema, Symphony::Database()->fetch($sql));
		}

		$raw = array();
		$id_list_string = '';

		// Append meta data:
		foreach ($id_list as $row) {
			$raw[$row['id']]['meta'] = $row;
			$id_list_string .= $row['id'] . ',';
		}
		$id_list_string = trim($id_list_string, ',');

		// Append field data:
		foreach ($schema as $f) {
			$field_id = $f['id'];

			try{
				$row = Symphony::Database()->fetch("SELECT * FROM `tbl_entries_data_{$field_id}` WHERE `entry_id` IN ($id_list_string) ORDER BY `id` ASC");
			}
			catch(Exception $e){
				// No data due to error
				continue;
			}

			if (!is_array($row) || empty($row)) continue;

			foreach ($row as $r) {
				$entry_id = $r['entry_id'];

				unset($r['id']);
				unset($r['entry_id']);

				if (!isset($raw[$entry_id]['fields'][$field_id])) {
					$raw[$entry_id]['fields'][$field_id] = $r;
				}

				else {
					foreach ($r as $key => $value) {
						if (isset($raw[$entry_id]['fields'][$field_id][$key]) && !is_array($raw[$entry_id]['fields'][$field_id][$key])) {
							$raw[$entry_id]['fields'][$field_id][$key] = array($raw[$entry_id]['fields'][$field_id][$key], $value);
						}

						else if (!isset($raw[$entry_id]['fields'][$field_id][$key])) {
							$raw[$entry_id]['fields'][$field_id] = array($value);
						}

						else {
							$raw[$entry_id]['fields'][$field_id][$key][] = $value;
						}
					}
				}
			}
		}

		foreach ($raw as $entry) {
			$obj = self::$entryManager->create();

			$obj->creationDate = DateTimeObj::get('c', $entry['meta']['creation_date']);
			$obj->set('id', $entry['meta']['id']);
			$obj->set('author_id', $entry['meta']['author_id']);
			$obj->set('section_id', $entry['meta']['section_id']);

			if(isset($entry['fields']) && is_array($entry['fields'])){
				foreach ($entry['fields'] as $field_id => $data) $obj->setData($field_id, $data);
			}

			$entries['records'][] = $obj;
		}

		$entries['total-entries'] = $total_rows;

		return $entries;
	}
}