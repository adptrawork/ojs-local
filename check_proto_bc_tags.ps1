$files = Get-ChildItem temp_audit/proto_*.html
foreach ($f in $files) {
    if ($f.Name -match 'home') { continue }
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    $matches = [regex]::Matches($content, '<nav[^>]*aria-label="[bB]readcrumb"[^>]*>.*?</nav>', [System.Text.RegularExpressions.RegexOptions]::Singleline)
    if ($matches.Count -gt 0) {
        Write-Host $matches[0].Value
    } else {
        # Check if breadcrumb exists in another tag
        $m2 = [regex]::Matches($content, '(?i)<ol class="[^"]*flex[^"]*items-center[^"]*".*?<\/ol>', [System.Text.RegularExpressions.RegexOptions]::Singleline)
        if ($m2.Count -gt 0) {
            Write-Host $m2[0].Value
        } else {
            Write-Host "No breadcrumb found in prototype!"
        }
    }
}
