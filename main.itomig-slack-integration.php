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
require_once (APPROOT . '/core/email.class.inc.php');
require_once (APPROOT . '/core/action.class.inc.php');

/**
 * A user defined action, to customize the application
 *
 * @package itomig-slack-integration
 *         
 */
class ActionSlackNotification extends ActionNotification {
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
		MetaModel::Init_AddAttribute( new AttributeEnum("debug_trace", 
			array(
				"allowed_values"=>new ValueSetEnum("yes,no"), 
				"display_style"=>'select', 
				"sql"=>'debug_trace', 
				"default_value"=>'no', 
				"is_null_allowed"=>false, 
				"depends_on"=>array(), 
				"always_load_in_tables"=>false
		) ) );

		MetaModel::Init_AddAttribute ( new AttributeURL ( "slack_url", array (
				"allowed_values" => null,
				"sql" => "slack_url",
				"default_value" => null,
				"target" => "_blank",
				"is_null_allowed" => false,
				"depends_on" => array (),
				"validation_pattern" => "^(https\://hooks\.slack\.com/services/.*)$"
		) ) );

		MetaModel::Init_AddAttribute ( new AttributeString ( "channel", array (
				"allowed_values" => null,
				"sql" => "channel",
				"default_value" => "",
				"is_null_allowed" => true,
				"depends_on" => array (),
				"always_load_in_tables"=>false 
		) ) );

