<?php
	$settings = array(

		###### FIELDSET: SITE PREFERENCES ######
		array(
			'name' => 'Site Preferences',
			'fields' => array(
				array(
					'name' => 'textarea',
					'label' => 'This is a textarea',
					'type' => 'textarea',
					'value' => '',
				),
				array(
					'name' => 'input',
					'label' => 'This is an input field',
					'type' => 'input',
					'value' => '',
				),
				array(
					'name' => 'selectbox',
					'label' => 'Select something',
					'type' => 'select',
					'values' => 'this, is, a, selection, list',
					'value' => '',
				),
			)
		),
		########

		###### FIELDSET: MORE PREFERENCES ######
		array(
			'name' => 'More preferences',
			'fields' => array(
				array(
					'type' => 'help',
					'value' => 'This is just another group of settings added to the preference page. You can edit all fields and fieldset in the &lt;code&gt;preferences.site.php&lt;/code&gt; file inside your &lt;code&gt;workspace&lt;/code&gt;.',
				),
				array(
					'name' => 'checkbox',
					'label' => 'Yes, I\'ve read that!',
					'type' => 'checkbox',
					'value' => 'checked',
				),
			)
		),
		########
	);
