<?php

/**
 * Create sample journals via OJS's official context service.
 * Usage: php tools/createSampleJournals.php
 *
 * Idempotent: journals whose urlPath already exists are skipped.
 * Run from the OJS root with the same PHP version as the web server.
 */

define('INDEX_FILE_LOCATION', dirname(__DIR__) . '/index.php');
require dirname(__DIR__) . '/lib/pkp/classes/cliTool/CliTool.inc.php';

class CreateSampleJournals extends CommandLineTool {
	public function execute() {
		$request = Application::get()->getRequest();
		$this->_ensureDispatcher($request);
		$userDao = DAORegistry::getDAO('UserDAO'); /* @var $userDao UserDAO */
		$admin = $userDao->getByUsername('admin');
		if (!$admin) {
			fwrite(STDERR, "ERROR: admin user not found.\n");
			exit(1);
		}
		// Services::get('context')->add() assigns the manager group to the
		// current request user.
		Registry::set('user', $admin);

		$contextDao = Application::getContextDAO();
		$samples = $this->samples();
		$created = 0;
		$skipped = 0;

		foreach ($samples as $s) {
			$existing = $contextDao->getByPath($s['urlPath']);
			if ($existing) {
				echo "SKIP  {$s['urlPath']} (already exists, id={$existing->getId()})\n";
				$skipped++;
				continue;
			}

			$journal = $contextDao->newDataObject();
			$journal->setData('urlPath', $s['urlPath']);
			$journal->setPath($s['urlPath']);
			$journal->setData('name', array('en_US' => $s['name'], 'id_ID' => $s['name']));
			$journal->setData('acronym', array('en_US' => $s['acronym']));
			$journal->setData('abbreviation', array('en_US' => $s['abbreviation']));
			$journal->setData('description', array('en_US' => $s['description'], 'id_ID' => $s['description']));
			$journal->setData('contactName', $s['contactName']);
			$journal->setData('contactEmail', $s['contactEmail']);
			$journal->setData('supportName', $s['contactName']);
			$journal->setData('supportEmail', $s['contactEmail']);
			$journal->setData('primaryLocale', 'en_US');
			$journal->setData('supportedLocales', array('en_US', 'id_ID'));
			$journal->setData('supportedSubmissionLocales', array('en_US', 'id_ID'));
			$journal->setData('supportedFormLocales', array('en_US', 'id_ID'));
			$journal->setData('enabled', true);
			$journal->setData('itemsPerPage', 25);
			$journal->setData('numPageLinks', 10);

			try {
				$journal = Services::get('context')->add($journal, $request);
				echo "OK    {$s['urlPath']} (id={$journal->getId()}) {$s['name']}\n";
				$created++;
			} catch (Throwable $e) {
				echo "FAIL  {$s['urlPath']}: {$e->getMessage()}\n";
			}
		}

		echo "\nDone. created={$created}, skipped={$skipped}\n";
	}

	/**
	 * CLI bootstrap does not wire a Dispatcher; context creation needs
	 * $request->getDispatcher()->url() for locale params.
	 */
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
		// PKPRequest::_dispatcher is a plain var in 3.3
		$request->_dispatcher = $dispatcher;
		if (method_exists($request, 'setDispatcher')) $request->setDispatcher($dispatcher);
	}

	private function samples() {
		$contact = 'Editorial Office';
		$email = 'editor@sample.test';
		return array(
			array(
				'urlPath' => 'jmkd',
				'name' => 'Jurnal Manajemen dan Kewirausahaan Dirgantara',
				'acronym' => 'JMKD',
				'abbreviation' => 'JMKD',
				'description' => '<p>Jurnal Manajemen dan Kewirausahaan Dirgantara (JMKD) is a peer-reviewed, open access journal publishing research on management, entrepreneurship, and business strategy.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jakd',
				'name' => 'Jurnal Akuntansi dan Keuangan Dirgantara',
				'acronym' => 'JAKD',
				'abbreviation' => 'JAKD',
				'description' => '<p>Jurnal Akuntansi dan Keuangan Dirgantara (JAKD) is a peer-reviewed, open access journal publishing research on accounting, auditing, taxation, and finance.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jepd',
				'name' => 'Jurnal Ekonomi Pembangunan Dirgantara',
				'acronym' => 'JEPD',
				'abbreviation' => 'JEPD',
				'description' => '<p>Jurnal Ekonomi Pembangunan Dirgantara (JEPD) publishes peer-reviewed research on development economics, public policy, and regional economics.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jbdd',
				'name' => 'Jurnal Bisnis Digital Dirgantara',
				'acronym' => 'JBDD',
				'abbreviation' => 'JBDD',
				'description' => '<p>Jurnal Bisnis Digital Dirgantara (JBDD) focuses on digital business, e-commerce, fintech, and technology-driven entrepreneurship.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jeksd',
				'name' => 'Jurnal Ekonomi Syariah Dirgantara',
				'acronym' => 'JEKSD',
				'abbreviation' => 'JEKSD',
				'description' => '<p>Jurnal Ekonomi Syariah Dirgantara (JEKSD) publishes peer-reviewed studies on Islamic economics, Islamic finance, and halal business.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jtd',
				'name' => 'Jurnal Teknologi Dirgantara',
				'acronym' => 'JTD',
				'abbreviation' => 'JTD',
				'description' => '<p>Jurnal Teknologi Dirgantara (JTD) is a peer-reviewed journal covering applied technology, information systems, and engineering innovation.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jpmd',
				'name' => 'Jurnal Pengabdian Masyarakat Dirgantara',
				'acronym' => 'JPMD',
				'abbreviation' => 'JPMD',
				'description' => '<p>Jurnal Pengabdian Masyarakat Dirgantara (JPMD) publishes community service, empowerment, and applied social innovation articles.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jpid',
				'name' => 'Jurnal Pendidikan dan Inovasi Dirgantara',
				'acronym' => 'JPID',
				'abbreviation' => 'JPID',
				'description' => '<p>Jurnal Pendidikan dan Inovasi Dirgantara (JPID) publishes research on education, learning innovation, and instructional development.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jhkd',
				'name' => 'Jurnal Hukum dan Kebijakan Dirgantara',
				'acronym' => 'JHKD',
				'abbreviation' => 'JHKD',
				'description' => '<p>Jurnal Hukum dan Kebijakan Dirgantara (JHKD) publishes peer-reviewed articles on law, regulation, governance, and public policy.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
			array(
				'urlPath' => 'jksd',
				'name' => 'Jurnal Kesehatan dan Sosial Dirgantara',
				'acronym' => 'JKSD',
				'abbreviation' => 'JKSD',
				'description' => '<p>Jurnal Kesehatan dan Sosial Dirgantara (JKSD) publishes research on public health, social welfare, and community well-being.</p>',
				'contactName' => $contact, 'contactEmail' => $email,
			),
		);
	}
}

$tool = new CreateSampleJournals(isset($argv) ? $argv : array());
$tool->execute();
