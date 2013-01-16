<?php
namespace wcf\action;
use \wcf\util\HeaderUtil;

/**
 * Sets proper cookies.
 * 
 * @author 	Tim Düsterhus
 * @copyright	2010-2013 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.sso
 * @subpackage	action
 */
class SSOAction extends AbstractAction {
	/**
	 * @see	\wcf\action\IAction::execute()
	 */
	public function execute() {
		parent::execute();
		
		\wcf\system\session\SessionHandler::getInstance()->disableUpdate();
		
		if (isset($_GET['cookies']) && isset($_GET['key'])) {
			$hmac = hash_hmac('sha1', $_GET['cookies'], SSO_SALT);
			
			if (!\wcf\util\PasswordUtil::secureCompare($_GET['key'], $hmac)) throw new \wcf\system\exception\IllegalLinkException();
			
			$cookies = \wcf\util\JSON::decode(base64_decode($_GET['cookies']));
			
			foreach ($cookies as $cookie) HeaderUtil::setCookie($cookie['name'], $cookie['value'], $cookie['expires']);
			
			header("Content-Type: image/gif");
			echo base64_decode('R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
			
			$this->executed();
			
			exit;
		}
		
		throw new \wcf\system\exception\IllegalLinkException();
	}
}
