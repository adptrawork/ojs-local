<?php

/**
 * Create 1 published issue + sample published articles for JRDC (journal_id=1).
 * Usage: php tools/createSampleArticles.php
 *
 * Idempotent: skips if Vol 1 No 1 (2026) already exists for JRDC.
 * Text-only (no PDF galleys).
 */

define('INDEX_FILE_LOCATION', dirname(__DIR__) . '/index.php');
require dirname(__DIR__) . '/lib/pkp/classes/cliTool/CliTool.inc.php';

import('classes.journal.Journal');
import('classes.issue.Issue');
import('classes.submission.Submission');
import('classes.publication.Publication');
import('classes.article.Author');

class CreateSampleArticles extends CommandLineTool {
	private $journalId = 1;
	private $locale = 'en_US';

	public function execute() {
		$request = Application::get()->getRequest();
		$this->_ensureDispatcher($request);
		$admin = $this->_setAdminUser();
		$journal = Services::get('context')->get($this->journalId);
		if (!$journal) {
			fwrite(STDERR, "ERROR: journal {$this->journalId} not found.\n");
			exit(1);
		}
		// Some services read context from the request.
		Registry::set('context', $journal);
		$request->_context = $journal;

		$issueDao = DAORegistry::getDAO('IssueDAO'); /* @var $issueDao IssueDAO */
		$existing = $this->_findIssue($issueDao, $journal->getId(), 1, '1', 2026);
		if ($existing) {
			echo "SKIP  Issue Vol 1 No 1 (2026) already exists (issue_id={$existing->getId()}).\n";
			echo "Done. created=0\n";
			return;
		}

		$issue = $this->_createIssue($issueDao, $journal->getId());
		echo "OK    Issue Vol {$issue->getVolume()} No {$issue->getNumber()} ({$issue->getYear()}) issue_id={$issue->getId()}\n";

		$sectionId = $this->_getSectionId($journal->getId());
		$authorGroupId = $this->_getAuthorGroupId($journal->getId());
		if (!$sectionId || !$authorGroupId) {
			fwrite(STDERR, "ERROR: missing section or author user group for journal {$journal->getId()}.\n");
			exit(1);
		}

		$articles = $this->_articles();
		$created = 0;
		foreach ($articles as $i => $a) {
			try {
				$pubId = $this->_createPublishedArticle($journal, $issue, $sectionId, $authorGroupId, $admin, $a, $i + 1, $request);
				echo "OK    Article [{$a['locale']}] {$a['title']} (publication_id={$pubId})\n";
				$created++;
			} catch (Throwable $e) {
				echo "FAIL  {$a['title']}: {$e->getMessage()}\n";
				echo "      " . $e->getFile() . ':' . $e->getLine() . "\n";
			}
		}

		echo "\nDone. created={$created} articles in issue {$issue->getId()}\n";
		echo "Check: http://ojs-3.3.0-24.test/index.php/jrdc/issue/current\n";
	}

	private function _createPublishedArticle($journal, $issue, $sectionId, $authorGroupId, $admin, $a, $seq, $request) {
		$submissionDao = DAORegistry::getDAO('SubmissionDAO'); /* @var $submissionDao SubmissionDAO */
		$submission = $submissionDao->newDataObject();
		$submission->setData('contextId', $journal->getId());
		$submission->setData('status', STATUS_QUEUED);
		$submission->setData('submissionProgress', 0);
		// Production stage so validatePublish-style rules are satisfiable; publish() updates status.
		$submission->setData('stageId', defined('WORKFLOW_STAGE_ID_PRODUCTION') ? WORKFLOW_STAGE_ID_PRODUCTION : 5);
		$submission->setData('locale', $a['locale']);
		$submission->stampLastActivity();
		$submission->stampModified();
		$submission->setData('dateSubmitted', Core::getCurrentDate());
		$submissionId = $submissionDao->insertObject($submission);

		$publicationDao = DAORegistry::getDAO('PublicationDAO'); /* @var $publicationDao PublicationDAO */
		$publication = $publicationDao->newDataObject();
		$publication->setData('submissionId', $submissionId);
		$publication->setData('version', 1);
		$publication->setData('status', STATUS_QUEUED);
		$publication->setData('datePublished', Core::getCurrentDate());
		$publication->setData('locale', $a['locale']);
		$publication->setData('sectionId', (int)$sectionId);
		$publication->setData('issueId', (int)$issue->getId());
		$publication->setData('seq', (float)$seq);
		$publication->setData('accessStatus', ARTICLE_ACCESS_ISSUE_DEFAULT);
		$publication->setData('title', array($a['locale'] => $a['title']), $a['locale']);
		$publication->setData('abstract', array($a['locale'] => $a['abstract']), $a['locale']);
		$publication->setData('keywords', array($a['locale'] => $a['keywords']), $a['locale']);
		$publication->setData('pages', $a['pages']);
		if (!empty($a['copyrightYear'])) $publication->setData('copyrightYear', $a['copyrightYear']);
		$publicationId = $publicationDao->insertObject($publication);

		// Author
		$authorDao = DAORegistry::getDAO('AuthorDAO'); /* @var $authorDao AuthorDAO */
		$author = $authorDao->newDataObject();
		$author->setData('publicationId', $publicationId);
		$author->setData('email', $a['author']['email']);
		$author->setData('includeInBrowse', 1);
		$author->setData('seq', 1);
		$author->setData('userGroupId', (int)$authorGroupId);
		$author->setGivenName($a['author']['given'], $a['locale']);
		$author->setFamilyName($a['author']['family'], $a['locale']);
		$author->setAffiliation($a['author']['affiliation'], $a['locale']);
		$author->setData('country', $a['author']['country']);
		$authorId = $authorDao->insertObject($author);

		// Set primary contact (column on publications) and link submission -> publication
		$publicationDao->updateObject((function() use ($publicationDao, $publicationId, $authorId) {
			$p = $publicationDao->getById($publicationId);
			$p->setData('primaryContactId', (int)$authorId);
			return $p;
		})());
		$submissionDao->updateObject((function() use ($submissionDao, $submissionId, $publicationId) {
			$s = $submissionDao->getById($submissionId);
			$s->setData('currentPublicationId', $publicationId);
			$s->stampModified();
			return $s;
		})());

		$pub = Services::get('publication')->get($publicationId);
		$pub = Services::get('publication')->publish($pub);

		return $pub->getId();
	}

