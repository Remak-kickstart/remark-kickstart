<?php
	require_once(TOOLKIT . '/class.administrationpage.php');
    require_once(TOOLKIT . '/class.sectionmanager.php');
    require_once(TOOLKIT . '/class.extensionmanager.php');
    require_once(TOOLKIT . '/class.datasourcemanager.php');
    require_once(TOOLKIT . '/class.eventmanager.php');

	Class contentExtensionPackagesIndex extends AdministrationPage
	{
		protected $_uri = null;
		protected $_driver = null;
		
		function __construct(&$parent){
			parent::__construct($parent);
			$this->_uri = URL . '/symphony/extension/packages/';
			$this->_driver = Symphony::ExtensionManager()->create('packages');
		}
		
		public function build($context)
		{
			if(Administration::instance()->Author->isDeveloper()) {
                if(isset($_POST['package-create']))
                {
                    $this->_driver->createPackage();
                }
                if(isset($_POST['package-import']))
                {
                    $this->_driver->importPackage();
                }
                if(isset($_POST['package-proceed']))
                {
                    $this->_driver->proceedImport();
                }
				parent::build($context);
                parent::addStylesheetToHead(URL . '/extensions/packages/assets/packages.css', 'screen', 70);
			}
		}
		
		public function view()
		{
			$this->setTitle('Symphony &ndash; Packages');
            if(isset($_POST['package-import']))
            {
                $this->__viewImport();
            } else {
			    $this->__viewIndex();
            }
		}

        public function __viewImport()
        {
            $this->setPageType('form');
            $this->appendSubheading(__('Packages'));
            $this->Contents->appendChild(new XMLElement('p', __('<strong>Information provided with this package:</strong>')));
            $content = str_replace("\n", '<br />', file_get_contents(TMP.'/package-readme.txt'));
            $this->Contents->appendChild(new XMLElement('p', $content));
            $form = Widget::Form(null, 'post');
            $this->Contents->appendChild(new XMLElement('p', __('<strong>Important notes:</strong><br /><br />
                The use of this extension is completely at your own risk. Please take a minute to read how the importing process works:<br />
                - <strong>existing files will be overwritten!</strong> So you better make sure you don\'t already have datasources, pages, events, utilities, extensions or any other assets that share the same name as the names mentioned above!<br />
                - <strong>imported datasources and events will be edited!</strong> This will be done to match the right section ID in the getSource()-function. However, if this function fails, it could mean your data-source doesn\'t output the desired result. So if you experience anything weird, you should check the getSource()-function of your datasource/event to make sure it returns the correct ID.<br />
                - <strong>imported pages will be re-ordered!</strong> This will be done to make sure that the parenting is correct and there are no pages that are not accesible (for example, if no page is assigned a NULL-parent, it will mean it doens\'t show up in the pages-section).<br />
                <br />
                So if you start importing better make sure of the following:<br />
                - There are no sections which already have the same name.<br />
                - There are no pages, events, data-sources, utilities, assets, etc. which already share the same name / path.<br />
                - There are no extensions which already have the same name.<br />
                <br />
                If any of these above rules applies to your situation, this is what you can do:<br />
                - If you don\'t want your extension, utility or asset to be overwritten, simply remove them from the zip-file.<br />
            ')));
            $form->appendChild(Widget::Input('package-proceed', __('I am aware of the risks of importing a package and want to proceed'), 'submit'));
            $this->Contents->appendChild($form);
        }

		// The Index:
		public function __viewIndex()
		{
			// Set the page to display as a form:
			$this->setPageType('form');
			$this->appendSubheading(__('Packages'));
            //$group = new XMLElement('div', 'hello world', array('class'=>'packages-column'));
            $this->Contents->appendChild(new XMLElement('h3', __('Import an existing package')));
            $importForm = Widget::Form(null, 'post', 'package', null, array('enctype'=>'multipart/form-data'));
            $importForm->appendChild(Widget::Input('package-file', null, 'file'));
            $importForm->appendChild(Widget::Input('package-import', __('Submit'), 'submit'));
            $this->Contents->appendChild($importForm);
            $this->Contents->appendChild(new XMLElement('em', 'or:'));
            $this->Contents->appendChild(new XMLElement('h3', __('Create a new package')));
            $createForm = Widget::Form(null, 'post', 'package');
            $createForm->appendChild(new XMLElement('p', __('Select the resources you wish to include in your package:')));
            $resources = new XMLElement('div', null, array('class'=>'package-resources'));

            // Sections:
            $sm = new SectionManager($this);
            $sections = $sm->fetch();
            $options = array();
            foreach($sections as $section)
            {
                $id = $section->get('id');
                $name = $section->get('name');
                $options[] = array($id, false, $name);
            }
            $resources->appendChild($this->createIncludeBox(__('Sections'), 'package-sections[]', $options));

            // Data-sources:
            $dm = new DatasourceManager($this);
            $datasources = $dm->listAll();
            $options = array();
            foreach($datasources as $handle => $datasource)
            {
                $options[] = array($handle, false, $datasource['name']);
            }
            $resources->appendChild($this->createIncludeBox(__('Data Sources'), 'package-data-sources[]', $options));

            // Events:
            $evm = new EventManager($this);
            $events = $evm->listAll();
            $options = array();
            foreach($events as $handle => $event)
            {
                $options[] = array($handle, false, $event['name']);
            }
            $resources->appendChild($this->createIncludeBox(__('Events'), 'package-events[]', $options));

            // Utilities:
            $utilities = General::listStructure(UTILITIES, array('xsl'), false, 'asc', UTILITIES);
            $options = array();
            if($utilities != false)
            {
                foreach($utilities['filelist'] as $utility)
                {
                    $options[] = array($utility, false, $utility);
                }
            }
            $resources->appendChild($this->createIncludeBox(__('Utilities'), 'package-utilities[]', $options));

            // Pages:
            $pages = Symphony::Database()->fetch('SELECT `id` FROM `tbl_pages` ORDER BY `sortorder` ASC;');
            $options = array();
            foreach($pages as $page)
            {
                $title = $this->getFullPageTitle($page['id']);
                $options[] = array($page['id'], false, $title);
            }
            usort($options, array($this, "cmp"));
            $resources->appendChild($this->createIncludeBox(__('Pages'), 'package-pages[]', $options));

            // Extensions:
            $em = new ExtensionManager($this);
            $extensions = $em->listAll();
            $options = array();
            foreach($extensions as $handle => $extension)
            {
                $options[] = array($handle, false, $extension['name']);
            }
            $resources->appendChild($this->createIncludeBox(__('Extensions'), 'package-extensions[]', $options));

            // Other resources:
            $files = $this->getResources(WORKSPACE);
            $options = array();
            foreach($files as $file)
            {
                $file = str_replace(WORKSPACE, '', $file);
                $options[] = array($file, false, $file);
            }
            $resources->appendChild($this->createIncludeBox(__('Other Resources'), 'package-other[]', $options));

            // E-mail template filter:
            // For starters, see if it's even installed:
            if($em->fetchStatus('emailtemplatefilter') == EXTENSION_ENABLED)
            {
                // Get the templates:
                $results = Symphony::Database()->fetch('SELECT * FROM `tbl_etf_templates` ORDER BY `name` ASC;');
                $options = array();
                foreach($results as $result)
                {
                    $options[] = array($result['id'], false, $result['name']);
                }
                $resources->appendChild($this->createIncludeBox(__('E-mail Template Filter'), 'package-etf[]', $options));
            }

            $createForm->appendChild($resources);
            $createForm->appendChild(new XMLElement('p', __('Description')));
            $createForm->appendChild(Widget::Textarea('package-description'));
            $createForm->appendChild(Widget::Input('package-create', __('Create my package'), 'submit'));
            $this->Contents->appendChild($createForm);
            
		}

        private function getResources($dir)
        {
            $return = array();
            $files = glob($dir.'/*');
            foreach($files as $file) {
                if(is_dir($file))
                {
                    if($file != WORKSPACE.'/pages' &&
                       $file != WORKSPACE.'/data-sources' &&
                       $file != WORKSPACE.'/events' &&
                       $file != WORKSPACE.'/utilities')
                    {
                        // Safe!
                        $dirFiles = $this->getResources($file);
                        foreach($dirFiles as $dirFile)
                        {
                            $return[] = $dirFile;
                        }
                    }
                } else {
                    $return[] = $file;
                }
            }
            return $return;
        }

        private function cmp($a, $b)
        {
            return strcmp($a[2], $b[2]);
        }

        private function getFullPageTitle($id)
        {
            $row = Symphony::Database()->fetchRow(0, 'SELECT `title`, `parent` FROM `tbl_pages` WHERE `id` = '.$id.';');
            $title = $row['title'];
            if($row['parent'] != null)
            {
                $title = $this->getFullPageTitle($row['parent']).' : '.$title;
            }
            return $title;
        }

        private function createIncludeBox($description, $name, $options)
        {
            $div = new XMLElement('div', null, array('class'=>'package-box'));
            $div->appendChild(new XMLElement('h4', $description));
            $select = Widget::Select($name, $options, array('multiple'=>'multiple'));
            $div->appendChild($select);
            return $div;
        }
	}
?>