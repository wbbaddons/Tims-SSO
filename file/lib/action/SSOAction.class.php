<?php
namespace wcf\action;

/**
 * Does nothing.
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
		
		$this->executed();
		header("HTTP/1.0 204 No Content");
		exit;
	}
}