	private function _createIssue($issueDao, $journalId) {
		$issue = $issueDao->newDataObject();
		$issue->setJournalId($journalId);
		$issue->setVolume(1);
		$issue->setNumber('1');
		$issue->setYear(2026);
		$issue->setPublished(1);
		$issue->setCurrent(1);
		$issue->setDatePublished(Core::getCurrentDate());
		$issue->setAccessStatus(ISSUE_ACCESS_OPEN);
		$issue->setShowVolume(1);
		$issue->setShowNumber(1);
		$issue->setShowYear(1);
		$issue->setShowTitle(0);
		$issue->setTitle('Vol. 1 No. 1 (2026): Articles', $this->locale);
		$issueId = $issueDao->insertObject($issue);
		$issue->setId($issueId);
		// Ensure only this issue is current for the journal
		$issueDao->updateCurrent($journalId, $issue);
		return $issue;
	}

	private function _findIssue($issueDao, $journalId, $volume, $number, $year) {
		$issues = $issueDao->getIssues($journalId);
		while ($i = $issues->next()) {
			if ((int)$i->getVolume() === (int)$volume && (string)$i->getNumber() === (string)$number && (int)$i->getYear() === (int)$year) return $i;
		}
		return null;
	}

	private function _getSectionId($journalId) {
		$sectionDao = DAORegistry::getDAO('SectionDAO'); /* @var $sectionDao SectionDAO */
		$sections = $sectionDao->getByContextId($journalId);
		if ($s = $sections->next()) return $s->getId();
		return null;
	}

	private function _getAuthorGroupId($journalId) {
		$userGroupDao = DAORegistry::getDAO('UserGroupDAO'); /* @var $userGroupDao UserGroupDao */
		$groups = $userGroupDao->getByRoleId($journalId, ROLE_ID_AUTHOR);
		while ($g = $groups->next()) return $g->getId();
		return null;
	}

	private function _ensureDispatcher($request) {
		$base = Config::getVar('general', 'base_url');
		$dispatcher = new class($base) {
			private $base;
			public function __construct($base) { $this->base = rtrim((string)$base, '/'); }
			public function url($request, $shortcut, $newContext = null, $handler = null, $op = null, $path = null, $params = null, $anchor = null, $escape = false) {
				$parts = array($this->base, 'index.php');
				if ($newContext) $parts[] = $newContext;
				if ($handler) $parts[] = $handler;
				if ($op) $parts[] = $op;
				if ($path) $parts[] = is_array($path) ? implode('/', $path) : $path;
				return implode('/', $parts);
			}
		};
		$request->_dispatcher = $dispatcher;
		if (method_exists($request, 'setDispatcher')) $request->setDispatcher($dispatcher);
	}

	private function _setAdminUser() {
		$userDao = DAORegistry::getDAO('UserDAO'); /* @var $userDao UserDAO */
		$admin = $userDao->getByUsername('admin');
		if (!$admin) { fwrite(STDERR, "ERROR: admin user not found.\n"); exit(1); }
		Registry::set('user', $admin);
		return $admin;
	}

