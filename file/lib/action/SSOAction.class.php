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
		
		header("Content-Type: image/gif");
		echo base64_decode('R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
		
		$this->executed();
		exit;
	}
}
