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

		'Class:ActionWebhookNotification/Attribute:include_delete_button' => 'delete button~~',
		'Class:ActionWebhookNotification/Attribute:include_delete_button+' => 'show button for object deletion in message?~~',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:yes+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_delete_button/Value:no+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_modify_button' => 'Modify button~~',
		'Class:ActionWebhookNotification/Attribute:include_modify_button+' => 'show button for object modification in message?~~',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:yes+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_modify_button/Value:no+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons' => 'Other action buttons~~',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons+' => 'show buttons for other actions in message?~~',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes' => 'Oui',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:yes+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no' => 'Non',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Value:no+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific' => 'Specific~~',
		'Class:ActionWebhookNotification/Attribute:include_otheraction_buttons/Attribute:specific+' => '~~',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons' => 'Specific other actions~~',
		'Class:ActionWebhookNotification/Attribute:specific_action_buttons+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_list_view' => 'Use list view~~',
		'Class:ActionWebhookNotification/Attribute:include_list_view+' => 'Show attributes from object list view in message?~~',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes' => 'Yes~~',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:yes+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no' => 'No~~',
		'Class:ActionWebhookNotification/Attribute:include_list_view/Value:no+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_userinfo' => 'Show user information~~',
		'Class:ActionWebhookNotification/Attribute:include_userinfo+' => 'Show information of user who triggered the action in message?~~',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes' => 'yes~~',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:yes+' => '~~',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no' => 'no~~',
		'Class:ActionWebhookNotification/Attribute:include_userinfo/Value:no+' => '~~',
		'Class:ActionWebhookNotification/Attribute:language' => 'Language~~',
		'Class:ActionWebhookNotification/Attribute:language+' => 'Language in the message for translations of labels~~',
		
		'ActionWebhookNotification:baseinfo' => 'Informations générales',
		'ActionWebhookNotification:urlinfo' => 'Connection Webhook',
		'ActionWebhookNotification:standard' => 'Message basique',
		'ActionWebhookNotification:attachment' => 'Pièce jointe~~',
		'ActionWebhookNotification:additional_fields' => 'Additional fields and buttons~~',


	// Class ActionSlackNotification
		'Class:ActionSlackNotification' => 'Notification Slack',
		'Class:ActionSlackNotification+' => 'Envoyer une notification à Slack Webhook',
		
		'Class:ActionSlackNotification/Attribute:channel' => 'Salon ou utilisateur (Legacy)~~',
		'Class:ActionSlackNotification/Attribute:channel+' => 'Utiliser #salon ou @utilisateur (not longer possible to configure at runtime with slack apps)~~',
		'Class:ActionSlackNotification/Attribute:bot_alias' => 'Nom de l\'application (Legacy)',
		'Class:ActionSlackNotification/Attribute:bot_alias+' => 'Nom personnalisé de l\'application (not longer possible to configure at runtime with slack apps)~~',
		'ActionSlackNotification:attachment' => 'Pièce jointe (legacy)~~',
		

	// Class ActionRocketChatNotification
		'Class:ActionRocketChatNotification' => 'Notification Rocket Chat',
		'Class:ActionRocketChatNotification+' => 'Envoyer une notification à Rocket Chat Webhook',

));

?>
