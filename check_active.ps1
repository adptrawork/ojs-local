$files = Get-ChildItem temp_audit/ojs_*.html
foreach ($f in $files) {
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    if ($content -match '(?s)(<nav class="pkp_site_nav_menu jrdc-nav".*?<\/nav>)') {
        $nav = $matches[1]
        # Match any li or a with class containing active, current, etc
        $matchesWithClasses = [regex]::Matches($nav, '<(li|a)[^>]*class="([^"]*)"[^>]*>')
        foreach ($m in $matchesWithClasses) {
            $tag = $m.Groups[1].Value
            $cls = $m.Groups[2].Value
            if ($cls -match 'active|current|selected') {
                Write-Host "   Tag <$tag> with class: '$cls'"
            }
        }
    }
}
