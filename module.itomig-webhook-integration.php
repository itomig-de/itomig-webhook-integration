<?php
//
// iTop module definition file
//
//
//
SetupWebPage::AddModule ( __FILE__, // Path to the current file, all other file names are relative to the directory containing this file
'itomig-webhook-integration/21.1.0', array (
		// Identification
		//
		'label' => 'Webhook Integration (ITOMIG GmbH)',
		'category' => 'business',
		
		// Setup
		//
		'dependencies' => array (
			'itop-config-mgmt/2.5.0',
		),
		'mandatory' => false,
		'visible' => true,
		
		// Components
		//
		'datamodel' => array (
				'main.itomig-webhook-integration.php',
				'model.itomig-webhook-integration.php',
		),
		'webservice' => array (),
		'data.struct' => array (
			//'data.struct.actionslacknotification.xml',
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

				'asynchronous' => false,

		) 
) );

?>
