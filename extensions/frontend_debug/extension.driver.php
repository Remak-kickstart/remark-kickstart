<?php
	Class extension_frontend_debug extends Extension
	{
		/**
		* About this extension:
		*/
		public function about()
		{
			return array(
				'name' => 'Frontend debugger container',
				'version' => '1.2',
				'release-date' => '2011-12-16',
				'author' => array(
					'name' => 'Giel Berkers',
					'website' => 'http://www.gielberkers.com',
					'email' => 'info@gielberkers.com'),
				'description' => 'Adds the debugger to the frontend of your website as a new panel'
			);
		}
		
		/**
		* Set the delegates
		*/
		public function getSubscribedDelegates()
		{
			return array(
				array(
					'page' => '/frontend/',
					'delegate' => 'FrontendOutputPostGenerate',
					'callback' => 'addScriptToHeader'
				)
			);
		}
		
		/**
		 * Add the script to the header
		 */
		public function addScriptToHeader($context)
		{
			if(!empty(Symphony::Engine()->Author))
			{
				if(Symphony::Engine()->Author->isDeveloper())
				{
					$context['output'] = str_replace('</head>', '
						<link rel="stylesheet" type="text/css" media="screen,tv,projection" href="'.URL.'/extensions/frontend_debug/assets/frontend_debug.css" />
						<script type="text/javascript" src="'.URL.'/extensions/frontend_debug/assets/frontend_debug.js"></script>
						</head>', $context['output']);
				}
			}
		}
	}
?>