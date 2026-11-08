<?php
define('INDEX_FILE_LOCATION', dirname(__DIR__) . '/index.php');
require dirname(__DIR__) . '/lib/pkp/classes/cliTool/CliTool.inc.php';
class FixSampleKeywords extends CommandLineTool {
	public function execute() {
		$dao = DAORegistry::getDAO('SubmissionKeywordDAO'); /* @var $dao SubmissionKeywordDAO */
		$map = array(
			8 => array('en_US' => array('corporate governance', 'earnings quality', 'emerging markets', 'audit committee')),
			9 => array('id_ID' => array('kepemimpinan transformasional', 'motivasi kerja', 'kinerja karyawan')),
			10 => array('en_US' => array('fintech', 'financial inclusion', 'microenterprises', 'digital literacy')),
		);
		foreach ($map as $pubId => $keywords) {
			try {
				$dao->insertKeywords($keywords, $pubId, true, ASSOC_TYPE_PUBLICATION);
				echo "OK pub $pubId\n";
			} catch (Throwable $e) {
				echo "FAIL pub $pubId: {$e->getMessage()} @ {$e->getFile()}:{$e->getLine()}\n";
			}
		}
		echo "Done.\n";
	}
}
(new FixSampleKeywords(isset($argv)?$argv:array()))->execute();
