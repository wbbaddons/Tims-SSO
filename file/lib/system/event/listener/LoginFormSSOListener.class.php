<?php
namespace wcf\system\event\listener;
use \wcf\system\application\ApplicationHandler;

/**
 * Performs SSO after login.
 *
 * @author 	Tim Düsterhus
 * @copyright	2010-2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.chat
 * @subpackage	system.event.listener
 */
class LoginFormSSOListener implements \wcf\system\event\IEventListener {
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
		
		$cookies = array();
		if (true || SSO_PERSISTENT_LOGIN && $eventObj->useCookies) {
			$user = $eventObj->user;
			
			$cookies = array(
				'userID' => $user->userID,
				'password' => \wcf\util\PasswordUtil::getSaltedHash($eventObj->password, $user->password),
				'__time' => TIME_NOW
			);
		}
		
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
