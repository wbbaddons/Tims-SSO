<?php
namespace wcf\system\event\listener;
use \wcf\system\application\ApplicationHandler;

/**
 * Logs out globally.
 *
 * @author 	Tim Düsterhus
 * @copyright	2010-2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.sso
 * @subpackage	system.event.listener
 */
class LogoutActionSSOListener implements \wcf\system\event\IEventListener {
	/**
	 * @see	\wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		$applications = ApplicationHandler::getInstance()->getApplications();
		
		// why the heck are you installing this plugin?!
		if (count($applications) === 1) return;
		
		$activeApplication = ApplicationHandler::getInstance()->getActiveApplication();
		
		$abbreviations = array();
		foreach ($applications as $key => $application) {
			// we don't have to set cookies for the active application, skip
			if ($application === $activeApplication) continue;
			$abbreviations[] = ApplicationHandler::getInstance()->getAbbreviation($application->packageID);
		}
		
		$cookies = array(
			array('name' => 'userID', 'value' => 0, 'expires' => 0),
			array('name' => 'password', 'value' => '', 'expires' => 0),
			array('name' => 'cookieHash', 'value' => '__invalid', 'expires' => 0)
		);
		
		$cookies = base64_encode(\wcf\util\JSON::encode($cookies));
		
		\wcf\system\WCF::getTPL()->assign(array(
			'sso' => true,
			'ssoAbbreviations' => $abbreviations,
			'ssoSessionID' => \wcf\system\session\SessionHandler::getInstance()->sessionID,
			'ssoCookies' => $cookies,
			'ssoHMAC' => hash_hmac('sha1', $cookies, SSO_SALT)
		));
	}
}
