<?php
/**
 * Localized data
 *
 * @copyright   Copyright (C) 2017 ITOMIG GmbH
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

Dict::Add('DE DE', 'German', 'Deutsch', array(
	// Class Action EventNotificationWebrequestNotification
		'Class:EventNotificationWebrequestNotification' => 'Web Request Event',
		'Class:EventNotificationWebrequestNotification+' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url+' => '',

		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url' => 'URL',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url+' => 'Aufgerufene URL',
		'Class:EventNotificationWebrequestNotification/Attribute:content' => 'Inhalt',
		'Class:EventNotificationWebrequestNotification/Attribute:content+' => 'Inhalt des Requests',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_finalclass' => 'Web Request Typ',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_finalclass+' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:response' => 'Antwort',
		'Class:EventNotificationWebrequestNotification/Attribute:response+' => 'z.Z. nicht verwendet',

	// Class ActionWebRequest
		'Class:ActionWebRequest' => 'Web Request',
		'Class:ActionWebRequest+' => 'Web Request',
		'Class:ActionWebRequest/Attribute:webrequest_url' => 'URL',
		'Class:ActionWebRequest/Attribute:webrequest_url+' => 'URL die aufgerufen werden soll.',


	// Class ActionWebhookNotification
		'Class:ActionWebhookNotification' => 'Webhook Benachrichtigung',
		'Class:ActionWebhookNotification+' => 'Benachrichtigung an einen Webhook',
		'Class:ActionWebhookNotification/Attribute:channel' => 'Channel oder Person',
		'Class:ActionWebhookNotification/Attribute:channel+' => 'Using #channel or @person',
		'Class:ActionWebhookNotification/Attribute:bot_alias' => 'App name',
		'Class:ActionWebhookNotification/Attribute:bot_alias+' => 'Anzeigename der App',
		'Class:ActionWebhookNotification/Attribute:text' => 'Einfacher Text',
		'Class:ActionWebhookNotification/Attribute:text+' => 'Einfacher text mit Parametern',
		'Class:ActionWebhookNotification/Attribute:attachment' => 'Anhang nutzen?',
		'Class:ActionWebhookNotification/Attribute:attachment+' => '',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:att_title' => 'Anhangtitel',
		'Class:ActionWebhookNotification/Attribute:att_title+' => '',
		'Class:ActionWebhookNotification/Attribute:att_title_link' => 'Titellink',
		'Class:ActionWebhookNotification/Attribute:att_title_link+' => '',
		'Class:ActionWebhookNotification/Attribute:att_color' => 'Anhangfarbe',
		'Class:ActionWebhookNotification/Attribute:att_color+' => 'HTML-Farbcode (HEX)',
		'Class:ActionWebhookNotification/Attribute:att_text' => 'Anhangtext',
		'Class:ActionWebhookNotification/Attribute:att_text+' => '',
		'Class:ActionWebhookNotification/Attribute:att_fallback' => 'Anhang Fallback',
		'Class:ActionWebhookNotification/Attribute:att_fallback+' => '',

		'ActionWebhookNotification:baseinfo' => 'Allgemeine Informationen',
		'ActionWebhookNotification:urlinfo' => 'Webhook Verbindung',
		'ActionWebhookNotification:standard' => 'Einfache Nachricht',
		'ActionWebhookNotification:attachment' => 'Attachment',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Slack Benachrichtugung',
		'Class:ActionSlackNotification+' => 'Sende Benachrichtugung an einen Slack Webhook',


	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Rocket Chat Benachrichtugung',
		'Class:ActionRocketChatNotification+' => 'Sende Benachrichtugung an einen Rocket Chat Webhook',
));

?>
