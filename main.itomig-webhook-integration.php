<?php
// Copyright (C) 2017 ITOMIG GmbH
//
// iTop is free software; you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// iTop is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with iTop. If not, see <http://www.gnu.org/licenses/>

/**
 * Persistent classes (internal): user defined actions
 *
 * @copyright Copyright (C) 2017 ITOMIG GmbH
 * @license http://opensource.org/licenses/AGPL-3.0
 */
require_once (APPROOT . '/core/asynctask.class.inc.php');
require_once (APPROOT . '/core/action.class.inc.php');

define ('WEBREQUEST_SEND_OK', 0);
define ('WEBREQUEST_SEND_PENDING', 1);
define ('WEBREQUEST_SEND_ERROR', 2);


abstract class ActionWebRequest extends ActionNotification {
	public static function Init() {
		$aParams = array (
				"category" => "core/cmdb,application",
				"key_type" => "autoincrement",
				"name_attcode" => "name",
				"state_attcode" => "",
				"reconc_keys" => array (
						'name' 
				),
				"db_table" => "priv_webrequest_notify",
				"db_key_field" => "id",
				"db_finalclass_field" => "",
				"display_template" => "" 
		);
		MetaModel::Init_Params ( $aParams );
		MetaModel::Init_InheritAttributes ();
		
		//Init Attributes

		MetaModel::Init_AddAttribute ( new AttributeURL ( "webrequest_url", array (
				"allowed_values" => null,
				"sql" => "webrequest_url",
				"default_value" => null,
				"target" => "_blank",
				"is_null_allowed" => false,
				"depends_on" => array ()
		) ) );
		// Init displays

		// Attributes to be displayed for a list view
		MetaModel::Init_SetZListItems ( 'list', array (
				'name',
				'finalclass',
				'status',
				'webrequest_url', 
		) );
		// Attributes used as criteriaa of the std search form
		MetaModel::Init_SetZListItems ( 'standard_search', array (
				'name',
				'finalclass',
				'description',
				'status',
				'webrequest_url' 
		) );
		// MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}

	// array of strings explaining the issue
	protected $m_aWebrequestErrors;
	
	/**
	 * Execute when Action is called, Get fields, apply params and execute post request
	 * @param oTrigger object TriggerObject which called the action
	 * @param aContextArgs array Contect Arguments
	 */
	public function DoExecute($oTrigger, $aContextArgs) {

		$bDebugMode = MetaModel::GetModuleSetting('itomig-webhook-integration', 'debg_mode', false);
		
		if (MetaModel::IsLogEnabledNotification ()) {
			$oLog = new EventNotificationWebrequestNotification ();
			if ($this->IsBeingTested ()) {
				$oLog->Set ( 'message', 'TEST - Notifcation pending ' );
			} else {
				$oLog->Set ( 'message', 'Notification pending' );
			}
			$oLog->Set ( 'userinfo', UserRights::GetUser () );
			$oLog->Set ( 'webrequest_finalclass', $this->Get ('finalclass') );
			$oLog->Set ( 'trigger_id', $oTrigger->GetKey () );
			$oLog->Set ( 'action_id', $this->GetKey () );
			$oLog->Set ( 'object_id', $aContextArgs ['this->object()']->GetKey () );
			// Must be inserted now so that it gets a valid id that will make the link
			// between an eventual asynchronous task (queued) and the log
			$oLog->DBInsertNoReload ();
		} else {
			$oLog = null;
		}
		
		try {

			$sRes = $this->_DoExecute ($oTrigger, $aContextArgs, $oLog);
			$sPrefix = ($this->IsBeingTested()) ? 'TEST - ' : '';
			if ($oLog)
			{
				$oLog->Set('message', $sPrefix . $sRes);
			}
			
		} catch ( Exception $e ) {
			if ($oLog) {
				$oLog->Set ( 'message', 'Error: ' . $e->getMessage () );
			}
		}
		if ($oLog) {
			$oLog->DBUpdate ();
		}
	}

	/**
	 * Helper function for DoExecute
	 * @param oTrigger object TriggerObject which called the action
	 * @param aContextArgs array Contect Arguments
	 * @param oLog object reference to the Log Object for store information in EventNotification
	 * @return String result
	 */
	private function _DoExecute($oTrigger, $aContextArgs, &$oLog) {
		$sPreviousUrlMaker = ApplicationContext::SetUrlMakerClass ();
		try{
			$this->m_aWebrequestErrors = array();
			// Get URL
			$sWebrequestURL = $this->Get("webrequest_url");
			if (!is_null($oLog)){
				$oLog->Set('webrequest_url',$sWebrequestURL);
			}
			// pepare Post data depending on chat instance (Slack or Rocketchat)
			$aPostParams = $this->preparePostData($oLog);
		}
		catch (Exception $e){
			ApplicationContext::SetUrlMakerClass ( $sPreviousUrlMaker );
			throw $e;
		}
		ApplicationContext::SetUrlMakerClass ( $sPreviousUrlMaker );
		if(empty($this->m_aWebrequestErrors))
		{
			if ($this->IsBeingTested ()) {
				return "WebRequest Notification Action";
			} 
			else { // "enabled" 
				$oWebReq = $this->prepareWebRequest($sWebrequestURL,$aPostParams);
				$iRes = $oWebReq->Send($aIssues, false, $oLog);
				switch ($iRes)
				{
					case WEBREQUEST_SEND_OK:
						return "Sent";

					case WEBREQUEST_SEND_PENDING:
						return "Pending";

					case WEBREQUEST_SEND_ERROR:
						if(is_array($aIssues['httpResponse'])){
							return "Error - HTTP Response: ".implode(', ', $aIssues['httpResponse']);
						}
						return "Errors: ".implode(', ', $aIssues);
				}
			}
		}
		else
		{
			return "Errors: " . implode(', ', $this->m_aWebrequestErrors);
		}
	}

	protected function prepareWebRequest($url, $aPostParam){

		$oWebReq = new WebRequest($url);
		$aCurlOptions = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
			CURLOPT_CONNECTTIMEOUT => MetaModel::GetModuleSetting('itomig-webhook-integration', 'timeout', 5),
			CURLOPT_POSTFIELDS => json_encode($aPostParam)
		);
		if (MetaModel::GetModuleSetting('itomig-webhook-integration', 'certificate_check', true)) {
			$aCurlOptions[CURLOPT_SSL_VERIFYPEER] = 1;
			$aCurlOptions[CURLOPT_SSL_VERIFYHOST] = 2;
		} else {
			// no certificate checks
			$aCurlOptions[CURLOPT_SSL_VERIFYPEER] = 0;
			$aCurlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
		}
		if (($sCertFile = MetaModel::GetModuleSetting( 'itomig-webhook-integration', 'ca_certificate_file', '')) != '') {
			$aCurlOptions[CURLOPT_SSLCERT] = $sCertFile; // The name of a file containing a PEM formatted certificate.
		}
		$oWebReq->setOptArray($aCurlOptions);

		return $oWebReq;
	}

