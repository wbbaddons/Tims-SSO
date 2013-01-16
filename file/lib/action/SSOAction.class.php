<?php
namespace wcf\action;

/**
 * Outputs 1pxx1px transparent gif.
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
		
		if (isset($_GET['cookies']) && isset($_GET['key'])) {
			$hmac = hash_hmac('sha1', $_GET['cookies'], SSO_SALT);
			
			if (!\wcf\util\PasswordUtil::secureCompare($_GET['key'], $hmac)) throw new \wcf\system\exception\IllegalLinkException();
			
			$cookies = \wcf\util\JSON::decode(base64_decode($_GET['cookies']));
			\wcf\util\HeaderUtil::setCookie('userID', $cookies['userID'], $cookies['__time'] + 365 * 24 * 3600);
			\wcf\util\HeaderUtil::setCookie('password', $cookies['password'], $cookies['__time'] + 365 * 24 * 3600);
		}
		
		header("Content-Type: image/gif");
		echo base64_decode('R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
		
		$this->executed();
		exit;
	}
}
