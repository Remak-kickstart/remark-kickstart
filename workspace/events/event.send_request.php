<?php

	require_once(TOOLKIT . '/class.event.php');

	Class eventsend_request extends Event{

		const ROOTELEMENT = 'send-request';

		public $eParamFILTERS = array(
			
		);

		public static function about(){
			return array(
				'name' => 'send_request',
				'author' => array(
					'name' => 'Ремарк Ремаркович Ремарков',
					'website' => 'http://pkb.home',
					'email' => 'mail@remark72.ru'),
				'version' => 'Symphony 2.2.5',
				'release-date' => '2012-04-25T05:00:56+00:00',
				'trigger-condition' => 'action[send-request]'
			);
		}

		public static function getSource(){
			return '12';
		}

		public static function allowEditorToParse(){
			return true;
		}

		public static function documentation(){
			return '
        <h3>Success and Failure XML Examples</h3>
        <p>When saved successfully, the following XML will be returned:</p>
        <pre class="XML"><code>&lt;send-request result="success" type="create | edit">
  &lt;message>Entry [created | edited] successfully.&lt;/message>
&lt;/send-request></code></pre>
        <p>When an error occurs during saving, due to either missing or invalid fields, the following XML will be returned:</p>
        <pre class="XML"><code>&lt;send-request result="error">
  &lt;message>Entry encountered errors when saving.&lt;/message>
  &lt;field-name type="invalid | missing" />
  ...
&lt;/send-request></code></pre>
        <h3>Example Front-end Form Markup</h3>
        <p>This is an example of the form markup you can use on your frontend:</p>
        <pre class="XML"><code>&lt;form method="post" action="" enctype="multipart/form-data">
  &lt;input name="MAX_FILE_SIZE" type="hidden" value="2097152" />
  &lt;input name="fields[blok]" type="hidden" value="..." />
  &lt;label>Якорь
    &lt;input name="fields[yakor]" type="text" />
  &lt;/label>
  &lt;label>Тип
    &lt;select name="fields[tip]">
      &lt;option value="article">article&lt;/option>
      &lt;option value="aside">aside&lt;/option>
      &lt;option value="div">div&lt;/option>
      &lt;option value="footer">footer&lt;/option>
      &lt;option value="header">header&lt;/option>
      &lt;option value="nav">nav&lt;/option>
      &lt;option value="section">section&lt;/option>
    &lt;/select>
  &lt;/label>
  &lt;input name="action[send-request]" type="submit" value="Submit" />
&lt;/form></code></pre>
        <p>To edit an existing entry, include the entry ID value of the entry in the form. This is best as a hidden field like so:</p>
        <pre class="XML"><code>&lt;input name="id" type="hidden" value="23" /></code></pre>
        <p>To redirect to a different location upon a successful save, include the redirect location in the form. This is best as a hidden field like so, where the value is the URL to redirect to:</p>
        <pre class="XML"><code>&lt;input name="redirect" type="hidden" value="http://pkb.home/success/" /></code></pre>';
		}

		public function load(){
			if(isset($_POST['action']['send-request'])) return $this->__trigger();
		}

		protected function __trigger(){
			include(TOOLKIT . '/events/event.section.php');
			return $result;
		}

	}
