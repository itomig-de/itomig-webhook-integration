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

/**
 * Web request
 * sending web requests to $sURL with specific options 
 * via curl
 *
 */
class WebRequest{
	protected $sURL;
	protected $aOptions;

	/**
	 * Create a new objects of this class
	 * @param string $sURL Url which should called with this request
	 * @return WebRequest new Object of this class
	 */
	public function __construct($sURL){
		$this->sURL = $sURL;
		$this->aOptions = array();
	}

	/**
	 * Sets Opt Option for curl
	 * @param string $option name of curl option to be set
	 * @param string $value value to be set
	 * @return void
	 */
	public function setOpt($option, $value){
		$this->$aOptions[$option] = $value;
	}

	/**
	 * Sets mulltiple opt options for curl at once
	 * @param string $aOption array with key values for options
	 * @return void
	 */
	public function setOptArray($aOptions){
		foreach ($aOptions as $option => $value) {
			$this->aOptions[$option] = $value;
		}
	}

	/**
	 * Send the reuqest synchronous
	 * @param Array $aIssues reference to an array for holding errors or other feeback information
	 * @param EventNotificationWebrequestNotification $oLog Object where status information can be written in
	 * @return Intenger status auf webrequest
	 */
	public function SendSynchronous(&$aIssues, $oLog = null){
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

	/**
	 * Send the reuqest asynchronous, add request to a queue of async tasks
	 * @param Array $aIssues reference to an array for holding errors or other feeback information
	 * @param EventNotificationWebrequestNotification $oLog Object where status information can be written in
	 * @return Intenger status auf webrequest
	 */
	protected function SendAsynchronous(&$aIssues, $oLog = null)
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

	/**
	 * Send the reuqest
	 * @param Array $aIssues reference to an array for holding errors or other feeback information
	 * @param boolean $bForceSynchronous if set to true request will send synch anyway regardless of the configuration
	 * @param EventNotificationWebrequestNotification $oLog Object where status information can be written in
	 * @return Intenger status auf webrequest
	 */
	public function Send(&$aIssues, $bForceSynchronous = false, $oLog = null)
	{
		if ($bForceSynchronous)
		{
			return $this->SendSynchronous($aIssues, $oLog);
		}
		else{
			$bConfigASYNC = MetaModel::GetModuleSetting('itomig-webhook-integration', 'asynchronous', false);
			if ($bConfigASYNC)
			{
				return $this->SendAsynchronous($aIssues, $oLog);
			}
			else
			{
				return $this->SendSynchronous($aIssues, $oLog);
			}
		}
	}
}

/**
 * Configure web request calls
 * in objectes of these class
 *
 */
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
		// Create NotificationObject to Log Status information if enabled
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
			$oLog->DBInsertNoReload ();
		} else {
			$oLog = null;
		}
		
		try {
			//Execute Request
			$sRes = $this->_DoExecute ($oTrigger, $aContextArgs, $oLog);
			$sPrefix = ($this->IsBeingTested()) ? 'TEST - ' : '';
			// Logging Feedback
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
			// pepare post data depending on finalclass
			$aPostParams = $this->preparePostData($aContextArgs, $oLog);
		}
		catch (Exception $e){
			ApplicationContext::SetUrlMakerClass ( $sPreviousUrlMaker );
			throw $e;
		}
		ApplicationContext::SetUrlMakerClass ( $sPreviousUrlMaker );
		if(empty($this->m_aWebrequestErrors))
		{ // If no error occurred until now
			if ($this->IsBeingTested ()) {
				// No Execution in Test mode
				return "WebRequest Notification Action";
			} 
			else { 
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

	/**
	 * Helper function for prepareing curl request
	 * Could be overridden by child classes
	 * @param url String url for request
	 * @param aPostParam array post parameters
	 * @return WebRequest Webrequest with Params and Options
	 */
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

	abstract protected function preparePostData($aContextArgs, &$oLog);
}

/**
 * Configure webhook calls (i.e. Slack)
 * in objectes of these class
 *
 */
abstract class _ActionWebhookNotification extends ActionWebRequest {

	/**
	 * returns a link to the first found object by oql
	 * @param sOqlAttCode String code of attribute which contains oql
	 * @param aArgs array arguments for oql
	 * @return String link to first result
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

	/**
	 * prepares data for the request
	 * @param oLog object reference to the Log Object for store information in EventNotification
	 * @return Array contains data for request
	 */
	protected function preparePostData($aContextArgs, &$oLog){
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

/**
 * Logging status and content of web requests
 * in objectes of these class
 *
 */
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

/**
 * Sending WebRequests Async
 *
 */
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

?>