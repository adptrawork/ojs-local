{**
 * SangulineModern child theme - journal index override
 * High-fidelity layout matching Tailwind prototype (Hero navy, 4 info-cards, ToC)
 *
 * @uses $currentJournal Journal This journal
 * @uses $journalDescription string Journal description
 * @uses $homepageImage object Image to be displayed on the homepage
 * @uses $additionalHomeContent string Arbitrary input from HTML text editor
 * @uses $announcements array List of announcements
 * @uses $numAnnouncementsHomepage int Number of announcements to display
 * @uses $issue Issue Current issue
 *}
{include file="frontend/components/header.tpl" pageTitleTranslated=$currentJournal->getLocalizedName()}

<div class="page_index_journal jrdc-home">

	{call_hook name="Templates::Index::journal"}

	{* =========================================================================
	   1. HOMEPAGE HERO CARD (NAVY, OBSIDIAN DEPTH)
	   ========================================================================= *}
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
					Jurnal ilmiah akses terbuka yang menerbitkan penelitian dan kajian bidang ekonomi dan bisnis dengan telaah sejawat double-blind.
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
				<div style="width:200px; aspect-ratio:3/4; border-radius:12px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:1rem;">
					<span style="font-size:0.7rem; font-weight:700; color:#fbbf24; letter-spacing:0.1em; text-transform:uppercase;">COVER JURNAL</span>
					<span style="font-size:0.85rem; font-weight:600; color:#fff; margin-top:0.5rem;">JRDC</span>
				</div>
			{/if}
		</div>
	</section>

	{* =========================================================================
	   2. 4 OVERVIEW INFO CARDS ("TENTANG JURNAL")
	   ========================================================================= *}
	<section class="jrdc-overview-grid" aria-label="Informasi Jurnal">
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
	</section>

	{* =========================================================================
	   3. ANNOUNCEMENTS (IF ENABLED)
	   ========================================================================= *}
	{if $announcements && $numAnnouncementsHomepage}
		<section class="jrdc-section jrdc-announcements" aria-label="{translate|escape key="announcement.announcements"}">
			{include file="frontend/objects/announcements_list.tpl" numAnnouncements=$numAnnouncementsHomepage}
		</section>
	{/if}

	{* =========================================================================
	   4. LATEST ISSUE / TERBITAN TERBARU
	   ========================================================================= *}
	{if $issue}
		<section class="current_issue jrdc-section jrdc-issue" aria-labelledby="homepageIssueTitle" style="margin-top:2rem;">
			<a id="homepageIssue"></a>
			<header class="jrdc-section__header" style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:1.25rem;">
				<div>
					<span style="font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#c2410c; display:block; margin-bottom:0.25rem;">
						{translate key="journal.currentIssue"}
					</span>
					<h2 id="homepageIssueTitle" style="font-size:1.5rem; font-weight:800; color:#0f172a; margin:0; letter-spacing:-0.02em;">
						{$issue->getIssueIdentification()|strip_unsafe_html}
					</h2>
				</div>
				<a href="{url router=$smarty.const.ROUTE_PAGE page="issue" op="archive"}" style="font-size:0.8125rem; font-weight:600; color:#475569; text-decoration:none;">
					{translate key="journal.viewAllIssues"} &rarr;
				</a>
			</header>
			<div class="jrdc-issue__toc">
				{include file="frontend/objects/issue_toc.tpl" heading="h3"}
			</div>
		</section>
	{/if}

	{* =========================================================================
	   5. ADDITIONAL HOMEPAGE CONTENT
	   ========================================================================= *}
	{if $additionalHomeContent}
		<section class="additional_content jrdc-section jrdc-additional" style="background:#ffffff; border:1px solid #e2e8f0; border-radius:16px; padding:1.5rem; margin-top:2rem;">
			<div class="jrdc-prose">
				{$additionalHomeContent}
			</div>
		</section>
	{/if}

</div><!-- .page -->

{include file="frontend/components/footer.tpl"}
