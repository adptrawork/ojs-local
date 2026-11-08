{**
 * SangulineModern child theme - footer override (parent: Sanguline)
 * High-fidelity 4-column footer matching Tailwind prototype
 * Preserves OJS sidebar hook, footer hook, scripts, and layout structure.
 *}

	</div><!-- pkp_structure_main -->

	{* Sidebars *}
	{if empty($isFullWidth)}
		{capture assign="sidebarCode"}{call_hook name="Templates::Common::Sidebar"}{/capture}
		{if $sidebarCode}
			<div class="pkp_structure_sidebar left jrdc-sidebar" role="complementary" aria-label="{translate|escape key="common.navigation.sidebar"}">
				{* Sidebar Navigation Menu - appears at top of sidebar *}
				{capture assign="sidebarMenu"}{load_menu name="sidebar" id="navigationSidebar" ulClass="pkp_nav_list"}{/capture}
				{if $sidebarMenu|trim != ""}
					<div class="pkp_block block_sidebar_nav jrdc-sidebar__nav">
						<h2 class="pkp_block_title jrdc-sidebar__title">{translate key="plugins.themes.sanguline.sidebar.additionalMenu"}</h2>
						{$sidebarMenu}
					</div>
				{/if}
				{$sidebarCode}
			</div><!-- pkp_sidebar.left -->
		{/if}
	{/if}
</div><!-- pkp_structure_content -->

<footer class="pkp_structure_footer_wrapper jrdc-footer" role="contentinfo">
	<a id="pkp_content_footer"></a>

	<div class="pkp_structure_footer jrdc-footer__inner">

		{* 4-Column Modern Grid *}
		<div class="jrdc-footer-grid">
			{* Column 1: Brand & Publisher Blurb *}
			<div class="footer-col footer-col--brand">
				<div style="font-size:1.1rem; font-weight:800; color:#ffffff; margin-bottom:0.75rem;">
					{$currentJournal->getLocalizedName()|escape|default:"Jurnal Ekonomi dan Bisnis JRDC"}
				</div>
				<p style="font-size:0.8125rem; line-height:1.65; color:#94a3b8; margin-bottom:1rem;">
					Diterbitkan oleh <strong style="color:#e2e8f0;">Yayasan Ratu Dirgantara Cendekiawan (JRDC)</strong> sebagai wadah diseminasi riset ilmiah dan publikasi kajian bidang ekonomi &amp; bisnis.
				</p>
				<p style="font-size:0.75rem; color:#64748b; line-height:1.5;">
					Terbit berkala 2 kali setahun (April &amp; Oktober) &bull; Akses Terbuka Peer-Reviewed.
				</p>
			</div>

			{* Column 2: Untuk Penulis *}
			<div class="footer-col">
				<h3 class="footer-col__title">Untuk Penulis</h3>
				<ul>
					<li><a href="{url page="about" op="submissions"}">&rsaquo; Pedoman Penulis</a></li>
					<li><a href="{url page="about"}">&rsaquo; Fokus &amp; Ruang Lingkup</a></li>
					<li><a href="{url page="about" op="submissions" anchor="copyrightNotice"}">&rsaquo; Etika Publikasi</a></li>
					<li><a href="{url page="about" op="submissions"}">&rsaquo; Proses Peer Review</a></li>
					<li><a href="{url page="about" op="submissions"}">&rsaquo; Templat Naskah (.docx)</a></li>
					<li><a href="{url page="submission" op="wizard"}">&rsaquo; Kirim Naskah Online</a></li>
				</ul>
			</div>

			{* Column 3: Navigasi & Arsip *}
			<div class="footer-col">
				<h3 class="footer-col__title">Navigasi &amp; Arsip</h3>
				<ul>
					<li><a href="{url page="index"}">&rsaquo; Beranda</a></li>
					<li><a href="{url page="issue" op="current"}">&rsaquo; Edisi Terbaru</a></li>
					<li><a href="{url page="issue" op="archive"}">&rsaquo; Arsip Terbitan</a></li>
					<li><a href="{url page="about" op="editorialTeam"}">&rsaquo; Dewan Redaksi</a></li>
					<li><a href="{url page="announcement"}">&rsaquo; Pengumuman</a></li>
					<li><a href="{url page="about"}">&rsaquo; Indeksasi &amp; Abstrak</a></li>
				</ul>
			</div>

			{* Column 4: Kontak & Sekretariat *}
			<div class="footer-col">
				<h3 class="footer-col__title">Kontak &amp; Sekretariat</h3>
				<div style="font-size:0.8125rem; line-height:1.6; color:#94a3b8; display:flex; flex-direction:column; gap:0.5rem;">
					<div>
						<span style="display:block; font-size:0.65rem; font-weight:700; text-transform:uppercase; color:#64748b;">SUREL REDAKSI</span>
						{if $currentContext && $currentContext->getData('contactEmail')}
							<a href="mailto:{$currentContext->getData('contactEmail')|escape}" style="color:#cbd5e1; font-weight:500;">{$currentContext->getData('contactEmail')|escape}</a>
						{else}
							<a href="mailto:jurnal@jrdc.ac.id" style="color:#cbd5e1; font-weight:500;">jurnal@jrdc.ac.id</a>
						{/if}
					</div>
					<div>
						<span style="display:block; font-size:0.65rem; font-weight:700; text-transform:uppercase; color:#64748b;">ALAMAT KANTOR</span>
						<span style="color:#cbd5e1;">
							{if $currentContext && $currentContext->getData('mailingAddress')}
								{$currentContext->getData('mailingAddress')|escape}
							{else}
								Gedung Ratu Dirgantara Cendekiawan, Jakarta, Indonesia
							{/if}
						</span>
					</div>
					<div>
						<span style="display:block; font-size:0.65rem; font-weight:700; text-transform:uppercase; color:#64748b;">JAM LAYANAN</span>
						<span style="color:#cbd5e1;">Senin &ndash; Jumat: 08.00 &ndash; 16.00 WIB</span>
					</div>
				</div>
			</div>
		</div>

		{if $pageFooter}
			<div class="pkp_footer_content jrdc-footer__content" style="border-top:1px solid #1e293b; padding-top:1.5rem; margin-bottom:1.5rem;">
				{$pageFooter}
			</div>
		{/if}

		{* Bottom bar: Copyright & Legal links *}
		<div class="jrdc-footer-bottom">
			<div>
				&copy; 2026 Yayasan Ratu Dirgantara Cendekiawan (JRDC) &mdash; Powered by Open Journal Systems
			</div>
			<div style="display:flex; gap:1rem;">
				<a href="{url page="about" op="submissions" anchor="privacyStatement"}">Kebijakan Privasi</a>
				<span>&bull;</span>
				<a href="{url page="about" op="submissions" anchor="copyrightNotice"}">Pemberitahuan Hak Cipta</a>
				<span>&bull;</span>
				<a href="{url page="about"}">Pernyataan Akses Terbuka</a>
			</div>
		</div>

		{* Sanguline Theme Copyright - Protected *}
		<div class="sanguline_theme_credit jrdc-footer__credit" data-sanguline="protected">
			<span class="theme_credit_text">Sanguline Theme by</span>
			<a href="https://sanguilmu.com/" target="_blank" rel="noopener noreferrer" class="theme_credit_link">Sangu Ilmu</a>
		</div>
	</div>
</footer><!-- pkp_structure_footer_wrapper -->

</div><!-- pkp_structure_page -->

{load_script context="frontend"}

{call_hook name="Templates::Common::Footer::PageFooter"}
</body>
</html>
