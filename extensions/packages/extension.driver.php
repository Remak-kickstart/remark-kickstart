<?php
require_once(TOOLKIT.'/class.extensionmanager.php');
require_once(TOOLKIT.'/class.fieldmanager.php');
require_once(TOOLKIT . '/class.datasourcemanager.php');


Class extension_packages extends Extension
{
	/**
     * Return information about this extension
     * @return array    Information
     */
	public function about()
	{
		return array(
			'name' => 'Packages',
			'version' => '1.1',
			'release-date' => '2011-04-06',
			'author' => array(
				'name' => 'Giel Berkers',
				'website' => 'http://www.gielberkers.com',
				'email' => 'info@gielberkers.com'),
			'description' => 'Packages for Symphony 2.2'
		);
	}

	/**
     * Set the delegates
     * @return array    The delegates
     */
    public function getSubscribedDelegates()
	{
		return array(
			array(
				'page' => '/backend/',
				'delegate' => 'ExtensionsAddToNavigation',
				'callback' => 'extendNavigation'
			)
		);
	}

    /**
     * Extend the navigation
     * @param  $context     The context provided by Symphony
     * @return void
     */
    public function extendNavigation($context)
    {
		// Add the roles button to the system-tab:
		$context['navigation'][200]['children'][] = array(
			'link'  => '/extension/packages/',
			'name'  => __('Packages'),
			'limit' => 'developer'
		);
    }

    /**
     * This function creates a package
     * @return void
     */
    public function createPackage()
    {
        // Delete the existing zip-package:
        if(file_exists(TMP.'/package.zip')) {
            unlink(TMP.'/package.zip');
        }
        // Create a ZIP-file and an SQL-installation-script:
        $archive = new ZipArchive();
        if($archive->open(TMP.'/package.zip', ZIPARCHIVE::CREATE))
        {
            // Create readme
            $readme = strip_tags($_POST['package-description']);
            $readme.= "\n\nThis package will add the following to your Symphony Installation:\n\n";

            // Add install-script
            $install = '<?php'."\n";
            $install.= '// This is an automaticly generated installation script. For more details, see the createPackage()-function in extension.driver.php'."\n";

            // Add extensions folder
            $archive->addEmptyDir('extensions');

            // Add extensions:
            if(isset($_POST['package-extensions']))
            {
                $extensions = $_POST['package-extensions'];
                $readme .= "\nAdd the following extensions:\n";
                foreach($extensions as $extension)
                {
                    $this->addFolderToZip(EXTENSIONS.'/'.$extension, $archive);
                    $install.= '$em->enable(\''.$extension.'\');'."\n";
                }
            }

            // Install extensions:

            // Add Sections:
            // This is the tricky part: When creating a new section, the ID of the section is new. This means that
            // Datasources and events with the getSource()-function need to be adjusted. That's why the installer has some logica in it:
            if(isset($_POST['package-sections']))
            {
                $install .= '$section_original_id = array();'."\n";
                $install .= '$section_new_id = array();'."\n";
                $install .= '$field_old_new_ids = array();'."\n";
                $install .= '$tbl_section_association = array();'."\n";
                $sections = $_POST['package-sections'];
                $readme .= 'Add the following sections:'."\n";
                $install .= '// Add sections'."\n";
                foreach($sections as $id_section)
                {
                    $row = Symphony::Database()->fetchRow(0, 'SELECT * FROM `tbl_sections` WHERE `id` = '.$id_section.';');
                    $install .= '// Add section: '.$row['name']."\n";
                    $install .= '$section_original_id[\''.$row['handle'].'\'] = '.$id_section.';'."\n";
                    $install .= "Symphony::Database()->query('INSERT INTO `tbl_sections` (`name`, `handle`, `hidden`, `navigation_group`) VALUES (\'".addslashes($row['name'])."\', \'".$row['handle']."\', \'".$row['hidden']."\', \'".addslashes($row['navigation_group'])."\');');\n";
                    $install .= '$section_id = Symphony::Database()->getInsertID();'."\n";
                    $install .= '$section_new_id[\''.$row['handle'].'\'] = $section_id;'."\n";
                    $readme .= '- '.$row['name']."\n";
                    // Create the fields for this section:
                    $fields = Symphony::Database()->fetch('SELECT * FROM `tbl_fields` WHERE `parent_section` = '.$id_section.' ORDER BY `sortorder` ASC;');
                    foreach($fields as $field)
                    {
                        $install .= '// Add field: '.$field['label']."\n";
                        // Create the field:
                        $install .= '$field = array(\'label\'=>\''.$field['label'].'\', \'element_name\'=>\''.$field['element_name'].'\', \'type\'=>\''.$field['type'].'\', \'parent_section\'=>$section_id, \'required\'=>\''.$field['required'].'\', \'location\'=>\''.$field['location'].'\', \'show_column\'=>\''.$field['show_column'].'\');'."\n";
                        $install .= '$id_field = $fm->add($field);'."\n";
                        $install .= '$field_old_new_ids['.$field['id'].'] = $id_field;'."\n";
                        // Create the field-data-table:
                        $install .= '$fieldObject = $fm->create(\''.$field['type'].'\');'."\n";
                        $install .= '$fieldObject->set(\'id\', $id_field);'."\n";
                        $install .= '$fieldObject->createTable();'."\n";
                        // Create the associated table:
                        $fieldDetails = Symphony::Database()->fetchRow(0, 'SELECT * FROM `tbl_fields_'.$field['type'].'` WHERE `field_id` = '.$field['id'].';');
                        unset($fieldDetails['id']);
                        unset($fieldDetails['field_id']);
                        $keys = array_keys($fieldDetails);
                        if ( !empty($keys) ) {
	                        $install .= 'Symphony::Database()->query("INSERT INTO `tbl_fields_'.$field['type'].'` (`field_id`, `'.implode('`, `', $keys).'`) VALUES (".$id_field."';
	                        foreach($keys as $key)
	                        {
	                            $install .= ", '".addslashes($fieldDetails[$key])."'";
	                        }
	                        $install .= ');");'."\n";
                        }
                        else {
                       		$install .= 'Symphony::Database()->query(\'INSERT INTO `tbl_fields_'.$field['type'].'` (`field_id`) VALUES (\'.$id_field.\');\');'."\n";
                        }
                        $install .= "\n";
                    }
                    
                    $table_data = Symphony::Database()->fetch('SELECT * FROM `tbl_sections_association` WHERE `child_section_id` = '.$id_section.';');
                    foreach ( $table_data as $table_entry ) {
                        $install .= '// Set table association: '."\n";
                    	$install .= "\$tbl_section_association[] = array(
							'parent_section_id' => ".$table_entry['parent_section_id'].",
							'parent_section_field_id' => ".$table_entry['parent_section_field_id'].",
							'child_section_id' => ".$table_entry['child_section_id'].",
							'child_section_field_id' => ".$table_entry['child_section_field_id'].",
							'hide_association' => '".$table_entry['hide_association']."'                    		
                    	);\n";
                    }
                }
                
				//tbl_sections_association synchronization
                $install.= 'foreach ( $tbl_section_association as $table_entry )
{
	$parent_section_handle = $this->returnSectionHandle($table_entry[\'parent_section_id\'], $section_original_id);
	
	if ( $parent_section_handle != \'\' ) {
		$child_section_handle = $this->returnSectionHandle($table_entry[\'child_section_id\'], $section_original_id);
		
		Symphony::Database()->query(
			\'INSERT INTO `tbl_sections_association` (
					`parent_section_id`, 
					`parent_section_field_id`,
					`child_section_id`,
					`child_section_field_id`,
					`hide_association`
				) 
				VALUES (
					\\\'\'.$section_new_id[$parent_section_handle].\'\\\',
					\\\'\'.$field_old_new_ids[ $table_entry[\'parent_section_field_id\'] ].\'\\\',
					\\\'\'.$section_new_id[$child_section_handle].\'\\\',
					\\\'\'.$field_old_new_ids[ $table_entry[\'child_section_field_id\'] ].\'\\\',
					\\\'\'.$table_entry[\'hide_association\'].\'\\\'
				);\'
			);
	}
}';
            }

            // Add workspace folder
            $archive->addEmptyDir('workspace');
            $archive->addEmptyDir('workspace/data-sources');
            $archive->addEmptyDir('workspace/pages');
            $archive->addEmptyDir('workspace/events');
            $archive->addEmptyDir('workspace/utilities');

            // Add data sources
            if(isset($_POST['package-data-sources']))
            {
                $dataSources = $_POST['package-data-sources'];
                $readme .= 'Add the following datasources:'."\n";
                foreach($dataSources as $datasource)
                {
                    $archive->addFile(WORKSPACE.'/data-sources/data.'.$datasource.'.php', 'workspace/data-sources/data.'.$datasource.'.php');
                    $readme .= '- data.'.$datasource.".php\n";
                    // Add a rule to the install script to replace the old section-id with the new section-id:
                    $install .= '// Add datasource: '.$datasource."\n";
                    $install.= '$old_id = $this->getOriginalSectionId(WORKSPACE.\'/data-sources/data.'.$datasource.'.php\');'."\n";
                    $install.= 'foreach($section_original_id as $key => $id)
{
    if($id == $old_id)
    {
        $new_id = $section_new_id[$key];
    }
}
';
                    $install.= '$this->searchAndReplaceGetSourceFunction(WORKSPACE.\'/data-sources/data.'.$datasource.'.php\', $old_id, $new_id);'."\n";
                    $install.= '$this->searchAndReplaceOldIDsWithNewIDs(WORKSPACE.\'/data-sources/data.'.$datasource.'.php\', $field_old_new_ids);'."\n";
                }
            }

            // Add events
            if(isset($_POST['package-events']))
            {
                $events = $_POST['package-events'];
                $readme .= "\nAdd the following events:\n";
                foreach($events as $event)
                {
                    $archive->addFile(WORKSPACE.'/events/event.'.$event.'.php', 'workspace/events/event.'.$event.'.php');
                    $readme .= '- event.'.$event.".php\n";
                    // Add a rule to the install script to replace the old section-id with the new section-id:
                    $install .= '// Add event: '.$event."\n";
                    $install.= '$old_id = $this->getOriginalSectionId(WORKSPACE.\'/events/event.'.$event.'.php\');'."\n";
                    $install.= 'foreach($section_original_id as $key => $id)
{
    if($id == $old_id)
    {
        $new_id = $section_new_id[$key];
    }
}
';
                    $install.= '$this->searchAndReplaceGetSourceFunction(WORKSPACE.\'/events/event.'.$event.'.php\', $old_id, $new_id);'."\n";
                    $install.= '$this->searchAndReplaceOldIDsWithNewIDs(WORKSPACE.\'/events/event.'.$event.'.php\', $field_old_new_ids);'."\n";
                }
            }

            // Add utilities
            if(isset($_POST['package-utilities']))
            {
                $utilities = $_POST['package-utilities'];
                $readme .= "\nAdd the following utilities:\n";
                foreach($utilities as $utility)
                {
                    $archive->addFile(WORKSPACE.'/utilities/'.$utility, 'workspace/utilities/'.$utility);
                    $readme .= '- '.$utility."\n";
                }
            }

            // Add pages
            if(isset($_POST['package-pages']))
            {
                $pages = $_POST['package-pages'];
                $readme .= "\nAdd the following pages:\n";
                $install .= '// Add Pages:'."\n";
                $install.= '$page_ids = array();'."\n";
                $install.= '$page_old_names = array();'."\n";
                $install.= '$page_old_parents = array();'."\n";
                $install.= '$installed_datasources = $dm->listAll();'."\n";
                $install.= '$datasource_handles = array_keys($installed_datasources);'."\n";
                foreach($pages as $id_page)
                {
                    // Get the parents etc. right:
                    $row = Symphony::Database()->fetchRow(0, 'SELECT * FROM `tbl_pages` WHERE `id` = '.$id_page.';');
                    
                    //Get pages' types
                    $page_types = Symphony::Database()->fetchCol('type','SELECT `type` FROM `tbl_pages_types` WHERE `page_id` = '.$id_page.';');
                    
                    // Get the XSL-file:
                    $page_template = $this->__createHandle($row['path'], $row['handle']);
                    $archive->addFile(WORKSPACE.'/pages/'.$page_template.'.xsl', 'workspace/pages/'.$page_template.'.xsl');

                    $readme.='- '.$row['title'].' (filename: '.$page_template.'.xsl)'."\n";

                    $path = Administration::instance()->resolvePage($id_page, 'handle');
                    // Setup the installation:

                    // Keep in mind that the ID's are different, so the parenting should be fixed:
                    // First insert them as NULL (root), then restore the parenting afterwards:
                    // Also, we have to make sure that the data-sources that are used by this page are available when the page is inserted, so this needs to be checked:
                    $install .= '// Add page: '.$page_template."\n";
                    $install.='$original_datasources = array(\''.str_replace(',', '\', \'', $row['data_sources']).'\');'."\n";
                    $install.='$new_datasources = array();'."\n";
                    $install.='foreach($original_datasources as $ds)
{
    if(in_array($ds, $datasource_handles))
    {
        $new_datasources[] = $ds;
    }
}
';
                    $install.="Symphony::Database()->query('INSERT INTO `tbl_pages` (`title`, `handle`, `params`, `data_sources`, `events`) VALUES (\'".addslashes($row['title'])."\', \'".$row['handle']."\', \'".$row['params']."\', \''.implode(',', ".'$new_datasources'.").'\', \'".$row['events']."\');');\n";
                    $install.='$page_ids['.$row['id'].'] = Symphony::Database()->getInsertID();'."\n";
                    
                    foreach ($page_types as $page_type) {
                    	$install.= "Symphony::Database()->query('INSERT INTO `tbl_pages_types` (`page_id`, `type`) VALUES (\''.\$page_ids[".$row['id']."].'\', \'".$page_type."\');');\n";
                    }
                    
                    $install.='$page_old_names['.$row['id'].'] = \''.implode('_', $path).'.xsl\';'."\n";
                    if(empty($row['parent'])) { $row['parent'] = "'NULL'"; }
                    $install.='$page_old_parents['.$row['id'].'] = '.$row['parent'].";\n\n";
                }
                // Restore the parenting:
                $install .= '// Restore the parenting:'."\n";
                $install.='foreach($page_old_parents as $old_id => $old_parent)
{
    if(isset($page_ids[$old_parent]))
    {
        $new_id = $page_ids[$old_id];
        $new_parent = $page_ids[$old_parent];
        Symphony::Database()->query(\'UPDATE `tbl_pages` SET `parent` = \'.$new_parent.\' WHERE `id` = \'.$new_id.\';\');
    }
}
';
                // Restore the paths and rename the files according to the path:
                $install .= '// Restore the paths and rename the files according to the path:'."\n";
                $install.='foreach($page_ids as $old_id => $page_id)
{
    $row = Symphony::Database()->fetchRow(0, \'SELECT `id`, `parent` FROM `tbl_pages` WHERE `id` = \'.$page_id.\';\');
    if($row[\'parent\'] != null)
    {
        $path = Administration::instance()->resolvePage($page_id, \'handle\');
        array_pop($path);
        $path = implode(\'/\', $path);
        Symphony::Database()->query(\'UPDATE `tbl_pages` SET `path` = \\\'\'.$path.\'\\\' WHERE `id` = \'.$page_id.\';\');
    }
    $path = Administration::instance()->resolvePage($page_id, \'handle\');
    $new_filename = implode(\'_\', $path).\'.xsl\';
    rename(WORKSPACE.\'/pages/\'.$page_old_names[$old_id], WORKSPACE.\'/pages/\'.$new_filename);
}
';
            }

            // Add additional resources
            if(isset($_POST['package-other']))
            {
                $resources = $_POST['package-other'];
                $readme .= "\nAdd the following resources:\n";
                $createdDirs = array();
                foreach($resources as $resource)
                {
                    // Remove trailing slash:
                    if($resource[0] == '/') { $resource[0] = ''; }
                    // See if there are additional directories that need to be created:
                    $a = explode('/', $resource);
                    for($i = 0; $i < count($a)-1; $i++)
                    {
                        if(!in_array($resource.':'.$a[$i], $createdDirs))
                        {
                            $createdDirs[] = $resource.':'.$a[$i];
                            $dirName = array();
                            for($j = 0; $j <= $i; $j++) {
                                $dirName[] = $a[$j];
                            }
                            $dir = str_replace(chr(0), '', trim('workspace/'.implode('/', $dirName)));
                            $archive->addEmptyDir($dir);
                        }
                    }
                    $resource = str_replace(chr(0), '', trim($resource));
                    $archive->addFile(WORKSPACE.'/'.$resource, 'workspace/'.$resource);
                    $readme .= '- '.$resource."\n";
                }
            }

            // Add the e-mail template filter:
            if(isset($_POST['package-etf']))
            {
                // Get the templates:
                $readme .= "\nAdd the following e-mail templates:\n";
                $install .= '// Add the e-mail template filters:'."\n";
                $install .= '$etf_ids = array();'."\n";
                foreach($_POST['package-etf'] as $idTemplate)
                {
                    $template = Symphony::Database()->fetchRow(0, 'SELECT * FROM `tbl_etf_templates` WHERE `id` = '.$idTemplate);
                    
                    // Create the new templates (and keep track of their newly created ID's):
                    $install .= '// Create the e-mail template: '.$template['name']."\n";
                    $install .= "Symphony::Database()->insert(array('name'=>'".$template['name']."', 'conditions'=>'".$template['conditions']."', 'datasources'=>'".$template['datasources']."'), 'tbl_etf_templates');\n";
                    $install .= '$etf_ids['.$template['id'].'] = Symphony::Database()->getInsertID();'."\n";

                    // Get the conditions:
                    $conditions = Symphony::Database()->fetch('SELECT * FROM `tbl_etf_conditions` WHERE `template_id` = '.$template['id'].';');
                    foreach($conditions as $condition)
                    {
                        // Create the new conditions (and change the ID's of their templates/pages to the newly created templates/pages):
                        $install .= '// Add a condition for this e-mail template:'."\n";
                        $install .= '$newTemplateId = $etf_ids['.$template['id'].'];'."\n";
                        $install .= '$newPageId = $page_ids['.$condition['page'].'];'."\n";
                        $install .= '$info = array(';
                        $first = true;
                        foreach($condition as $key => $value)
                        {
                            if(!$first) { $install.=','; }
                            if($key == 'template_id') {
                                $install .= '\'template_id\'=>$newTemplateId';
                            } elseif($key == 'page') {
                                $install .= '\'page\'=>$newPageId';
                            } else {
                                $install .= "'".$key."'=>'".addslashes($value)."'";
                            }
                            $first = false;
                        }
                        $install .= ');'."\n";
                        $install .= 'Symphony::Database()->insert($info, \'tbl_etf_conditions\');'."\n";
                    }
                }
            }
            $install .= '// Installation done'."\n";

            // Add the readme-file:
            file_put_contents(TMP.'/readme', $readme);
            $archive->addFile(TMP.'/readme', 'package-readme.txt');

            // Add the installation-script:
            $install.= "\n".'?>';
            file_put_contents(TMP.'/install', $install);
            $archive->addFile(TMP.'/install', 'package-install.php');

            // Close, and thus save the file:
            $archive->close();

            // Remove temporary files:
            unlink(TMP.'/readme');
            unlink(TMP.'/install');

            // Show me the candy:
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename=package.zip');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize(TMP.'/package.zip'));
            ob_clean();
            flush();
            readfile(TMP.'/package.zip');
            die();

        } else {

            // Can't create archive
            die(__('Error: Can\'t create archive. Check your write permissions for the manifest/tmp-folder.'));
        }

    }

    /**
     * This function imports a package. It places it in the temporary folder
     * @return void
     */
    public function importPackage()
    {
        if(isset($_FILES['package-file']))
        {
            $ok = move_uploaded_file($_FILES['package-file']['tmp_name'], TMP.'/package.zip');
            $archive = new ZipArchive();
            $archive->open(TMP.'/package.zip');
            $archive->extractTo(TMP.'/', array('package-readme.txt'));
            $archive->close();
        }
    }

    /**
     * Proceed the import: extract the package, execute the installation-script and delete all files afterwards
     * @return void
     */
    public function proceedImport()
    {
        // Extract the archive:
        $archive = new ZipArchive();
        $archive->open(TMP.'/package.zip');
        $archive->extractTo(DOCROOT.'/');
        $archive->close();

        // Run the install-script:
        $em = new ExtensionManager();
        $fm = new FieldManager($this);
        $dm = new DatasourceManager($this);
        include_once(DOCROOT.'/package-install.php');
        
        // Delete it ALL:
        unlink(DOCROOT.'/package-install.php');
        unlink(DOCROOT.'/package-readme.txt');
        unlink(TMP.'/package.zip');
        unlink(TMP.'/package-readme.txt');
    }

    /**
     * Search and replace the getSource()-function in a datasource or event-file. Used by the installer
     * @param  $file    The filename
     * @param  $old_id  The old ID to look for
     * @param  $new_id  The new ID to replace it with
     * @return void
     */
    private function searchAndReplaceGetSourceFunction($file, $old_id, $new_id)
    {
        $content = file_get_contents($file);
        $content = preg_replace('/public function getSource\(\)\{\s+return \''.$old_id.'\';(.*)\s}/msU', "public function getSource(){\n\t\t\treturn '$new_id';\n\t\t}", $content);
        file_put_contents($file, $content);
    }

    /**
     * Returns the orignal section ID of the getSource()-function in a datasource or event-file. Used by the installer
     * @param  $file    The filename
     * @return int      The ID of the section
     */
    private function getOriginalSectionId($file)
    {
        $content = file_get_contents($file);
        $content = preg_match('/public function getSource\(\)\{\s+return \'(.*)\';(.*)\s}/msU', $content, $matches);
        return $matches[1];
    }

    /**
     * Search and replaces all old ID's with the new ones (in $dsParamFILTERS, $dsParamGROUP and attempts to check custom code (by looking for tbl_entries_data-occurances)). Used by the installer
     * @param  $file        The filename
     * @param  $replaces    An indexed array with oldID => newID (array(12=>50, 13=>51);)
     * @return void
     */
    private function searchAndReplaceOldIDsWithNewIDs($file, $replaces)
    {
        $content = file_get_contents($file);
        // Check for $dsParamFILTERS:
        preg_match('/public \$dsParamFILTERS = array\((.*)\);/msU', $content, $matches);
        if(count($matches) != 0)
        {
            $entries = explode(',', $matches[1]);
            $newEntries = array();
            foreach($entries as $entry)
            {
                $entry = trim($entry);
                if(!empty($entry))
                {
                    $a = explode('=>', $entry);
                    $old_id = trim(str_replace('\'', '', $a[0]));
                    if(array_key_exists($old_id, $replaces))
                    {
                        $entry = '\''.$replaces[$old_id].'\' =>'.$a[1];
                    }
                    $newEntries[] = $entry;
                }
            }
            $content = str_replace($matches[1], implode(', ', $newEntries), $content);
        }
        // Search for $dsParamGROUP:
        preg_match('/public \$dsParamGROUP = \'(.*)\';/msU', $content, $matches);
        if(count($matches) != 0)
        {
            if(array_key_exists($matches[1], $replaces))
            {
                $new = str_replace("'".$matches[1]."'", "'".$replaces[$matches[1]]."'", $matches[0]);
                $content = str_replace($matches[0], $new, $content);
            }
        }
        // Make an attempt to modify references to entry-data-tables:
        foreach($replaces as $old_id => $new_id)
        {
            $content = str_replace('tbl_entries_data_'.$old_id, 'tbl_entries_data_'.$new_id, $content);
        }
        file_put_contents($file, $content);
    }

    /**
     * Create a handle from a path. This is used to determine the filename of the page XSL-file. Used by the installer
     * @param  $path    The path
     * @param  $handle  The handle to add to the path
     * @return string   The handle
     */
    private function __createHandle($path, $handle) {
        return trim(str_replace('/', '_', $path . '_' . $handle), '_');
    }

    /**
     * Return the handle of the section. Used by the installer
     * @param  $old_id                  The old ID of the section
     * @param  $section_original_id     The original ID of the section
     * @return string                   The handle
     */
    private function returnSectionHandle($old_id, $section_original_id)
    {
        $section_handle = '';
        foreach ( $section_original_id as $key => $id ) {
            if ( $id == $old_id ) {
                $section_handle = $key;
                break;
            }
        }

        return $section_handle;
    }

    /**
     * Adds a folder recursive to a zipArchive
     * @param  $dir             The folder
     * @param  $zipArchive      A reference to the zipArchive
     * @return void
     */
    private function addFolderToZip($dir, $zipArchive){
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {

                //Add the directory
                $zipArchive->addEmptyDir(str_replace(DOCROOT.'/', '', $dir));

                // Loop through all the files
                while (($file = readdir($dh)) !== false) {
                    //If it's a folder, run the function again!
                    if(!is_file($dir.'/'.$file)){

                        // Skip parent and root directories
                        if( ($file !== ".") && ($file !== "..")){
                            $this->addFolderToZip($dir.'/'.$file, $zipArchive);
                        }

                    }else{
                        // Add the files
                        $zipArchive->addFile($dir.'/'.$file, str_replace(DOCROOT.'/', '', $dir).'/'.$file);
                    }
                }
            }
        }
    }

}
