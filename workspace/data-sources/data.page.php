<?php

require_once(TOOLKIT . '/class.datasource.php');

Class datasourcepage extends Datasource
{

    public $dsParamROOTELEMENT = 'page';
    public $dsParamORDER = 'desc';
    public $dsParamPAGINATERESULTS = 'yes';
    public $dsParamLIMIT = '1';
    public $dsParamSTARTPAGE = '1';
    public $dsParamREDIRECTONEMPTY = 'yes';
    public $dsParamSORT = 'system:id';
    public $dsParamHTMLENCODE = 'yes';
    public $dsParamASSOCIATEDENTRYCOUNTS = 'no';

    public $dsParamFILTERS = array(
        '28' => '{$current-page-id}',
        '29' => '{$link:index}',
    );

    public $dsParamINCLUDEDELEMENTS = array(
        'zagolovok',
        'razdel',
        'ssylka',
        'meta-title',
        'meta-keywords',
        'meta-description',
        'bloki: blok'
    );


    public function __construct(&$parent, $env = NULL, $process_params = true)
    {
        parent::__construct($parent, $env, $process_params);
        $this->_dependencies = array();
    }

    public function about()
    {
        return array(
            'name' => 'page',
            'author' => array(
                'name' => 'Remark Remark',
                'website' => 'http://localhost/ecstasy',
                'email' => 'mail@remark72.ru'),
            'version' => 'Symphony 2.2.5',
            'release-date' => '2012-03-08T14:59:54+00:00'
        );
    }

    public function getSource()
    {
        return '7';
    }

    public function allowEditorToParse()
    {
        return true;
    }

    public function grab(&$param_pool = NULL)
    {
        $result = new XMLElement($this->dsParamROOTELEMENT);

        try {
            include(TOOLKIT . '/data-sources/datasource.section.php');
        }
        catch (FrontendPageNotFoundException $e) {
            // Work around. This ensures the 404 page is displayed and
            // is not picked up by the default catch() statement below
            FrontendPageNotFoundExceptionHandler::render($e);
        }
        catch (Exception $e) {
            $result->appendChild(new XMLElement('error', $e->getMessage()));
            return $result;
        }

        if ($this->_force_empty_result) $result = $this->emptyXMLSet();

        $blocks = $result->getChildrenByName('entry');
        $blocks = array_shift($blocks);
        $blocks = $blocks->getChildrenByName('bloki');
        $blocks = array_shift($blocks);
        $blocks = $blocks->getChildrenByName('item');
        foreach ($blocks as $block)
        {
            $block_id = $block->getAttribute('id');
            $block = $block->getChildrenByName('blok');
            $block = array_shift($block);
            $block = $block->getChildrenByName('item');
            $block = array_shift($block);
            if ($block) {
                $param_pool['ds-page-blocks'][] = $block_id;
                $param_pool['ds-' . str_replace('blok', 'block', $block->getAttribute('section-handle'))][] = $block->getAttribute('id');
            }
        }

        return $result;
    }

}
