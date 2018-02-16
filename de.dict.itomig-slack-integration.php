<?php
/**
 * Localized data
 *
 * @copyright   Copyright (C) 2017 ITOMIG GmbH
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

Dict::Add('DE DE', 'German', 'Deutsch', array(
		'Class:ActionWebhookNotification' => 'Webhook Notification',
		'Class:ActionWebhookNotification+' => 'Send Notification to Webhook',
		'Class:ActionWebhookNotification/Attribute:debug_trace' => 'Debug Trace',
		'Class:ActionWebhookNotification/Attribute:debug_trace+' => 'Informationen ins Log schreiben?',
		'Class:ActionWebhookNotification/Attribute:debug_trace/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:debug_trace/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:webhook_url' => 'Webhook URL',
		'Class:ActionWebhookNotification/Attribute:webhook_url+' => '',
		'Class:ActionWebhookNotification/Attribute:parameters' => 'Parameter',
		'Class:ActionWebhookNotification/Attribute:parameters+' => '',
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


		'Class:EventNotificationWebhookNotification' => 'Webhook Event',
		'Class:EventNotificationWebhookNotification+' => '',
		'Class:EventNotificationWebhookNotification/Attribute:webhook_url' => 'Webhook URL',
		'Class:EventNotificationWebhookNotification/Attribute:webhook_url+' => 'Aufgerufene Webhook URL',
		'Class:EventNotificationWebhookNotification/Attribute:channel' => 'Channel',
		'Class:EventNotificationWebhookNotification/Attribute:channel+' => 'Angegebener Channel',
		'Class:EventNotificationWebhookNotification/Attribute:response' => 'Server Response',
		'Class:EventNotificationWebhookNotification/Attribute:response+' => '',
		'Class:EventNotificationWebhookNotification/Attribute:bot_alias' => 'Botalias',
		'Class:EventNotificationWebhookNotification/Attribute:bot_alias+' => '',
		'Class:EventNotificationWebhookNotification/Attribute:webhook_finalclass' => 'Webhook Typ',
		'Class:EventNotificationWebhookNotification/Attribute:webhook_finalclass+' => '',


		'Class:ActionSlackNotification' => 'Slack Benachrichtugung',
		'Class:ActionSlackNotification+' => 'Sende Benachrichtugung an einen Slack Webhook',

		'Class:ActionRocketChatNotification' => 'Rocket Chat Benachrichtugung',
		'Class:ActionRocketChatNotification+' => 'Sende Benachrichtugung an einen Rocket Chat Webhook',
));

?>