		MetaModel::Init_AddAttribute ( new AttributeString ( "slackbot_name", array (
				"allowed_values" => null,
				"sql" => "slackbot_name",
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
				'fieldset:ActionSlackNotification:baseinfo' => array (
					0 => 'name',
					1 => 'description',
					2 => 'status',
					3 => 'debug_trace',
				),
				'fieldset:ActionSlackNotification:urlinfo' => array (
					0 => 'slack_url',
					1 => 'channel',
					2 => 'slackbot_name',
				),
				'fieldset:ActionSlackNotification:standard' => array(
					0 => 'text',
				),
			),
			'col:col2' => array(
				'fieldset:ActionSlackNotification:attachment' => array(
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
				'slack_url',
				'channel',
				'slackbot_name', 
		) );
		// Attributes used as criteriaa of the std search form
		MetaModel::Init_SetZListItems ( 'standard_search', array (
				'name',
				'description',
				'status',
				'slack_url' 
		) );
		// MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}

	//Custom log
	private $oSlackLog;

	/**
	 * Checks whether debug trace is enabled
	 * @return boolean True in case of enabled debug trace, false otherwise
	 */
	private function DebugTrace(){
		$sDebugTrace = $this->Get('debug_trace');
		if(isset($sDebugTrace) && ($sDebugTrace === 'yes' || $sDebugTrace === 'Ja')){
			return true;
		}
		return false;
	}
	
	/**
	 * Execute when Action is called, Get fields, apply params and execute post request
	 * @param oTrigger object TriggerObject which called the action
	 * @param aContextArgs array Contect Arguments
	 */
	public function DoExecute($oTrigger, $aContextArgs) {
		
		if (MetaModel::IsLogEnabledNotification ()) {
			$oLog = new EventNotificationSlackNotification ();
			if ($this->IsBeingTested ()) {
				$oLog->Set ( 'message', 'TEST - Notifcation pending ' );
			} else {
				$oLog->Set ( 'message', 'Notification pending' );
			}
			$oLog->Set ( 'userinfo', UserRights::GetUser () );
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
			if($this->DebugTrace()){
				$this->oSlackLog = new FileLog(APPROOT.'log/slackintegration.log');
			}

			$sRes = $this->_DoExecute ( $oTrigger, $aContextArgs, $oLog );
			if($this->oSlackLog){
				$this->oSlackLog->Info ( "_DoExecute returned:" . $sRes );
			}
			if ($this->IsBeingTested ()) {
				$sPrefix = 'TEST  - ';
			} else {
				$sPrefix = '';
			}
			if($this->oSlackLog){
				$this->oSlackLog->Info ( "message=" . $sPrefix . $sRes );
			}
			if ($oLog) {
				$oLog->Set ( 'message', $sPrefix . $sRes );
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
	protected function _DoExecute($oTrigger, $aContextArgs, &$oLog) {
		if($this->oSlackLog){
			$this->oSlackLog->Info ( "_DoExecute" );
		}
		
		$sPreviousUrlMaker = ApplicationContext::SetUrlMakerClass ();
		
		// Get URL
		$sCallSlack = $this->Get ( "slack_url" ); // is always set because mandatory field
		
		try {
			$bRes = false; // until we do succeed in sending notification

			// substitude iTop Variables in parameters
			$sSlackChannel = $this->Get('channel');
			$sSlackBotName = $this->Get('slackbot_name');
			$sSendAttachment = $this->Get('attachment');

			$sText = MetaModel::ApplyParams ( $this->Get ( "text" ), $aContextArgs );
			$sAttTitle = MetaModel::ApplyParams ( $this->Get ( "att_title" ), $aContextArgs );
			$sAttTitleLink = $this->GetObjectLink('att_title_link', $aContextArgs);
			$sAttColor = $this->Get('att_color');
			$sAttText = MetaModel::ApplyParams ( $this->Get ( "att_text" ), $aContextArgs );
			$sAttFallback = MetaModel::ApplyParams ( $this->Get ( "att_fallback" ), $aContextArgs );
			
			$oObj = $aContextArgs ['this->object()'];
		} catch ( Exception $e ) {
			ApplicationContext::SetUrlMakerClass ( $sPreviousUrlMaker );
			throw $e;
		}
		ApplicationContext::SetUrlMakerClass ( $sPreviousUrlMaker );
		
		if (! is_null ( $oLog )) {
			// Note: we have to secure this because those values are calculated
			// inside the try statement, and we would like to keep track of as
			// many data as we could while some variables may still be undefined
			
			$oLog->Set ( 'slack_url', $sCallSlack );
			
			if (isset ( $sSlackChannel ))
			 	$oLog->Set ( 'channel', $sSlackChannel );
			if (isset ( $sSlackBotName ))
			 	$oLog->Set ( 'slackbot_name', $sSlackBotName );
		}
		if($this->oSlackLog){
			$this->oSlackLog->Info ( "CallUrl Action" );
		}
		if ($this->IsBeingTested ()) {
			if($this->oSlackLog){
				$this->oSlackLog->Info ( "CallUrl Action - TEST only" );
			}
			if (isset ( $sText )) {
				return "Call-URL TEST Status: OK";
			} else {
				return "Call-URL TEST Warning: Text is empty";
			}
		} else { // "enabled"
			try {
				// issue http request (post)
				if($this->oSlackLog){
					$this->oSlackLog->Info ('Starting slack notification:');
				}

				$slackData = array();
				$slackData['mrkdwn'] = true;

				if (isset ( $sText )){
					$sText = $this->prepareTextForSlack($sText);
					$slackData['text'] = $sText;
				}
				if (isset ( $sSlackChannel )){
					$slackData['channel'] = $sSlackChannel;
				}
				if (isset ( $sSlackBotName )){
					$slackData['username'] = $sSlackBotName;
				}
				if (isset ( $sSendAttachment ) 
					&& ($sSendAttachment === 'yes' || $sSendAttachment === 'Ja')){
					$att_params = array();
					if (isset ( $sAttTitle )){
						$att_params['title'] = $sAttTitle;
					}
					if (isset ( $sAttTitleLink )){
						$att_params['title_link'] = $sAttTitleLink;
					}
					if (isset ( $sAttColor )){
						$att_params['color'] = $sAttColor;
					}
					if (isset ( $sAttText )){
						$sAttText = $this->prepareTextForSlack($sAttText);
						$att_params['text'] = $sAttText;
						$att_params['mrkdwn_in'] = array("text");
					}
					if (isset ( $sAttFallback )){
						$sAttFallback = $this->prepareTextForSlack($sAttFallback);
						$att_params['fallback'] = $sAttFallback;
					}
					$slackData['attachments'][] = $att_params;
				}
				if($this->oSlackLog){
					$this->oSlackLog->Info ("Slack Data: \n". print_r($slackData, true));
				}

				$aResult = $this->curl_post($sCallSlack,$slackData);
				
				// there are two possible types of errors:
				//     1. the server returns an error, for example (404, not found)
				//                this will be reported in the variable $aResult ['status'] != 200
				//     2. curl cannot execute the post-statement, for example "SSL Error"
				//                this will be reported as the $aResult ['errno'] != 0
				if($this->oSlackLog){
					$this->oSlackLog->Info ( "curl err=" . $aResult ['errno'] . " \n err-msg=" . $aResult ['errmsg'] );
				}
				
				if (! is_null ( $oLog )) {
					if (($aResult ['errno'] == 0) && ($aResult ['status'] == 200)) {
						$oLog->Set ( "message", "Call OK" );
					} else {
						if ($aResult ['errno'] != 0) {
						$oLog->Set ( "message", "Status: " . $aResult ['status'] . " ErrNo=" . $aResult ['errno'] . "err-msg=" . $aResult ['errmsg'] );
						} else {
							$oLog->Set ( "message", "Status: " . $aResult ['status']);
						}
						} 
					if ($aResult['content']) {  // is == false, if there is no content
						$oLog->Set ( "response", $aResult ['content'] );
					}
				}
				
				if (($aResult ['errno'] == 0) && ($aResult ['status'] == 200)) {
					// display only "OK"
					return "Status: OK";
				} else {
					// display status number and status message
					if ($aResult ['errno'] != 0) {
						return "Status: " . $aResult ['status'] . " ErrNo: " . $aResult ['errno'] . " /  " . $aResult ['errmsg'];
					} else {
						return "Status: " . $aResult ['status'];
					}
				}
			} catch ( Exception $e ) {
				if($this->oSlackLog){
					$this->oSlackLog->Error ( "ERROR: " . $e->getMessage () );
				}
				return "Call-Slack ERROR: " . $e->getMessage ();
			}
		}
	}
	
	/**
	 * read module settings to build the curl options and exec http post
	 * @param url String URL to call
	 * @param aParams array Parameter to for request
	 * @return array response of the curl request
	 */
	private function curl_post($url, $aParams){

		$postParam = array(
			'payload' => json_encode($aParams)
		);

		//Initiate cURL.
		$ch = curl_init($url);


		$bCertCheck = MetaModel::GetModuleSetting ( 'itomig-slack-integration', 'certificate_check', true );
		if ($bCertCheck) {
			// curl_setopt($ch, CURLOPT_SSLVERSION, 3); // needed ?
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 1 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
		} else {
			// no certificate checks
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		}
		
		$iTimeout = MetaModel::GetModuleSetting ( 'itomig-slack-integration', 'timeout', 5 );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $iTimeout );

		$sCertFile = MetaModel::GetModuleSetting ( 'itomig-slack-integration', 'ca_certificate_file', '' );
		if ($sCertFile != '') {
			curl_setopt ( $ch, CURLOPT_SSLCERT, $sCertFile ); // The name of a file containing a PEM formatted certificate.
		}
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);	 
		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postParam);		 
		//Execute the request
		$sContent = curl_exec($ch);

		$sHttpStatus = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		$sErrMessage = '';
		
		// Check for errors and display the error message
		if ($iErrno = curl_errno ( $ch )) {
			$sErrMessage = curl_error ( $ch );
			if($this->oSlackLog){
				$this->oSlackLog->Error ( "cURL error ({$iErrno}):\n {$sErrMessage}" );
			}
			$aResult->Errno = $iErrno;
			$aResult->ErrMessage = $sErrMessage;
		}
		
		curl_close ( $ch );
		
		$aResponse = array (
				'status' => $sHttpStatus,
				'content' => $sContent,
				'errno' => $iErrno,
				'errmsg' => $sErrMessage 
		);
		return $aResponse;
	}

	protected $m_aSlackErrors; // array of strings explaining the issue

	/**
	 * Create a link to an opbejct by an OQL
	 * @param sOqlAttCode String Attribute Code to the OQL Query
	 * @param aArgs array Context Arguments
	 * @return String link to the object or null
	 */
	private function GetObjectLink($sOqlAttCode, $aArgs){
		$sOQL = $this->Get($sOqlAttCode);
		if (!isset($sOQL) || strlen($sOQL) == '') return '';
		try{
			$oSearch = DBObjectSearch::FromOQL($sOQL);
			$oSearch->AllowAllData();
		}
		catch (OQLException $e)
		{
			if($this->oSlackLog){
				$this->oSlackLog->Error("query syntax error for OQL '$sOqlAttCode': " . $e->getMessage());
			}
			return null;
		}
		$oSet = new DBObjectSet($oSearch, array() /* order */, $aArgs);
		if($oSet->Count() > 1){
			$this->oSlackLog->Warning("Multiple results for OQL '$sOqlAttCode'. Just link the first object.");
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
			if($this->oSlackLog){
				$this->oSlackLog->Warning("No result for OQL '$sOqlAttCode'");
			}
			return null;
		}
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
	        $sText = str_replace(array('<li>', '</li>'), array('•', ''), $sText);
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

class EventNotificationSlackNotification extends EventNotification {
	public static function Init() {
		$aParams = array (
				"category" => "core/cmdb,view_in_gui",
				"key_type" => "autoincrement",
				"name_attcode" => "",
				"state_attcode" => "",
				"reconc_keys" => array (),
				"db_table" => "priv_event_salck_notification",
				"db_key_field" => "id",
				"db_finalclass_field" => "",
				"display_template" => "",
				"order_by_default" => array (
						'date' => false 
				) 
		);
		MetaModel::Init_Params ( $aParams );
		MetaModel::Init_InheritAttributes ();
		
		MetaModel::Init_AddAttribute ( new AttributeText ( "slack_url", array (
				"allowed_values" => null,
				"sql" => "slack_url",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );
		MetaModel::Init_AddAttribute ( new AttributeText ( "channel", array (
				"allowed_values" => null,
				"sql" => "channel",
				"default_value" => null,
				"is_null_allowed" => true,
				"depends_on" => array () 
		) ) );
		MetaModel::Init_AddAttribute ( new AttributeText ( "slackbot_name", array (
				"allowed_values" => null,
				"sql" => "slackbot_name",
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
				'date',
				'userinfo',
				'message',
				'trigger_id',
				'action_id',
				'object_id',
				'slack_url',
				'channel',
				'slackbot_name',
				'response' 
		
		) ); // Attributes to be displayed for the complete details
		
		MetaModel::Init_SetZListItems ( 'list', array (
				'date',
				'message',
				'channel',
				'slackbot_name' 
		) ); // Attributes to be displayed for a list
			     
		// Search criteria
			     // MetaModel::Init_SetZListItems('standard_search', array('name')); // Criteria of the std search form
			     // MetaModel::Init_SetZListItems('advanced_search', array('name')); // Criteria of the advanced search form
	}
}

?>
