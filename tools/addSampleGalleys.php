<?php
/**
 * Add a placeholder PDF galley to sample articles (publications 6-10).
 * Idempotent: skips publications that already have a PDF galley.
 * Usage: php tools/addSampleGalleys.php
 */
define('INDEX_FILE_LOCATION', dirname(__DIR__) . '/index.php');
require dirname(__DIR__) . '/lib/pkp/classes/cliTool/CliTool.inc.php';

import('classes.journal.Journal');
import('classes.submission.Submission');
import('classes.publication.Publication');
import('classes.article.ArticleGalley');

use Illuminate\Database\Capsule\Manager as Capsule;

class AddSampleGalleys extends CommandLineTool {
	public function execute() {
		$request = Application::get()->getRequest();
		$this->_ensureDispatcher($request);
		$admin = DAORegistry::getDAO('UserDAO')->getByUsername('admin');
		Registry::set('user', $admin);
		$journal = Services::get('context')->get(1);
		Registry::set('context', $journal);

		$items = array(
			array('subId'=>6,'pubId'=>6,'locale'=>'id_ID','title'=>'article-6'),
			array('subId'=>7,'pubId'=>7,'locale'=>'id_ID','title'=>'article-7'),
			array('subId'=>8,'pubId'=>8,'locale'=>'en_US','title'=>'article-8'),
			array('subId'=>9,'pubId'=>9,'locale'=>'id_ID','title'=>'article-9'),
			array('subId'=>10,'pubId'=>10,'locale'=>'en_US','title'=>'article-10'),
		);

		foreach ($items as $it) {
			try {
				$this->_addGalley($it, $admin, $journal);
			} catch (Throwable $e) {
				echo "FAIL pub {$it['pubId']}: {$e->getMessage()} @ {$e->getFile()}:{$e->getLine()}\n";
			}
		}
		echo "Done.\n";
	}

	private function _addGalley($it, $admin, $journal) {
		$galleyDao = DAORegistry::getDAO('ArticleGalleyDAO'); /* @var $galleyDao ArticleGalleyDAO */
		$existing = $galleyDao->getByPublicationId($it['pubId'])->toArray();
		foreach ($existing as $g) { if ($g->getLabel() === 'PDF') { echo "SKIP pub {$it['pubId']} (PDF galley exists)\n"; return; } }

		$filesDir = Config::getVar('files', 'files_dir');
		$relDir = 'journals/1/articles/' . $it['subId'];
		$absDir = rtrim($filesDir, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relDir);
		if (!is_dir($absDir)) @mkdir($absDir, 0777, true);

		$filename = $it['title'] . '.pdf';
		$relPath = $relDir . '/' . $filename;
		$absPath = $absDir . DIRECTORY_SEPARATOR . $filename;
		$fileService = Services::get('file');
		// Remove any stale file at destination (flysystem won't overwrite)
		if ($fileService->fs->has($relPath)) $fileService->fs->delete($relPath);
		@unlink($absPath);
		$tmp = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'op_' . $it['subId'] . '_' . $filename;
		file_put_contents($tmp, $this->_minimalPdf($it['title']));
		$fileId = $fileService->add($tmp, $relPath);
		@unlink($tmp);
		if (!$fileId) throw new Exception('file insert failed');

		$now = Core::getCurrentDate();
		$sfId = Capsule::table('submission_files')->insertGetId(array(
			'submission_id' => (int)$it['subId'],
			'file_id' => (int)$fileId,
			'source_submission_file_id' => null,
			'genre_id' => 1,
			'file_stage' => defined('SUBMISSION_FILE_PROOF') ? SUBMISSION_FILE_PROOF : 10,
			'direct_sales_price' => null,
			'sales_type' => null,
			'viewable' => 1,
			'created_at' => $now,
			'updated_at' => $now,
			'uploader_user_id' => (int)$admin->getId(),
			'assoc_type' => null,
			'assoc_id' => null,
		), 'submission_file_id');
		Capsule::table('submission_file_revisions')->insert(array(
			'submission_file_id' => (int)$sfId,
			'file_id' => (int)$fileId,
		));
		Capsule::table('submission_file_settings')->insert(array(
			'submission_file_id' => (int)$sfId,
			'locale' => $it['locale'],
			'setting_name' => 'name',
			'setting_value' => $filename,
			'setting_type' => 'string',
		));

		$galley = $galleyDao->newDataObject();
		$galley->setData('publicationId', (int)$it['pubId']);
		$galley->setData('label', 'PDF');
		$galley->setData('locale', $it['locale']);
		$galley->setData('seq', 0);
		$galley->setData('submissionFileId', (int)$sfId);
		$galley->setData('isApproved', 1);
		$galleyId = $galleyDao->insertObject($galley);

		$assocRep = defined('ASSOC_TYPE_REPRESENTATION') ? ASSOC_TYPE_REPRESENTATION : 521;
		Capsule::table('submission_files')->where('submission_file_id', (int)$sfId)->update(array(
			'assoc_type' => $assocRep,
			'assoc_id' => (int)$galleyId,
		));

		echo "OK    pub {$it['pubId']} galley={$galleyId} file={$fileId} submission_file={$sfId}\n";
	}

	private function _minimalPdf($text) {
		$text = str_replace(array('(',')','\\'), array('\\(','\\)','\\\\'), $text);
		$stream = "BT /F1 14 Tf 50 100 Td ($text) Tj ET";
		$objs = array();
		$objs[1] = '1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj';
		$objs[2] = '2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj';
		$objs[3] = '3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 300 144]/Resources<</Font<</F1 4 0 R>>>>/Contents 5 0 R>>endobj';
		$objs[4] = '4 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj';
		$objs[5] = '5 0 obj<</Length ' . strlen($stream) . '>>stream\n' . $stream . "\nendstream\nendobj";
		$pdf = "%PDF-1.4\n";
		$offsets = array(0 => 0);
		for ($i=1;$i<=5;$i++) { $offsets[$i] = strlen($pdf); $pdf .= $objs[$i] . "\n"; }
		$xrefPos = strlen($pdf);
		$pdf .= "xref\n0 6\n";
		$pdf .= "0000000000 65535 f \n";
		for ($i=1;$i<=5;$i++) $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
		$pdf .= "trailer<</Size 6/Root 1 0 R>>\nstartxref\n{$xrefPos}\n%%EOF\n";
		return $pdf;
	}

	private function _ensureDispatcher($request) {
		$base = Config::getVar('general', 'base_url');
		$dispatcher = new class($base) {
			private $base; public function __construct($b){$this->base=rtrim((string)$b,'/');}
			public function url($request,$shortcut,$newContext=null,$handler=null,$op=null,$path=null,$params=null,$anchor=null,$escape=false){
				$parts=array($this->base,'index.php'); if($newContext)$parts[]=$newContext; if($handler)$parts[]=$handler; if($op)$parts[]=$op; if($path)$parts[]=is_array($path)?implode('/',$path):$path; return implode('/',$parts);
			}
		};
		$request->_dispatcher = $dispatcher;
	}
}
(new AddSampleGalleys(isset($argv)?$argv:array()))->execute();
