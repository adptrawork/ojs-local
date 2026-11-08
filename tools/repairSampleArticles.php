<?php
define('INDEX_FILE_LOCATION', dirname(__DIR__) . '/index.php');
require dirname(__DIR__) . '/lib/pkp/classes/cliTool/CliTool.inc.php';
import('classes.journal.Journal');
import('classes.submission.Submission');
import('classes.publication.Publication');
import('classes.article.Author');

class RepairSampleArticles extends CommandLineTool {
	public function execute() {
		$request = Application::get()->getRequest();
		$this->_ensureDispatcher($request);
		$this->_setAdminUser();
		$journal = Services::get('context')->get(1);
		Registry::set('context', $journal);
		$request->_context = $journal;

		foreach (array(8, 10) as $submissionId) {
			$submissionDao = DAORegistry::getDAO('SubmissionDAO');
			$publicationDao = DAORegistry::getDAO('PublicationDAO');
			$pubId = null;
			$pubs = Services::get('publication')->getMany(array('submissionIds' => $submissionId));
			foreach ($pubs as $p) { $pubId = $p->getId(); }
			if (!$pubId) { echo "FAIL sub $submissionId: no publication\n"; continue; }

			$submissionDao->updateObject((function() use ($submissionDao, $submissionId, $pubId) {
				$s = $submissionDao->getById($submissionId);
				$s->setData('currentPublicationId', $pubId);
				$s->stampModified();
				return $s;
			})());

			// Fix keywords (stored as nested array; remove to avoid indexer crash) and publish
			$publicationDao->updateObject((function() use ($publicationDao, $pubId) {
				$p = $publicationDao->getById($pubId);
				$p->setData('keywords', null);
				return $p;
			})());

			$pub = Services::get('publication')->get($pubId);
			try {
				$pub = Services::get('publication')->publish($pub);
				echo "OK    sub=$submissionId pub={$pub->getId()} status={$pub->getData('status')}\n";
			} catch (Throwable $e) {
				// publish() may throw in hooks after DB commit
				$pub = Services::get('publication')->get($pubId);
				echo "WARN  sub=$submissionId pub={$pub->getId()} status={$pub->getData('status')} hookErr={$e->getMessage()}\n";
			}
		}
		echo "Done.\n";
	}
	private function _ensureDispatcher($request) {
		$base = Config::getVar('general', 'base_url');
		$dispatcher = new class($base) {
			private $base; public function __construct($b){$this->base=rtrim((string)$b,'/');}
			public function url($request,$shortcut,$newContext=null,$handler=null,$op=null,$path=null,$params=null,$anchor=null,$escape=false){
				$parts=array($this->base,'index.php'); if($newContext)$parts[]=$newContext; if($handler)$parts[]=$handler; if($op)$parts[]=$op; if($path)$parts[]=is_array($path)?implode('/',$path):$path; return implode('/',$parts);
			}
		};
		$request->_dispatcher = $dispatcher; $request->_context = null;
	}
	private function _setAdminUser() {
		$admin = DAORegistry::getDAO('UserDAO')->getByUsername('admin');
		Registry::set('user', $admin); return $admin;
	}
}
$tool = new RepairSampleArticles(isset($argv)?$argv:array());
$tool->execute();
