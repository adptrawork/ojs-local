$files = Get-ChildItem temp_audit/proto_*.html
foreach ($f in $files) {
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    # Find active nav items in prototype
    $activeMatches = [regex]::Matches($content, '<a[^>]*class="([^"]*)"[^>]*>(.*?)<\/a>')
    foreach ($m in $activeMatches) {
        $cls = $m.Groups[1].Value
        $text = $m.Groups[2].Value.Trim() -replace '<[^>]+>', ''
        if ($cls -match 'active|text-amber|border-b-2|border-primary|bg-primary|text-blue-600') {
            if ($text.Length -lt 40 -and $text.Length -gt 0) {
                Write-Host "   Active/highlighted: '$text' -> class: '$cls'"
            }
        }
    }
}
