$files = Get-ChildItem temp_audit/ojs_*.html
foreach ($f in $files) {
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    
    # Extract Nav HTML
    if ($content -match '(?s)(<nav class="pkp_site_nav_menu jrdc-nav".*?<\/nav>)') {
        $nav = $matches[1]
        # Show all <a> inside nav
        $aMatches = [regex]::Matches($nav, '<a\s+[^>]*>')
        foreach ($a in $aMatches) {
            Write-Host "   $($a.Value)"
        }
    }
}
