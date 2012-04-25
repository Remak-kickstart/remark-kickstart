<?php

	require_once(TOOLKIT . '/class.datasource.php');

	Class datasourcepage_blocks extends Datasource{

		public $dsParamROOTELEMENT = 'page-blocks';
		public $dsParamORDER = 'asc';
		public $dsParamPAGINATERESULTS = 'no';
		public $dsParamLIMIT = '20';
		public $dsParamSTARTPAGE = '1';
		public $dsParamREDIRECTONEMPTY = 'no';
		public $dsParamSORT = 'system:id';
		public $dsParamHTMLENCODE = 'yes';
		public $dsParamASSOCIATEDENTRYCOUNTS = 'no';

		public $dsParamFILTERS = array(
				'id' => '{$ds-page-blocks}',
		);

		public $dsParamINCLUDEDELEMENTS = array(
				'blok',
				'yakor',
				'tip'
		);


		public function __construct(&$parent, $env=NULL, $process_params=true){
			parent::__construct($parent, $env, $process_params);
			$this->_dependencies = array('$ds-page-blocks');
		}

		public function about(){
			return array(
				'name' => 'page-blocks',
				'author' => array(
					'name' => 'Remark Remarkovich',
					'website' => 'http://www.mera.com',
					'email' => 'mail@remark72.ru'),
				'version' => 'Symphony 2.2.5',
				'release-date' => '2012-03-15T10:35:32+00:00'
			);
		}

		public function getSource(){
			return '12';
		}

		public function allowEditorToParse(){
			return true;
		}

		public function grab(&$param_pool=NULL){
			$result = new XMLElement($this->dsParamROOTELEMENT);

			try{
				include(TOOLKIT . '/data-sources/datasource.section.php');
			}
			catch(FrontendPageNotFoundException $e){
				// Work around. This ensures the 404 page is displayed and
				// is not picked up by the default catch() statement below
				FrontendPageNotFoundExceptionHandler::render($e);
			}
			catch(Exception $e){
				$result->appendChild(new XMLElement('error', $e->getMessage()));
				return $result;
			}

			if($this->_force_empty_result) $result = $this->emptyXMLSet();

			

			return $result;
		}

	}
