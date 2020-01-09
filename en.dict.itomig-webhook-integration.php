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
		'Class:ActionWebhookNotification/Attribute:attachment/Value:yes' => 'Yes',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:no' => 'No',
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

		'Class:ActionWebhookNotification/Attribute:include_delete_button' => 'Delete button',
		'Class:ActionWebhookNotification/Attribute:include_delete_button+' => 'Show button for object deletion in message?',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes' => 'Yes',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no' => 'No',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_modify_button' => 'Modify button',
		'Class:ActionWebhookNotification/Attribute:include_modify_button+' => 'Show button for object modification in message?',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes' => 'Yes',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no' => 'No',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons' => 'Other action buttons',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons+' => 'Show buttons for other actions in message?',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes' => 'Yes',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no' => 'No',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific' => 'Specific',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific+' => '',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons' => 'Specific other actions',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons+' => '',
		'Class:ActionWebhookNotification/Attribute:include_list_view' => 'Use list view',
		'Class:ActionWebhookNotification/Attribute:include_list_view+' => 'Show attributes from object list view in message?',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes' => 'Yes',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no' => 'No',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_userinfo' => 'Show user information',
		'Class:ActionWebhookNotification/Attribute:include_userinfo+' => 'Show information of user who triggered the action in message?',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes' => 'yes',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no' => 'no',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:language' => 'Language',
		'Class:ActionWebhookNotification/Attribute:language+' => 'Language in the message for translations of labels',
		
		'ActionWebhookNotification:baseinfo' => 'General information',
		'ActionWebhookNotification:urlinfo' => 'Webhook Connection',
		'ActionWebhookNotification:standard' => 'Basis Message',
		'ActionWebhookNotification:attachment' => 'Attachment',
		'ActionWebhookNotification:additional_fields' => 'Additional fields and buttons',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Slack Notification',
		'Class:ActionSlackNotification+' => 'Send Notification to Slack Webhook',
		
		'Class:ActionSlackNotification/Attribute:channel' => 'Channel or Person (Legacy)',
		'Class:ActionSlackNotification/Attribute:channel+' => 'Using #channel or @person (not longer possible to configure at runtime with slack apps)',
		'Class:ActionSlackNotification/Attribute:bot_alias' => 'App name (Legacy)',
		'Class:ActionSlackNotification/Attribute:bot_alias+' => 'Custom sender name (not longer possible to configure at runtime with slack apps)',
		'ActionSlackNotification:attachment' => 'Attachment (legacy)',


	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Rocket Chat Notification',
		'Class:ActionRocketChatNotification+' => 'Send Notification to Rocket Chat Webhook',		
	
));

?>