	private function _articles() {
		return array(
			array(
				'locale' => 'id_ID',
				'title' => 'Pengaruh Literasi Keuangan dan Perilaku Konsumtif terhadap Keputusan Investasi Mahasiswa',
				'abstract' => '<p>Penelitian ini bertujuan menganalisis pengaruh literasi keuangan dan perilaku konsumtif terhadap keputusan investasi mahasiswa. Pendekatan kuantitatif digunakan dengan menyebarkan kuesioner kepada 120 responden yang dipilih secara purposive. Data dianalisis menggunakan regresi linier berganda. Hasil menunjukkan literasi keuangan berpengaruh positif dan signifikan, sedangkan perilaku konsumtif berpengaruh negatif dan signifikan terhadap keputusan investasi. Temuan ini menegaskan pentingnya edukasi keuangan sejak dini bagi mahasiswa.</p>',
				'keywords' => array('literasi keuangan', 'perilaku konsumtif', 'keputusan investasi'),
				'pages' => '1-12',
				'copyrightYear' => 2026,
				'author' => array('given' => 'Dewi', 'family' => 'Lestari', 'affiliation' => 'Program Studi Manajemen, Universitas Dirgantara', 'email' => 'dewi.lestari@sample.test', 'country' => 'ID'),
			),
			array(
				'locale' => 'id_ID',
				'title' => 'Dampak Modal Kerja dan Digitalisasi Pemasaran terhadap Kinerja UMKM Kuliner',
				'abstract' => '<p>Studi ini menguji dampak modal kerja dan digitalisasi pemasaran terhadap kinerja usaha mikro, kecil, dan menengah (UMKM) sektor kuliner. Sebanyak 95 pelaku UMKM menjadi responden melalui survei lapangan. Analisis SEM-PLS menunjukkan modal kerja dan digitalisasi pemasaran berpengaruh positif signifikan terhadap kinerja UMKM, baik secara parsial maupun simultan. Digitalisasi pemasaran terbukti memperkuat jangkauan pasar dan efisiensi promosi.</p>',
				'keywords' => array('modal kerja', 'digitalisasi pemasaran', 'kinerja UMKM'),
				'pages' => '13-25',
				'copyrightYear' => 2026,
				'author' => array('given' => 'Budi', 'family' => 'Santoso', 'affiliation' => 'Fakultas Ekonomi dan Bisnis, Universitas Nusantara', 'email' => 'budi.santoso@sample.test', 'country' => 'ID'),
			),
			array(
				'locale' => 'en_US',
				'title' => 'Corporate Governance Mechanisms and Earnings Quality: Evidence from Emerging Markets',
				'abstract' => '<p>This study examines the relationship between corporate governance mechanisms and earnings quality in emerging market firms. Using panel data from 150 listed companies over 2021-2024, we analyze board independence, audit committee effectiveness, and ownership concentration. The findings indicate that board independence and audit committee effectiveness are positively associated with earnings quality, while concentrated ownership shows a mixed effect. The results contribute to the governance literature in emerging economies.</p>',
				'keywords' => array('corporate governance', 'earnings quality', 'emerging markets', 'audit committee'),
				'pages' => '26-40',
				'copyrightYear' => 2026,
				'author' => array('given' => 'Andi', 'family' => 'Pratama', 'affiliation' => 'Department of Accounting, Airlangga University', 'email' => 'andi.pratama@sample.test', 'country' => 'ID'),
			),
			array(
				'locale' => 'id_ID',
				'title' => 'Pengaruh Kepemimpinan Transformasional dan Motivasi Kerja terhadap Kinerja Karyawan',
				'abstract' => '<p>Penelitian ini menelaah pengaruh kepemimpinan transformasional dan motivasi kerja terhadap kinerja karyawan pada perusahaan jasa. Data dikumpulkan dari 110 karyawan melalui kuesioner terstruktur dan dianalisis dengan regresi berganda. Hasil penelitian menunjukkan kepemimpinan transformasional dan motivasi kerja berpengaruh positif signifikan terhadap kinerja karyawan. Implikasi manajerial menekankan pentingnya gaya kepemimpinan yang inspiratif dan sistem penghargaan yang adil.</p>',
				'keywords' => array('kepemimpinan transformasional', 'motivasi kerja', 'kinerja karyawan'),
				'pages' => '41-53',
				'copyrightYear' => 2026,
				'author' => array('given' => 'Siti', 'family' => 'Rahmawati', 'affiliation' => 'Program Studi Manajemen, Universitas Cendikia', 'email' => 'siti.rahmawati@sample.test', 'country' => 'ID'),
			),
			array(
				'locale' => 'en_US',
				'title' => 'Fintech Adoption and Financial Inclusion among Microenterprises in Indonesia',
				'abstract' => '<p>This paper investigates the determinants of fintech adoption and its effect on financial inclusion among microenterprises in Indonesia. Survey data from 200 microenterprise owners were analyzed using structural equation modeling. The results reveal that perceived usefulness, trust, and digital literacy significantly drive fintech adoption, which in turn improves access to credit and payment services. Policy implications for inclusive digital finance are discussed.</p>',
				'keywords' => array('fintech', 'financial inclusion', 'microenterprises', 'digital literacy'),
				'pages' => '54-68',
				'copyrightYear' => 2026,
				'author' => array('given' => 'Rizky', 'family' => 'Hidayat', 'affiliation' => 'Faculty of Economics, Gadjah Mada University', 'email' => 'rizky.hidayat@sample.test', 'country' => 'ID'),
			),
		);
	}
}

$tool = new CreateSampleArticles(isset($argv) ? $argv : array());
$tool->execute();
