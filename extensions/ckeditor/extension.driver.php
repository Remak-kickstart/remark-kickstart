<?php
	require_once(TOOLKIT . '/class.sectionmanager.php');
	
	Class extension_ckeditor extends Extension
	{
        protected $addedCKEditorHeaders = false;
        protected $sections;

		/**
		 * Extension information
		 */		 
		public function about() {
			return array(
				'name' => 'Text Formatter: CKEditor',
				'version' => '1.2.4',
				'release-date' => '2011-12-12',
				'author' => array(
					'name'     => '<a href="http://thecocoabots.com">Tony Arnold</a>, <a href="http://gielberkers.com">Giel Berkers</a>'
				),
				'description' => 'Includes CKEditor, a web-based XHTML editor developed by Frederico Knabben. It also has an integrated file browser which uses Symphony sections to get it\'s files from.'
			);
		}
	
		/**
		 * Add callback functions to backend delegates
		 */	
		public function getSubscribedDelegates(){
			return array(
				array('page'		=>	'/backend/',
					  'delegate'	=>	'ModifyTextareaFieldPublishWidget',
					  'callback'	=>	'applyCKEditor'),
				      
				array('page'		=>	'/backend/',
					  'delegate'	=>	'ModifyTextBoxFullFieldPublishWidget',
					  'callback'	=>	'applyCKEditor'),
				
				array('page'		=> '/system/preferences/',
					  'delegate'	=> 'AddCustomPreferenceFieldsets',
					  'callback'	=> 'appendPresets'),
				
				array('page'		=> '/system/preferences/',
					  'delegate'	=> 'Save',
					  'callback'	=> 'savePresets')
			);
		}
		
		/**
		 * Append presets
		 */
		public function appendPresets($context)
		{
            $wrapper = $context['wrapper'];

			$fieldset = new XMLElement('fieldset', '', array('class'=>'settings'));
			$fieldset->appendChild(new XMLElement('legend', __('CKEditor File Browser')));
			$fieldset->appendChild(new XMLElement('p', __('Please select the sections that are permitted to use the CKEditor file browser:')));
			
			$sectionManager = new SectionManager($this);
			$sections = $sectionManager->fetch();
			
			// Check which sections are allowed:
			$data = Symphony::Configuration()->get('sections', 'ckeditor');
			$checkedSections = $data != false ? explode(',', $data) : array();
			
			// Bugfix for if there are no sections found:
			if($sections)
			{
				$options = array();
				foreach($sections as $section)
				{
					$options[] = array($section->get('id'), in_array($section->get('id'), $checkedSections), $section->get('name'));
				}
				$fieldset->appendChild(Widget::Select('ckeditor_sections[]', $options, array('multiple'=>'multiple')));
			}

            // Link templates for CKEditor, only for 2.3+:
            if(version_compare(Administration::Configuration()->get('version', 'symphony'), '2.2.5', '>'))
            {
                $sections = SectionManager::fetch();
                $this->sections = array();
                foreach($sections as $s)
                {
                    $a = array('id'=>$s->get('id'), 'name'=>$s->get('name'), 'fields'=>array());
                    $fields = FieldManager::fetch(null, $s->get('id'));
                    foreach($fields as $field)
                    {
                        // For now, only allow fields of the type 'input' to be used as a handle:
                        if($field->get('type') == 'input')
                        {
                            $a['fields'][] = array('id'=>$field->get('id'), 'label'=>$field->get('label'), 'element_name'=>$field->get('element_name'));
                        }
                    }
                    $this->sections[] = $a;
                }

                $fieldset->appendChild(new XMLElement('p', __('Link templates:')));
                $ol = new XMLElement('ol');
                $ol->setAttribute('id', 'fields-duplicator');

                $pages = PageManager::fetch();
                $templates = Symphony::Database()->fetch('SELECT * FROM `tbl_ckeditor_link_templates`;');
                if(!is_array($pages)) $pages = array($pages);

                foreach($pages as $page)
                {
                    foreach($templates as $template) {
                        if($template['page_id'] != $page['id']) continue;
                        $duplicator = $this->__buildDuplicatorItem($page, $template);
                        $ol->appendChild($duplicator);
                    }

                    $duplicator = $this->__buildDuplicatorItem($page, NULL);
                    $ol->appendChild($duplicator);
                }

                $fieldset->appendChild($ol);
            }

			$wrapper->appendChild($fieldset);

            // Some JavaScript:
            $wrapper->appendChild(new XMLElement('script', '
                jQuery(function($){
                    var first = true;
                    $("select[name^=ckeditor_link_templates][name$=\'[section_id]\']").change(function(){
                        var label = $(":selected", this).text();
                        $("optgroup, option", $(this).parent().next()).hide();
                        $("optgroup[label=" + label + "], optgroup[label=" + label + "] option", $(this).parent().next()).show();
                        if(!first)
                        {
                            $("option:first", $(this).parent().next()).show().attr("selected", "selected");
                        }
                    }).change();
                    first = false;
                });
            ', array('type'=>'text/javascript')));
		}


        private function __buildDuplicatorItem($page, $template=NULL) {
            // value of -1 signifies a duplicator "template"
            $index = ($template == NULL) ? '-1' : $template['id'];

            $wrapper = new XMLElement('li');
            $wrapper->setAttribute('class', ($template == NULL) ? 'template' : '');

            $wrapper->appendChild(new XMLElement('h4', $page['title']));

            $divgroup = new XMLElement('div');

            $label = Widget::Label(__('Link template') . '<i>' . __('Use {$param} for field-placeholders') . '</i>');
            $label->appendChild(Widget::Input(
                "ckeditor_link_templates[" . $index . "][link]",
                General::sanitize($template['link']
            )));
            $divgroup->appendChild($label);
            $wrapper->appendChild($divgroup);
            
            $divgroup = new XMLElement('div', null, array('class'=>'group'));
            
            $label = Widget::Label(__('Section to get the entries from'));
            $options = array();
            foreach($this->sections as $section)
            {
                $options[] = array($section['id'], $template['section_id'] == $section['id'], $section['name']);
            }
/*            $label->appendChild(Widget::Select('ckeditor_link_templates[' . $index . '][section]', $options, array('onchange'=>
                "jQuery('optgroup[label!=' + jQuery(this).val() + '], optgroup[label!=' + jQuery(this).val() + '] option', jQuery(this).parent().parent()).hide()")));*/
            $label->appendChild(Widget::Select('ckeditor_link_templates[' . $index . '][section_id]', $options));
            $divgroup->appendChild($label);

            $label = Widget::Label(__('Field to display as name'));
            $options = array(array('', false, 0));
            foreach($this->sections as $section)
            {
                $fields = array();
                foreach($section['fields'] as $field)
                {
                    $fields[] = array($field['id'], $template['field_id'] == $field['id'], $field['label']);
                }
                $options[] = array('label'=>$section['name'], 'options'=>$fields);
            }
            $label->appendChild(Widget::Select('ckeditor_link_templates[' . $index . '][field_id]', $options));
            $divgroup->appendChild($label);

            $wrapper->appendChild(new XMLElement('input', NULL, array(
                'type' => 'hidden',
                'name' => 'ckeditor_link_templates[' . $index . '][page_id]',
                'value' => $page['id']
            )));

            $wrapper->appendChild($divgroup);

            return $wrapper;

        }
		
		/**
		 * Save the presets
		 */
		public function savePresets($context)
		{
			if(isset($_POST['ckeditor_sections'])) {
                // Save the link templates to the database:
                Symphony::Database()->query("DELETE FROM `tbl_ckeditor_link_templates`");

                $shortcuts = $_POST['ckeditor_link_templates'];
                unset($_POST['ckeditor_link_templates']);

                if(!empty($shortcuts))
                {
                    foreach($shortcuts as $i => $shortcut) {
                        Symphony::Database()->insert($shortcut, "tbl_ckeditor_link_templates");
                    }
                }

                // Save the sections to the config-file
				$sectionStr = implode(',', $_POST['ckeditor_sections']);
                Symphony::Configuration()->set('sections', $sectionStr, 'ckeditor');
                if(version_compare(Administration::Configuration()->get('version', 'symphony'), '2.2.5', '>'))
                {
                    // 2.3 and up:
                    Symphony::Configuration()->write();
                } else {
                    // Earlier versions:
                    Administration::instance()->saveConfig();
                }

			} else {
				// If no sections are selected, delete the file:
                Symphony::Configuration()->remove('sections', 'ckeditor');
                Administration::instance()->saveConfig();
			}

		}

        /**
         * Install CKEditor
         * @return void
         */
        public function install()
        {
            Symphony::Database()->query("
                CREATE TABLE IF NOT EXISTS `tbl_ckeditor_link_templates` (
                `id` int(11) NOT NULL auto_increment,
                `link` varchar(255) NOT NULL,
                `field_id` int(11) NOT NULL,
                `section_id` int(11) NOT NULL,
                `page_id` int(11) NOT NULL,
                `sort_order` int(11) NOT NULL,
                PRIMARY KEY (`id`)
                )
    		");
        }

        /**
         * Update CKEditor
         * @return void
         */
        public function update($prevVersion)
        {
            if(version_compare($prevVersion, '1.2.4', '<'))
            {
                $this->install();
            }
        }

		/**
		 * On uninstall, delete the ckeditor_sections-file
		 */
		public function uninstall()
		{
			Symphony::Configuration()->remove('sections', 'ckeditor');
			Administration::instance()->saveConfig();
            Symphony::Database()->query("DROP TABLE `tbl_ckeditor_link_templates`");
		}
		
		/**
		 * Load and apply CKEditor
		 */		 
		public function applyCKEditor($context) {

			$format = $context['field']->get('text_formatter') == TRUE ? 'text_formatter' : 'formatter';


			if(($context['field']->get($format) != 'ckeditor' && $context['field']->get($format) != 'ckeditor_compact')) return;
			
			if(!$this->addedCKEditorHeaders){
				Administration::instance()->Page->addScriptToHead(URL . '/extensions/ckeditor/lib/ckeditor/ckeditor.js', 200, false);
				Administration::instance()->Page->addScriptToHead(URL . '/extensions/ckeditor/assets/symphony.ckeditor.js', 210, false);
				Administration::instance()->Page->addStylesheetToHead(URL . '/extensions/ckeditor/assets/symphony.ckeditor.css', 'screen', 30);
				
				$this->addedCKEditorHeaders = true;
			}
		}
		
	}

