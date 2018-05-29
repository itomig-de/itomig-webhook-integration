<?php
/**
 * Localized data
 *
 * @copyright   Copyright (C) 2017 ITOMIG GmbH
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

Dict::Add('FR FR', 'French', 'Français', array(
	// Class Action EventNotificationWebrequestNotification
		'Class:EventNotificationWebrequestNotification' => 'Web Request Event',
		'Class:EventNotificationWebrequestNotification+' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url' => 'URL',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_url+' => 'URL demandé',
		'Class:EventNotificationWebrequestNotification/Attribute:content' => 'Contenu',
		'Class:EventNotificationWebrequestNotification/Attribute:content+' => 'Contenu de la demande',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_finalclass' => 'Type de demande web',
		'Class:EventNotificationWebrequestNotification/Attribute:webrequest_finalclass+' => '',
		'Class:EventNotificationWebrequestNotification/Attribute:response' => 'réponse',
		'Class:EventNotificationWebrequestNotification/Attribute:response+' => 'pas utilisé pour le moment',


	// Class ActionWebRequest
		'Class:ActionWebRequest' => 'Web Request',
		'Class:ActionWebRequest+' => 'Web Request',
		'Class:ActionWebRequest/Attribute:webrequest_url' => 'URL',
		'Class:ActionWebRequest/Attribute:webrequest_url+' => 'URL pour la demande',


	// Class ActionWebhookNotification
		'Class:ActionWebhookNotification' => 'Notifications du Webhook',
		'Class:ActionWebhookNotification+' => 'envoyer des notifications au Webhook',
		'Class:ActionWebhookNotification/Attribute:channel' => 'Canal ou personne',
		'Class:ActionWebhookNotification/Attribute:channel+' => 'Utiliser #canal ou @personne',
		'Class:ActionWebhookNotification/Attribute:bot_alias' => 'Nom de l\'application',
		'Class:ActionWebhookNotification/Attribute:bot_alias+' => 'Nom personnalisé de l\'application',
		'Class:ActionWebhookNotification/Attribute:text' => 'Texte simple',
		'Class:ActionWebhookNotification/Attribute:text+' => 'Texte simple avec des paramètres',
		'Class:ActionWebhookNotification/Attribute:attachment' => 'Utiliser des pièces jointes',
		'Class:ActionWebhookNotification/Attribute:attachment+' => '',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:yes' => 'oui',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:no' => 'non',
		'Class:ActionWebhookNotification/Attribute:att_title' => 'Titre de la pièce jointe',
		'Class:ActionWebhookNotification/Attribute:att_title+' => '',
		'Class:ActionWebhookNotification/Attribute:att_title_link' => 'Lien de la pièce jointe',
		'Class:ActionWebhookNotification/Attribute:att_title_link+' => '',
		'Class:ActionWebhookNotification/Attribute:att_color' => 'Couleur de la pièce jointe',
		'Class:ActionWebhookNotification/Attribute:att_color+' => 'Couleur en HEX',
		'Class:ActionWebhookNotification/Attribute:att_text' => 'Texte de la pièce jointe',
		'Class:ActionWebhookNotification/Attribute:att_text+' => 'Texte de la pièce jointe avec paramètres',
		'Class:ActionWebhookNotification/Attribute:att_fallback' => 'Fallback de la pièce jointe',
		'Class:ActionWebhookNotification/Attribute:att_fallback+' => '',

		'ActionWebhookNotification:baseinfo' => 'Informations générales',
		'ActionWebhookNotification:urlinfo' => 'Connection Webhook',
		'ActionWebhookNotification:standard' => 'Message basique',
		'ActionWebhookNotification:attachment' => 'Pièce jointe',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Notification Slack',
		'Class:ActionSlackNotification+' => 'Envoyer une notification à Slack Webhook',


	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Notification Rocket Chat',
		'Class:ActionRocketChatNotification+' => 'Envoyer une notification à Rocket Chat Webhook',

));

?>
