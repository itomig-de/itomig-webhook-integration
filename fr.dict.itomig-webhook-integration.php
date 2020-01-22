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
		'Class:ActionWebhookNotification/Attribute:channel' => 'Salon ou utilisateur',
		'Class:ActionWebhookNotification/Attribute:channel+' => 'Utiliser #salon ou @utilisateur',
		'Class:ActionWebhookNotification/Attribute:bot_alias' => 'Nom de l\'application',
		'Class:ActionWebhookNotification/Attribute:bot_alias+' => 'Nom personnalisé de l\'application',
		'Class:ActionWebhookNotification/Attribute:text' => 'Texte simple',
		'Class:ActionWebhookNotification/Attribute:text+' => 'Texte simple avec des paramètres',
		'Class:ActionWebhookNotification/Attribute:attachment' => 'Utiliser des pièces jointes',
		'Class:ActionWebhookNotification/Attribute:attachment+' => '',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:attachment/Value:no' => 'Non',
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

		'Class:ActionWebhookNotification/Attribute:include_delete_button' => 'Bouton supprimer',
		'Class:ActionWebhookNotification/Attribute:include_delete_button+' => 'Montrer le bouton pour la suppression de l\'objet dans le message ?',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_modify_button' => 'Bouton modifier',
		'Class:ActionWebhookNotification/Attribute:include_modify_button+' => 'Montrer le bouton pour la modification de l\'objet dans le message ?',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons' => 'Boutons pour d\'autres actions',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons+' => 'Montrer les boutons pour d\'autres actions dans le message ?',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific' => 'Spécifique',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific+' => '',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons' => 'Autres boutons spécifiques',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons+' => '',
		'Class:ActionWebhookNotification/Attribute:include_list_view' => 'Utiliser la vue en liste',
		'Class:ActionWebhookNotification/Attribute:include_list_view+' => 'Montrer les attributs de la vue en liste de l\'objet dans le message ?',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:include_userinfo' => 'Montrer les informations de l\'utilisateur',
		'Class:ActionWebhookNotification/Attribute:include_userinfo+' => 'Montrer les informations de l\'utilisateur qui a déclancher l\'action dans le message ?',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes+' => '',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no+' => '',
		'Class:ActionWebhookNotification/Attribute:language' => 'Langue',
		'Class:ActionWebhookNotification/Attribute:language+' => 'Langue dans le message pour la traduction des labels',

		'ActionWebhookNotification:baseinfo' => 'Informations générales',
		'ActionWebhookNotification:urlinfo' => 'Connection Webhook',
		'ActionWebhookNotification:standard' => 'Message basique',
		'ActionWebhookNotification:attachment' => 'Pièce jointe',
		'ActionWebhookNotification:additional_fields' => 'Champs additionnels et boutons',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Notification Slack',
        'Class:ActionSlackNotification+' => 'Envoyer une notification à Slack Webhook',

		'Class:ActionSlackNotification/Attribute:channel' => 'Salon ou utilisateur (Legacy)',
		'Class:ActionSlackNotification/Attribute:channel+' => 'Utiliser #salon ou @utilisateur (désormais impossible à configurer pendant l\'exécution avec les applications slack)',
		'Class:ActionSlackNotification/Attribute:bot_alias' => 'Nom de l\'application (Legacy)',
		'Class:ActionSlackNotification/Attribute:bot_alias+' => 'Nom personnalisé de l\'application (désormais impossible à configurer pendant l\'exécution avec les applications slack)',
		'ActionSlackNotification:attachment' => 'Pièce jointe (Legacy)',

	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Notification Rocket Chat',
		'Class:ActionRocketChatNotification+' => 'Envoyer une notification à Rocket Chat Webhook',

));

?>
