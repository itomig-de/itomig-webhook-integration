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

		'Class:ActionWebhookNotification/Attribute:include_delete_button' => 'Löschen Button',
		'Class:ActionWebhookNotification/Attribute:include_delete_button+' => 'Button zum Löschen in der Benachrichtigung anzeigen?',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_modify_button' => 'Bearbeiten Button',
		'Class:ActionWebhookNotification/Attribute:include_modify_button+' => 'Button zum Bearbeiten in der Benachrichtigung anzeigen?',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons' => 'Andere Aktionen Button',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons+' => 'Buttons für andere Aktionen in der Benachrichtigung anzeigen?',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific' => 'Angepasst',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific+' => '',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons' => 'Angepasste zusätzliche Aktionen',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons+' => '',
		'Class:ActionWebhookNotification/Attribute:include_list_view' => 'Listenansicht nutzen',
		'Class:ActionWebhookNotification/Attribute:include_list_view+' => 'Attribute aus der Listenansicht automatisch als Felder senden?',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_userinfo' => 'Benutzerinformationen anzeigen',
		'Class:ActionWebhookNotification/Attribute:include_userinfo+' => 'In der Benachrichtigung anzeigen, wer die Aktion ausgelöst hat?',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes' => 'Ja',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no' => 'Nein',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:language' => 'Sprache',
		'Class:ActionWebhookNotification/Attribute:language+' => 'Sprache der Benachrichtugung zur Übersetzung der Labels',

		'ActionWebhookNotification:baseinfo' => 'Allgemeine Informationen',
		'ActionWebhookNotification:urlinfo' => 'Webhook Verbindung',
		'ActionWebhookNotification:standard' => 'Einfache Nachricht',
		'ActionWebhookNotification:attachment' => 'Attachment',
		'ActionWebhookNotification:additional_fields' => 'Zusätzliche Felder und Buttons',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Slack Benachrichtugung',
		'Class:ActionSlackNotification+' => 'Sende Benachrichtugung an einen Slack Webhook',

		'Class:ActionSlackNotification/Attribute:channel' => 'Channel oder Person (Legacy)',
		'Class:ActionSlackNotification/Attribute:channel+' => 'Using #channel or @person (Nicht mehr möglich mit Slack Apps)',
		'Class:ActionSlackNotification/Attribute:bot_alias' => 'App name (Legacy)',
		'Class:ActionSlackNotification/Attribute:bot_alias+' => 'Anzeigename der App (Nicht mehr möglich mit Slack Apps)',
		'ActionSlackNotification:attachment' => 'Attachment (Legacy)',


	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Rocket Chat Benachrichtugung',
		'Class:ActionRocketChatNotification+' => 'Sende Benachrichtugung an einen Rocket Chat Webhook',
		
));

?>
