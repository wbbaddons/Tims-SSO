<?php
namespace be\bastelstu\wcf\sso;

/**
 * Generates a random key.
 *
 * @author 	Tim Düsterhus
 * @copyright	2010-2012 Tim Düsterhus
 * @license	Creative Commons Attribution-NonCommercial-ShareAlike <http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode>
 * @package	be.bastelstu.wcf.sso
 */
final class Installation {
	private $optionID;
	public function __construct($packageID) {
		$sql = "SELECT
				optionID
			FROM
				wcf".WCF_N."_option
			WHERE
					packageID = ?
				AND	optionName = ?";
		$stmt = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$stmt->execute(array($packageID, 'sso_salt'));
		$this->optionID = $stmt->fetchColumn();
	}
	
	public function execute() {
		$sql = "UPDATE
				wcf".WCF_N."_option
			SET
				optionValue = ?
			WHERE
				optionID = ?";
		$stmt = \wcf\system\WCF::getDB()->prepareStatement($sql);
		$stmt->execute(array(\wcf\util\StringUtil::getRandomID(), $this->optionID));
		\wcf\data\option\OptionEditor::resetCache();
	}
}
$installation = new Installation($this->installation->getPackageID());
$installation->execute();
