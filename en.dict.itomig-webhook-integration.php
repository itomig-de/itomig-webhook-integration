<?php
/**
 * Localized data
 *
 * @copyright   Copyright (C) 2017 ITOMIG GmbH
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

Dict::Add('EN US', 'English', 'English', array(
	// Class Action EventNotificationWebrequestNotification
		'Class:EventNotificationWebrequestNotification' => 'Web Request Event',
		'Class:EventNotificationWebrequestNotification+' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url' => 'URL',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url+' => 'Requested URL',
		'Class:EventNotificationWebrequestNotification/Attribute:content' => 'Content',
		'Class:EventNotificationWebrequestNotification/Attribute:content+' => 'Request content',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_finalclass' => 'Web request type',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_finalclass+' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:response' => 'response',
		'Class:EventNotificationWebrequestNotification/Attribute:response+' => 'currently not used',


	// Class ActionWebRequest
		'Class:ActionWebRequest' => 'Web Request',
		'Class:ActionWebRequest+' => 'Web Request',
		'Class:ActionWebRequest/Attribute:webrequest_url' => 'URL',
		'Class:ActionWebRequest/Attribute:webrequest_url+' => 'URL to request',


	// Class ActionWebhookNotification
		'Class:ActionWebhookNotification' => 'Webhook Notification',
		'Class:ActionWebhookNotification+' => 'Send Notification to Webhook',
		'Class:ActionWebhookNotification/Attribute:channel' => 'Channel or Person',
		'Class:ActionWebhookNotification/Attribute:channel+' => 'Using #channel or @person',
		'Class:ActionWebhookNotification/Attribute:bot_alias' => 'App name',
		'Class:ActionWebhookNotification/Attribute:bot_alias+' => 'Custom sender name',
		'Class:ActionWebhookNotification/Attribute:text' => 'Simple text',
		'Class:ActionWebhookNotification/Attribute:text+' => 'Simple text with params',
		'Class:ActionWebhookNotification/Attribute:attachment' => 'Use an attachment?',
		'Class:ActionWebhookNotification/Attribute:attachment+' => '',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:yes' => 'yes',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:no' => 'no',
		'Class:ActionWebhookNotification/Attribute:att_title' => 'Attachment title',
		'Class:ActionWebhookNotification/Attribute:att_title+' => '',
		'Class:ActionWebhookNotification/Attribute:att_title_link' => 'Attachment link',
		'Class:ActionWebhookNotification/Attribute:att_title_link+' => '',
		'Class:ActionWebhookNotification/Attribute:att_color' => 'Attachment Color',
		'Class:ActionWebhookNotification/Attribute:att_color+' => 'Color in HEX',
		'Class:ActionWebhookNotification/Attribute:att_text' => 'Attachment Text',
		'Class:ActionWebhookNotification/Attribute:att_text+' => 'Attachment Text with params',
		'Class:ActionWebhookNotification/Attribute:att_fallback' => 'Attachment Fallback',
		'Class:ActionWebhookNotification/Attribute:att_fallback+' => '',
		
		'ActionWebhookNotification:baseinfo' => 'General information',
		'ActionWebhookNotification:urlinfo' => 'Webhook Connection',
		'ActionWebhookNotification:standard' => 'Basis Message',
		'ActionWebhookNotification:attachment' => 'Attachment',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Slack Notification',
		'Class:ActionSlackNotification+' => 'Send Notification to Slack Webhook',


	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Rocket Chat Notification',
		'Class:ActionRocketChatNotification+' => 'Send Notification to Rocket Chat Webhook',		
	
));

?>
