<?php
/**
 * @package		plg_system_qlsmoothscroll
 * @copyright	Copyright (C) 2015 ql.de All rights reserved.
 * @author 		Mareike Riegel mareike.riegel@ql.de
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

//no direct access
defined('_JEXEC') or die ('Restricted Access');

jimport('joomla.plugin.plugin');

class plgSystemQlsmoothscroll extends JPlugin
{

    /**
     * constructor
     *setting language
     */
    public function __construct(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage();
		$this->includeScripts();
    }

	/*
    * method to get documents and scripts needed
    */
    function includeScripts()
    {
        $document=JFactory::getDocument();
        if (1==$this->params->get('jquery',0)) JHtml::_('jquery.framework');
		$offset=$this->params->get('offset',0);
		if(!is_numeric($offset))$offset=0;
        $document->addScriptDeclaration('var qlSiteOffset='.$offset.';');
        $document->addScript(JURI::base().'plugins/system/'.$this->get('_name').'/js/'.$this->get('_name').'.js');
    }
}