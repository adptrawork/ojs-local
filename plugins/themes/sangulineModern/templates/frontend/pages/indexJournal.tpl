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
					<div style="width:210px; aspect-ratio:3/4; border-radius:14px; background:rgba(255,255,255,0.06); border:1.5px solid rgba(255,255,255,0.18); display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:1.5rem; box-shadow:0 15px 30px rgba(0,0,0,0.3);">
						<span style="font-size:0.65rem; font-weight:700; color:#fbbf24; letter-spacing:0.12em; text-transform:uppercase;">COVER JURNAL</span>
						<span style="font-size:0.95rem; font-weight:700; color:#fff; margin-top:0.5rem; line-height:1.2;">JRDC</span>
						<span style="width:40px; height:2px; background:#c2410c; margin-top:0.75rem; border-radius:2px;"></span>
					</div>
				{/if}
			</div>
		</section>
	</div>

	{* =========================================================================
	   2. 2-COLUMN STRUCTURE (MAIN 8 COLS + SIDEBAR 4 COLS)
	   ========================================================================= *}
	{capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
	{assign var="hasSidebar" value=0}
	{if $sidebarCode && empty($isFullWidth)}
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
					<div class="jrdc-prose" style="font-size:0.875rem; color:#475569; line-height:1.7; margin-bottom:1.5rem;">
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
				<section class="jrdc-card-section" aria-labelledby="homepageIssueTitle" style="margin-top:2rem;">
					<a id="homepageIssue"></a>
					<div class="jrdc-card-header" style="display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:0.75rem;">
						<div>
							<div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem;">
								<span style="font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#c2410c;">
									Terbitan Jurnal Terbaru
								</span>
								<span style="display:inline-flex; align-items:center; padding:0.1rem 0.5rem; border-radius:4px; font-size:0.65rem; font-weight:600; background:rgba(16,185,129,0.1); color:#059669; border:1px solid rgba(16,185,129,0.2);">
									Aktif
								</span>
							</div>
							<h2 id="homepageIssueTitle" class="jrdc-card-title" style="margin:0;">
								{$issue->getIssueIdentification()|strip_unsafe_html}
							</h2>
						</div>
						{if $issue->getDatePublished()}
							<div style="font-size:0.8125rem; font-weight:500; color:#64748b;">
								{$issue->getDatePublished()|date_format:$dateFormatLong}
							</div>
						{/if}
					</div>

					<div class="jrdc-card-body" style="padding-top:1.25rem;">
						<div class="jrdc-issue__toc">
							{include file="frontend/objects/issue_toc.tpl" heading="h3"}
						</div>

						<div style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.75rem;">
							<span style="font-size:0.8125rem; color:#64748b;">Mencari publikasi edisi lampau atau tematik?</span>
							<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}" class="jrdc-button jrdc-button--secondary" style="font-size:0.75rem; font-weight:600; padding:0.45rem 1rem; border-radius:8px;">
								Lihat Semua Edisi &amp; Arsip Lengkap &rarr;
							</a>
						</div>
					</div>
				</section>
			{/if}

			{* Card C: Announcements (if enabled) *}
			{if $announcements && $numAnnouncementsHomepage}
				<section class="jrdc-card-section jrdc-announcements" aria-label="{translate|escape key="announcement.announcements"}" style="margin-top:2rem;">
					<div class="jrdc-card-header">
						<h2 class="jrdc-card-title">{translate key="announcement.announcements"}</h2>
					</div>
					<div class="jrdc-card-body" style="padding-top:1.25rem;">
						{include file="frontend/objects/announcements_list.tpl" numAnnouncements=$numAnnouncementsHomepage}
					</div>
				</section>
			{/if}

			{* Additional Content (if any) *}
			{if $additionalHomeContent}
				<section class="jrdc-card-section jrdc-additional" style="margin-top:2rem;">
					<div class="jrdc-card-body">
						<div class="jrdc-prose">
							{$additionalHomeContent}
						</div>
					</div>
				</section>
			{/if}

{* Note: pkp_structure_main, sidebar, and pkp_structure_content are closed by footer.tpl *}
{include file="frontend/components/footer.tpl"}