	abstract protected function preparePostData(&$oLog);
}


class EventNotificationWebrequestNotification extends EventNotification {
	public static function Init() {
		$aParams = array (
				"category" => "core/cmdb,view_in_gui",
				"key_type" => "autoincrement",
				"name_attcode" => "",
				"state_attcode" => "",
				"reconc_keys" => array (),
				"db_table" => "priv_event_webrequest_notify",
				"db_key_field" => "id",
				"db_finalclass_field" => "",
				"display_template" => "",
				"order_by_default" => array (
						'date' => false 
				) 
		);
		MetaModel::Init_Params ( $aParams );
		MetaModel::Init_InheritAttributes ();
		
		MetaModel::Init_AddAttribute ( new AttributeText ( "webrequest_url", array (
				"allowed_values" => null,
				"sql" => "webrequest_url",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );
		MetaModel::Init_AddAttribute ( new AttributeText ( "content", array (
				"allowed_values" => null,
				"sql" => "content",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );
		MetaModel::Init_AddAttribute ( new AttributeText ( "webrequest_finalclass", array (
				"allowed_values" => null,
				"sql" => "webrequest_finalclass",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );
		
		MetaModel::Init_AddAttribute ( new AttributeText ( "response", array (
				"allowed_values" => null,
				"sql" => "response",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );
		
		// Display lists
		MetaModel::Init_SetZListItems ( 'details', array (
				'webrequest_finalclass',
				'date',
				'userinfo',
				'message',
				'trigger_id',
				'action_id',
				'object_id',
				'webrequest_url',
				'content',
				'response'
		
		) ); // Attributes to be displayed for the complete details
		
		MetaModel::Init_SetZListItems ( 'list', array (
				'date',
				'webrequest_finalclass',
				'message',
		) ); // Attributes to be displayed for a list
			     
		// Search criteria
			     // MetaModel::Init_SetZListItems('standard_search', array('name')); // Criteria of the std search form
			     // MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}
}

class WebRequest{
	protected $sURL;
	protected $aOptions;

	public function __construct($sURL){
		$this->sURL = $sURL;
		$this->aOptions = array();
	}

	public function setOpt($option, $value){
		$this->$aOptions[$option] = $value;
	}

	public function setOptArray($aOptions){
		foreach ($aOptions as $option => $value) {
			$this->aOptions[$option] = $value;
		}
	}

	public function SendSynchronous(&$aIssues, $oLog = null, $oWebhookLog = null){
		//Execute the request
		try{
			$ch = curl_init($this->sURL);
			curl_setopt_array($ch, $this->aOptions);
			$sContent = curl_exec($ch);

			$sHttpStatus = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
			$sErrMessage = '';
			
			// Check for errors and display the error message
			if ($iErrno = curl_errno ( $ch )) {
				$sErrMessage = curl_error ( $ch );
				$aResult->Errno = $iErrno;
				$aResult->ErrMessage = $sErrMessage;
			}
			
			curl_close ( $ch );

			$aIssues = array(
				'httpResponse' => array(
					'status' => $sHttpStatus,
					'content' => $sContent,
					'errno' => $iErrno,
					'errmsg' => $sErrMessage
				)
			);
			if (($iErrno == 0) && ($sHttpStatus == 200))
			{
				return WEBREQUEST_SEND_OK;
			} 
			else {
				return WEBREQUEST_SEND_ERROR;
			}
		}
		catch(Exception $e) {
			IssueLog::Error('ITOMIG Webhook Integration - ' . $e->getMessage());
			$aIssues = array($e->getMessage());
			return WEBREQUEST_SEND_ERROR;
		}
	}

	protected function SendAsynchronous(&$aIssues, $oLog = null, $oWebhookLog = null)
	{
		try{
			AsyncSendRequest::AddToQueue($this, $oLog);
		}
		catch(Exception $e)
		{
			$aIssues = array($e->GetMessage(),"Exception thrown after tried to add Reuqest to queue");
			return WEBREQUEST_SEND_ERROR;
		}
		$aIssues = array();
		return WEBREQUEST_SEND_PENDING;

	}

	public function Send(&$aIssues, $bForceSynchronous = false, $oLog = null, $oWebhookLog = null)
	{
		if ($bForceSynchronous)
		{
			return $this->SendSynchronous($aIssues, $oLog, $oWebhookLog);
		}
		else{
			$bConfigASYNC = MetaModel::GetModuleSetting('itomig-webhook-integration', 'asynchronous', false);
			if ($bConfigASYNC)
			{
				return $this->SendAsynchronous($aIssues, $oLog, $oWebhookLog);
			}
			else
			{
				return $this->SendSynchronous($aIssues, $oLog, $oWebhookLog);
			}
		}

	}

}

class AsyncSendRequest extends AsyncTask
{
	public static function Init()
	{
		$aParams = array
		(
			"category" => "core/cmdb",
			"key_type" => "autoincrement",
			"name_attcode" => "created",
			"state_attcode" => "",
			"reconc_keys" => array(),
			"db_table" => "priv_async_send_request",
			"db_key_field" => "id",
			"db_finalclass_field" => "",
			"display_template" => "",
		);
		MetaModel::Init_Params($aParams);
		MetaModel::Init_InheritAttributes();

		MetaModel::Init_AddAttribute(new AttributeLongText("request", array("allowed_values"=>null, "sql"=>"request", "default_value"=>null, "is_null_allowed"=>false, "depends_on"=>array())));

	}

	static public function AddToQueue($oWebRequest, $oLog)
	{
		$oNew = MetaModel::NewObject(__class__);
		if ($oLog)
		{
			$oNew->Set('event_id', $oLog->GetKey());
		}
		$oNew->Set('request', serialize($oWebRequest));
		$oNew->DBInsert();
	}

	public function DoProcess()
	{
		$oWebRequest = unserialize($this->Get('request'));

		$iRes = $oWebRequest->Send($aIssues, true);
		
		switch ($iRes)
		{
		case WEBREQUEST_SEND_OK:
			return "Sent";

		case WEBREQUEST_SEND_PENDING:
			return "Bug - the request should be sent in synchronous mode";

		case WEBREQUEST_SEND_ERROR:
			if(is_array($aIssues['httpResponse'])){
				return "Failed - HTTP Response: ".implode(', ', $aIssues['httpResponse']);
			}
			return "Failed: ".implode(', ', $aIssues);
		}
	}
}

/**
 * A user defined action, to customize the application
 *
 * @package itomig-webhook-integration
 *         
 */
abstract class ActionWebhookNotification extends ActionWebRequest {
	public static function Init() {
		$aParams = array (
				"category" => "core/cmdb,application",
				"key_type" => "autoincrement",
				"name_attcode" => "name",
				"state_attcode" => "",
				"reconc_keys" => array (
						'name' 
				),
				"db_table" => "priv_webhook_notify",
				"db_key_field" => "id",
				"db_finalclass_field" => "",
				"display_template" => "" 
		);
		MetaModel::Init_Params ( $aParams );
		MetaModel::Init_InheritAttributes ();
		
		//Init Attributes

		MetaModel::Init_AddAttribute ( new AttributeString ( "channel", array (
				"allowed_values" => null,
				"sql" => "channel",
				"default_value" => "",
				"is_null_allowed" => true,
				"depends_on" => array (),
				"always_load_in_tables"=>false 
		) ) );

		MetaModel::Init_AddAttribute ( new AttributeString ( "bot_alias", array (
				"allowed_values" => null,
				"sql" => "bot_alias",
				"default_value" => "",
				"is_null_allowed" => true,
				"depends_on" => array (),
				"always_load_in_tables"=>false 
		) ) );

		MetaModel::Init_AddAttribute ( new AttributeTemplateHTML ( "text", array (
				"allowed_values" => null,
				"sql" => "text",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );

		MetaModel::Init_AddAttribute( new AttributeEnum("attachment", 
			array(
				"allowed_values"=>new ValueSetEnum("yes,no"), 
				"display_style"=>'radio_horizontal', 
				"sql"=>'attachment', 
				"default_value"=>'no', 
				"is_null_allowed"=>false, 
				"depends_on"=>array(), 
				"always_load_in_tables"=>false
		) ) );

		//Fallback bei Rocketchat?
		MetaModel::Init_AddAttribute (new AttributeTemplateHTML("att_fallback", array(
				"allowed_values"=>null, 
				"sql"=>"att_fallback", 
				"default_value"=>null, 
				"is_null_allowed"=>true, 
				"depends_on"=>array()
		) ) );

		MetaModel::Init_AddAttribute ( new AttributeTemplateString ( "att_title", array (
				"allowed_values"=>null, 
				"sql"=>"att_title", 
				"default_value"=>null, 
				"is_null_allowed"=>true, 
				"depends_on"=>array()
		) ) );
		MetaModel::Init_AddAttribute(new AttributeOQL("att_title_link", array(
			"allowed_values"=>null, 
			"sql"=>"att_title_link", 
			"default_value"=>null, 
			"is_null_allowed"=>true, 
			"depends_on"=>array()
		) ) );
		MetaModel::Init_AddAttribute ( new AttributeString ( "att_color", array (
				"allowed_values" => null,
				"sql" => "att_color",
				"default_value" => "",
				"is_null_allowed" => true,
				"depends_on" => array (),
				"always_load_in_tables"=>false,
				"validation_pattern" => "^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
		) ) );
		MetaModel::Init_AddAttribute ( new AttributeTemplateHTML ( "att_text", array (
				"allowed_values" => null,
				"sql" => "att_text",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );

		// Init displays

		// Attributes to be displayed for the complete details view
		MetaModel::Init_SetZListItems ( 'details', array (
			0 => 'trigger_list',
			'col:col1' => array (
				'fieldset:ActionWebhookNotification:baseinfo' => array (
					0 => 'name',
					1 => 'description',
					2 => 'status',
				),
				'fieldset:ActionWebhookNotification:urlinfo' => array (
					0 => 'webrequest_url',
					1 => 'channel',
					2 => 'bot_alias',
				),
				'fieldset:ActionWebhookNotification:standard' => array(
					0 => 'text',
				),
			),
			'col:col2' => array(
				'fieldset:ActionWebhookNotification:attachment' => array(
					0 => 'attachment',
					1 => 'att_title',
					2 => 'att_title_link',
					3 => 'att_color',
					4 => 'att_text',
					5 => 'att_fallback',
				),
			)		
		) );
		// Attributes to be displayed for a list view
		MetaModel::Init_SetZListItems ( 'list', array (
				'name',
				'finalclass',
				'status',
				'webrequest_url',
				'channel',
				'bot_alias', 
		) );
		// Attributes used as criteriaa of the std search form
		MetaModel::Init_SetZListItems ( 'standard_search', array (
				'name',
				'finalclass',
				'description',
				'status',
				'webrequest_url' 
		) );
		// MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}

	protected function prepareWebRequest($url, $aPostParam){

		$oWebReq = new WebRequest($url);
		//Initiate cURL.
		//$ch = curl_init($url);

		$aCurlOptions = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json'
			),
			CURLOPT_CONNECTTIMEOUT => MetaModel::GetModuleSetting('itomig-webhook-integration', 'timeout', 5),
			CURLOPT_POSTFIELDS => json_encode($aPostParam)
		);
		if (MetaModel::GetModuleSetting('itomig-webhook-integration', 'certificate_check', true)) {
			$aCurlOptions[CURLOPT_SSL_VERIFYPEER] = 1;
			$aCurlOptions[CURLOPT_SSL_VERIFYHOST] = 2;
		} else {
			// no certificate checks
			$aCurlOptions[CURLOPT_SSL_VERIFYPEER] = 0;
			$aCurlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
		}
		if (($sCertFile = MetaModel::GetModuleSetting( 'itomig-webhook-integration', 'ca_certificate_file', '')) != '') {
			$aCurlOptions[CURLOPT_SSLCERT] = $sCertFile; // The name of a file containing a PEM formatted certificate.
		}
		$oWebReq->setOptArray($aCurlOptions);

		return $oWebReq;
	}

	/**
	 * Create a link to an opbejct by an OQL
	 * @param sOqlAttCode String Attribute Code to the OQL Query
	 * @param aArgs array Context Arguments
	 * @return String link to the object or null
	 */
	protected function GetObjectLink($sOqlAttCode, $aArgs){
		$sOQL = $this->Get($sOqlAttCode);
		if (!isset($sOQL) || strlen($sOQL) == '') return '';
		try{
			$oSearch = DBObjectSearch::FromOQL($sOQL);
			$oSearch->AllowAllData();
		}
		catch (OQLException $e)
		{
			$this->m_aWebrequestErrors[] = "query syntax error for recipient '$sOqlAttCode'";
			return $e->getMessage();
		}
		$oSet = new DBObjectSet($oSearch, array() /* order */, $aArgs);
		if($oSet->Count() > 1){
			IssueLog::Warning("ITOMIG Webhook Integration - Multiple results for OQL '$sOqlAttCode'. Just link the first object.");
			//Just Take first
			$sClass = $oSet->GetClass();
			$oObj = $oSet->Fetch();
			return ApplicationContext::MakeObjectUrl($sClass, $oObj->GetKey(), null, true);
		}
		else if ($oSet->Count() > 0){
			$sClass = $oSet->GetClass();
			$oObj = $oSet->Fetch();
			return ApplicationContext::MakeObjectUrl($sClass, $oObj->GetKey(), null, true);
		}
		else{
			$this->m_aWebrequestErrors[] = "No result for OQL '$sOqlAttCode'";
			return null;
		}
	}

	protected function preparePostData(&$oLog){
		$aPostParams_raw = array(
			'sWebhookChannel' => $this->Get('channel'), 
			'sBotAlias' => $this->Get('bot_alias'), 
			'sSendAttachment' => $this->Get('attachment'), 
			'sText' => MetaModel::ApplyParams($this->Get("text"), $aContextArgs), 
			'sAttTitle' => MetaModel::ApplyParams($this->Get("att_title"), $aContextArgs), 
			'sAttTitleLink' => $this->GetObjectLink('att_title_link', $aContextArgs), 
			'sAttColor' => $this->Get('att_color'), 
			'sAttText' => MetaModel::ApplyParams($this->Get("att_text"), $aContextArgs), 
			'sAttFallback' => MetaModel::ApplyParams($this->Get("att_fallback"), $aContextArgs), 
		);
		return $aPostParams_raw;
	}

}


class ActionSlackNotification extends ActionWebhookNotification {
	public static function Init() {
		$aParams = array (
				"category" => "core/cmdb,application",
				"key_type" => "autoincrement",
				"name_attcode" => "name",
				"state_attcode" => "",
				"reconc_keys" => array (
						'name' 
				),
				"db_table" => "priv_salck_notification",
				"db_key_field" => "id",
				"db_finalclass_field" => "",
				"display_template" => "" 
		);
		MetaModel::Init_Params ( $aParams );
		MetaModel::Init_InheritAttributes ();
		
		//Init Attributes

		// Init displays

		// Attributes to be displayed for the complete details view
		MetaModel::Init_SetZListItems ( 'details', array (
			0 => 'trigger_list',
			'col:col1' => array (
				'fieldset:ActionWebhookNotification:baseinfo' => array (
					0 => 'name',
					1 => 'description',
					2 => 'status',
				),
				'fieldset:ActionWebhookNotification:urlinfo' => array (
					0 => 'webrequest_url',
					1 => 'channel',
					2 => 'bot_alias',
				),
				'fieldset:ActionWebhookNotification:standard' => array(
					0 => 'text',
				),
			),
			'col:col2' => array(
				'fieldset:ActionWebhookNotification:attachment' => array(
					0 => 'attachment',
					1 => 'att_title',
					2 => 'att_title_link',
					3 => 'att_color',
					4 => 'att_text',
					5 => 'att_fallback',
				),
			)		
		) );
		// Attributes to be displayed for a list view
		MetaModel::Init_SetZListItems ( 'list', array (
				'name',
				'status',
				'webrequest_url',
				'channel',
				'bot_alias', 
		) );
		// Attributes used as criteriaa of the std search form
		MetaModel::Init_SetZListItems ( 'standard_search', array (
				'name',
				'description',
				'status',
				'webrequest_url' 
		) );
		// MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}

	protected function preparePostData(&$oLog){
		$aPostParams_raw = parent::preparePostData($oLog);

		$slackData = array();
		$slackData['mrkdwn'] = true;

		if (isset ( $aPostParams_raw['sText'] )){
			$aPostParams_raw['sText'] = $this->prepareTextForSlack($aPostParams_raw['sText']);
			$slackData['text'] = $aPostParams_raw['sText'];
		}
		if (isset ( $aPostParams_raw['sWebhookChannel'] )){
			$slackData['channel'] = $aPostParams_raw['sWebhookChannel'];
		}
		if (isset ( $aPostParams_raw['sBotAlias'] )){
			$slackData['username'] = $aPostParams_raw['sBotAlias'];
		}
		if (isset ( $aPostParams_raw['sSendAttachment'] ) 
			&& ($aPostParams_raw['sSendAttachment'] === 'yes' || $aPostParams_raw['sSendAttachment'] === 'Ja')){
			$att_params = array();
			if (isset ( $aPostParams_raw['sAttTitle'] )){
				$att_params['title'] = $aPostParams_raw['sAttTitle'];
			}
			if (isset ( $aPostParams_raw['sAttTitleLink'] )){
				$att_params['title_link'] = $aPostParams_raw['sAttTitleLink'];
			}
			if (isset ( $aPostParams_raw['sAttColor'] )){
				$att_params['color'] = $aPostParams_raw['sAttColor'];
			}
			if (isset ( $aPostParams_raw['sAttText'] )){
				$aPostParams_raw['sAttText'] = $this->prepareTextForSlack($aPostParams_raw['sAttText']);
				$att_params['text'] = $aPostParams_raw['sAttText'];
				$att_params['mrkdwn_in'] = array("text");
			}
			if (isset ( $aPostParams_raw['sAttFallback'] )){
				$aPostParams_raw['sAttFallback'] = $this->prepareTextForSlack($aPostParams_raw['sAttFallback']);
				$att_params['fallback'] = $aPostParams_raw['sAttFallback'];
			}
			$slackData['attachments'][] = $att_params;
		}
		$oLog->Set ( 'content', "POST Data: \n" . print_r($slackData,true) );
		return $slackData;
	}

	/**
	 * Transform html to slack markdown language
	 * @param sText String HTML text
	 * @return String markdown text
	 */
	private function prepareTextForSlack($sText){
		//convert html to slack markdown
		if(!empty($sText)){
			$sText = strip_tags($sText, '<h1><h2><h3><br><strong><em><del><li><code><pre><a></a>');
	        $sText = str_replace(array('<br />', '<br>'), "\n", $sText);
	        $sText = str_replace(array('<h1>', '</h1>'), array('*', '*'), $sText);
	        $sText = str_replace(array('<h2>', '</h2>'), array('*', '*'), $sText);
	        $sText = str_replace(array('<h3>', '</h3>'), array('*', '*'), $sText);
	        $sText = str_replace(array('<strong>', '</strong>'), array('*', '*'), $sText);
	        $sText = str_replace(array('<em>', '</em>'), array('_', '_'), $sText);
	        $sText = str_replace(array('<del>', '</del>'), array('~', '~'), $sText);
	        $sText = str_replace(array('<li>', '</li>'), array('â€¢', ''), $sText);
	        $sText = str_replace(array('<code>', '</code>'), array('`', '`'), $sText);
	        $sText = str_replace(array('<pre>', '</pre>'), array('```', '```'), $sText);

	        preg_match_all('/<a href=\"(.*?)\">(.*?)<\/a>/i', $sText, $res);
	        for($i = 0; $i < count($res[0]); $i++) {
	            $sText = str_replace($res[0][$i], '<'.$res[1][$i].'|'.$res[2][$i].'>', $sText);
	        }
	    }
		return $sText;
	}

}

class ActionRocketChatNotification extends ActionWebhookNotification {
	public static function Init() {
		$aParams = array (
				"category" => "core/cmdb,application",
				"key_type" => "autoincrement",
				"name_attcode" => "name",
				"state_attcode" => "",
				"reconc_keys" => array (
						'name' 
				),
				"db_table" => "priv_rocket_notification",
				"db_key_field" => "id",
				"db_finalclass_field" => "",
				"display_template" => "" 
		);
		MetaModel::Init_Params ( $aParams );
		MetaModel::Init_InheritAttributes ();
		
		//Init Attributes

		// Init displays

		// Attributes to be displayed for the complete details view
		MetaModel::Init_SetZListItems ( 'details', array (
			0 => 'trigger_list',
			'col:col1' => array (
				'fieldset:ActionWebhookNotification:baseinfo' => array (
					0 => 'name',
					1 => 'description',
					2 => 'status',
				),
				'fieldset:ActionWebhookNotification:urlinfo' => array (
					0 => 'webrequest_url',
					1 => 'channel',
					2 => 'bot_alias',
				),
				'fieldset:ActionWebhookNotification:standard' => array(
					0 => 'text',
				),
			),
			'col:col2' => array(
				'fieldset:ActionWebhookNotification:attachment' => array(
					0 => 'attachment',
					1 => 'att_title',
					2 => 'att_title_link',
					3 => 'att_color',
					4 => 'att_text',
					5 => 'att_fallback',
				),
			)		
		) );
		// Attributes to be displayed for a list view
		MetaModel::Init_SetZListItems ( 'list', array (
				'name',
				'status',
				'webrequest_url',
				'channel',
				'bot_alias', 
		) );
		// Attributes used as criteriaa of the std search form
		MetaModel::Init_SetZListItems ( 'standard_search', array (
				'name',
				'description',
				'status',
				'webrequest_url' 
		) );
		// MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}

	protected function preparePostData(&$oLog){
		$aPostParams_raw = parent::preparePostData($oLog);
		$rocketData = array();
		//$rocketData['mrkdwn'] = true;

		if (isset ( $aPostParams_raw['sText'] )){
			$aPostParams_raw['sText'] = $this->prepareTextForRocket($aPostParams_raw['sText']);
			$rocketData['text'] = $aPostParams_raw['sText'];
		}
		if (isset ( $aPostParams_raw['sWebhookChannel'] )){
			$rocketData['channel'] = $aPostParams_raw['sWebhookChannel'];
		}
		if (isset ( $aPostParams_raw['sBotAlias'] )){
			$rocketData['username'] = $aPostParams_raw['sBotAlias'];
		}
		if (isset ( $aPostParams_raw['sSendAttachment'] ) 
			&& ($aPostParams_raw['sSendAttachment'] === 'yes' || $aPostParams_raw['sSendAttachment'] === 'Ja')){
			$att_params = array();
			if (isset ( $aPostParams_raw['sAttTitle'] )){
				$att_params['title'] = $aPostParams_raw['sAttTitle'];
			}
			if (isset ( $aPostParams_raw['sAttTitleLink'] )){
				$att_params['title_link'] = $aPostParams_raw['sAttTitleLink'];
			}
			if (isset ( $aPostParams_raw['sAttColor'] )){
				$att_params['color'] = $aPostParams_raw['sAttColor'];
			}
			if (isset ( $aPostParams_raw['sAttText'] )){
				$aPostParams_raw['sAttText'] = $this->prepareTextForRocket($aPostParams_raw['sAttText']);
				$att_params['text'] = $aPostParams_raw['sAttText'];
				//$att_params['mrkdwn_in'] = array("text");
			}
			if (isset ( $aPostParams_raw['sAttFallback'] )){
				$aPostParams_raw['sAttFallback'] = $this->prepareTextForRocket($aPostParams_raw['sAttFallback']);
				$att_params['fallback'] = $aPostParams_raw['sAttFallback'];
			}
			$rocketData['attachments'][] = $att_params;
		}
		$oLog->Set ( 'content', "POST Data: \n" . print_r($rocketData,true) );
		return $rocketData;
	}

	/**
	 * Transform html to rocket markdown language
	 * @param sText String HTML text
	 * @return String markdown text
	 */
	private function prepareTextForRocket($sText){
		//convert html to slack markdown
		if(!empty($sText)){
			$sText = strip_tags($sText, '<h1><h2><h3><br><strong><em><del><li><code><pre><a></a>');
	        $sText = str_replace(array('<br />', '<br>'), "\n", $sText);
	        $sText = str_replace(array('<h1>', '</h1>'), array('**', '**'), $sText);
	        $sText = str_replace(array('<h2>', '</h2>'), array('**', '**'), $sText);
	        $sText = str_replace(array('<h3>', '</h3>'), array('**', '**'), $sText);
	        $sText = str_replace(array('<strong>', '</strong>'), array('**', '**'), $sText);
	        $sText = str_replace(array('<em>', '</em>'), array('__', '__'), $sText);
	        $sText = str_replace(array('<del>', '</del>'), array('~', '~'), $sText);
	        $sText = str_replace(array('<li>', '</li>'), array('* ', ''), $sText);
	        $sText = str_replace(array('<code>', '</code>'), array('`', '`'), $sText);
	        $sText = str_replace(array('<pre>', '</pre>'), array('`', '`'), $sText);

	        preg_match_all('/<a href=\"(.*?)\">(.*?)<\/a>/i', $sText, $res);
	        for($i = 0; $i < count($res[0]); $i++) {
	            $sText = str_replace($res[0][$i], '['.$res[2][$i].']('.$res[1][$i].')', $sText);
	        }
	    }
		return $sText;
	}

}

?>