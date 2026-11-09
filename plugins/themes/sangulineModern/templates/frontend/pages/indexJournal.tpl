{**
 * SangulineModern child theme - journal index override
 * High-fidelity layout matching Tailwind prototype:
 * 1. Full-width Hero Banner (spanning 12 columns above the grid)
 * 2. 2-Column Grid (Main 8 columns + Sidebar 4 columns)
 * 3. Enclosing White Cards for "Tentang Jurnal" and "Terbitan Jurnal Terbaru"
 *
 * @uses $currentJournal Journal This journal
 * @uses $journalDescription string Journal description
 * @uses $homepageImage object Image to be displayed on the homepage
 * @uses $additionalHomeContent string Arbitrary input from HTML text editor
 * @uses $announcements array List of announcements
 * @uses $numAnnouncementsHomepage int Number of announcements to display
 * @uses $issue Issue Current issue
 *}
{include file="frontend/components/header.tpl" pageTitleTranslated=$currentJournal->getLocalizedName() suppressContentWrapper=true}

<div class="page_index_journal jrdc-home">

	{call_hook name="Templates::Index::journal"}

	{* =========================================================================
	   1. FULL-WIDTH HOMEPAGE HERO CONTAINER (NAVY #0b2038, MAX-W-7XL)
	   ========================================================================= *}
	<div class="jrdc-hero-wrapper">
		<section class="jrdc-hero-container" aria-label="{translate|escape key="about.aboutContext"}">
			<div class="jrdc-hero__content">
				<div class="jrdc-hero__badge">
					JURNAL ILMIAH &bull; EKONOMI DAN BISNIS
				</div>
				<h1 class="jrdc-hero__title">
					{$currentJournal->getLocalizedName()|escape}
				</h1>
				<div class="jrdc-hero__desc">
					{if $currentContext->getLocalizedData('description')}
						{$currentContext->getLocalizedData('description')|strip_tags|truncate:260}
					{else}
						Jurnal ilmiah akses terbuka yang menerbitkan penelitian dan kajian bidang ekonomi dan bisnis dengan telaah sejawat double-blind. Terbit dua kali setahun, pada April dan Oktober.
					{/if}
				</div>
				<div class="jrdc-hero__meta">
					<div class="jrdc-hero__meta-card">
						<span class="meta-label">FREKUENSI</span>
						<span class="meta-value">April &amp; Oktober</span>
					</div>
					<div class="jrdc-hero__meta-card">
						<span class="meta-label">PENERBIT</span>
						<span class="meta-value">
							{if $currentContext->getData('publisherInstitution')}
								{$currentContext->getData('publisherInstitution')|escape}
							{else}
								Yayasan Ratu Dirgantara Cendekiawan (JRDC)
							{/if}
						</span>
					</div>
				</div>
			</div>

			{* Cover image right side *}
			<div class="jrdc-hero__cover">
				{if $homepageImage}
					<img src="{$publicFilesDir}/{$homepageImage.uploadName|escape:"url"}" alt="{$currentJournal->getLocalizedName()|escape}" width="{$homepageImage.width|default:220|escape}" height="{$homepageImage.height|default:290|escape}" loading="eager">
				{elseif $issue && $issue->getLocalizedCoverImageUrl()}
					<img src="{$issue->getLocalizedCoverImageUrl()|escape}" alt="{$issue->getIssueIdentification()|escape}" loading="eager">
				{else}
					<div class="jrdc-hero__cover-placeholder">
						<span class="jrdc-hero__cover-kicker">COVER JURNAL</span>
						<span class="jrdc-hero__cover-title">JRDC</span>
						<span class="jrdc-hero__cover-bar"></span>
					</div>
				{/if}
			</div>

			<div class="jrdc-hero__actions">
				{if $issue}
					<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="view" path=$issue->getBestIssueId()}" class="jrdc-button jrdc-button--primary jrdc-hero__cta">Lihat Edisi Terbaru</a>
				{/if}
				<a href="{url page="about" op="submissions"}" class="jrdc-button jrdc-button--outline jrdc-hero__cta">Panduan Penulis</a>
			</div>
		</section>
	</div>

	{* Sidebar column is rendered by footer.tpl from its single
	   Templates::Common::Sidebar hook call (Block Manager plugin).
	   Do not call the hook here: it would run plugins twice.
	   The grid keeps has_sidebar; if the sidebar is empty the footer
	   outputs no <aside> and CSS collapses to one column. *}
	{if $isFullWidth}
		{assign var="hasSidebar" value=0}
	{else}
		{assign var="hasSidebar" value=1}
	{/if}

	<div class="pkp_structure_content{if $hasSidebar} has_sidebar{/if} jrdc-content">
		<div id="pkp_content_main" class="pkp_structure_main jrdc-main" role="main">

			{* Card A: Tentang Jurnal *}
			<section class="jrdc-card-section" aria-labelledby="homepageAboutTitle">
				<div class="jrdc-card-header">
					<h2 id="homepageAboutTitle" class="jrdc-card-title">Tentang Jurnal</h2>
				</div>
				<div class="jrdc-card-body">
					<div class="jrdc-prose jrdc-prose--lead">
						{if $currentContext->getLocalizedData('description')}
							{$currentContext->getLocalizedData('description')}
						{else}
							Yayasan Ratu Dirgantara Cendekiawan (JRDC) merupakan lembaga yang berfokus pada penerbitan jurnal ilmiah, khususnya dalam bidang Ekonomi dan Bisnis. Melalui kegiatan penerbitan, JRDC berkomitmen mendukung pengembangan pendidikan, kemajuan ilmu pengetahuan, serta penyebarluasan hasil penelitian dan pemikiran akademik.
						{/if}
					</div>

					{* 4 Info Cards (2x2 Grid) *}
					<div class="jrdc-overview-grid">
						<a href="{url page="about"}" class="jrdc-info-card">
							<h3 class="jrdc-info-card__title">Fokus dan Ruang Lingkup</h3>
							<p class="jrdc-info-card__desc">Manajemen, akuntansi, keuangan, pemasaran, kewirausahaan, dan ekonomi pembangunan.</p>
						</a>
						<a href="{url page="about" op="editorialTeam"}" class="jrdc-info-card">
							<h3 class="jrdc-info-card__title">Dewan Redaksi</h3>
							<p class="jrdc-info-card__desc">Editor dan mitra bestari yang memandu proses telaah sejawat.</p>
						</a>
						<a href="{url page="about" op="submissions"}" class="jrdc-info-card">
							<h3 class="jrdc-info-card__title">Pedoman Penulis</h3>
							<p class="jrdc-info-card__desc">Persyaratan naskah dan cara menyiapkan berkas pengiriman.</p>
						</a>
						<a href="{url page="about" op="submissions" anchor="copyrightNotice"}" class="jrdc-info-card">
							<h3 class="jrdc-info-card__title">Etika Publikasi</h3>
							<p class="jrdc-info-card__desc">Standar etika publikasi yang berlaku bagi penulis, editor, dan penelaah.</p>
						</a>
					</div>
				</div>
			</section>

			{* Card B: Terbitan Jurnal Terbaru *}
			{if $issue}
				<section class="jrdc-card-section jrdc-issue" aria-labelledby="homepageIssueTitle">
					<a id="homepageIssue"></a>
					<div class="jrdc-card-header jrdc-issue__header">
						<div>
							<div class="jrdc-issue__eyebrow">
								<span class="jrdc-issue__eyebrow-label">
									Terbitan Jurnal Terbaru
								</span>
								<span class="jrdc-issue__status">
									Aktif
								</span>
							</div>
							<h2 id="homepageIssueTitle" class="jrdc-card-title">
								{$issue->getIssueIdentification()|strip_unsafe_html}
							</h2>
						</div>
						{if $issue->getDatePublished()}
							<div class="jrdc-issue__date">
								{$issue->getDatePublished()|date_format:$dateFormatLong}
							</div>
						{/if}
					</div>

					<div class="jrdc-card-body">
						<div class="jrdc-issue__toc">
							{include file="frontend/objects/issue_toc.tpl" heading="h3"}
						</div>

						<div class="jrdc-issue__footer">
							<span class="jrdc-issue__footer-text">Mencari publikasi edisi lampau atau tematik?</span>
							<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}" class="jrdc-button jrdc-button--secondary">
								Lihat Semua Edisi &amp; Arsip Lengkap
							</a>
						</div>
					</div>
				</section>
			{/if}

			{* Card C: Announcements (if enabled) *}
			{if $announcements && $numAnnouncementsHomepage}
				<section class="jrdc-card-section jrdc-announcements" aria-label="{translate|escape key="announcement.announcements"}">
					<div class="jrdc-card-header">
						<h2 class="jrdc-card-title">{translate key="announcement.announcements"}</h2>
					</div>
					<div class="jrdc-card-body">
						{include file="frontend/objects/announcements_list.tpl" numAnnouncements=$numAnnouncementsHomepage}
					</div>
				</section>
			{/if}

			{* Additional Content (if any) *}
			{if $additionalHomeContent}
				<section class="jrdc-card-section jrdc-additional">
					<div class="jrdc-card-body">
						<div class="jrdc-prose">
							{$additionalHomeContent}
						</div>
					</div>
				</section>
			{/if}

{* Note: pkp_structure_main, sidebar, and pkp_structure_content are closed by footer.tpl *}
{include file="frontend/components/footer.tpl"}
