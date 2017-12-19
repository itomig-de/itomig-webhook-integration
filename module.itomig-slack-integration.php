<?php
//
// iTop module definition file
//
//
//
SetupWebPage::AddModule ( __FILE__, // Path to the current file, all other file names are relative to the directory containing this file
'itomig-slack-integration/17.4.0', array (
		// Identification
		//
		'label' => 'Slack Integration (ITOMIG GmbH)',
		'category' => 'business',
		
		// Setup
		//
		'dependencies' => array (
			'itop-config-mgmt/2.0.0',
		),
		'mandatory' => false,
		'visible' => true,
		
		// Components
		//
		'datamodel' => array (
				'model.itomig-slack-integration.php',
				'main.itomig-slack-integration.php',
		),
		'webservice' => array (),
		'data.struct' => array (
			// add your 'structure' definition XML files here,
		),
		'data.sample' => array (
			// add your sample data XML files here,
		),
		
		// Documentation
		//
		'doc.manual_setup' => '', // hyperlink to manual setup documentation, if any
		'doc.more_information' => '', // hyperlink to more information, if any
		                              
		// Default settings
		                              //
		'settings' => array (
				// Module specific settings
				
				// if set to false, SSL certificate check will be disabled
				'certificate_check' => true,
				
				// The name of a file containing a PEM formatted certificate.
				'certificate_file' => '',
				
				'timeout' => 5,  // timeout in seconds
		) 
) );

?>
