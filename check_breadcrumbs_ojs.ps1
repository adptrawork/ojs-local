$files = Get-ChildItem temp_audit/ojs_*.html
foreach ($f in $files) {
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    if ($content -match '(?si)(<nav[^>]*aria-label="breadcrumbs"[^>]*>.*?</nav>|<div[^>]*class="[^"]*breadcrumb[^"]*"[^>]*>.*?</div>|<ol[^>]*class="[^"]*breadcrumb[^"]*"[^>]*>.*?</ol>)') {
        Write-Host "Found Breadcrumb in OJS:"
        Write-Host $matches[1]
    } else {
        # Check any mentions of breadcrumb
        if ($content -match '(?i)breadcrumb') {
            Write-Host "Found word breadcrumb somewhere"
        } else {
            Write-Host "NO Breadcrumb found in OJS!"
        }
    }
}
