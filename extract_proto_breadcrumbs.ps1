$files = Get-ChildItem temp_audit/proto_*.html
foreach ($f in $files) {
    if ($f.Name -match 'home') { continue }
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    $lines = $content -split "`n"
    $found = $false
    for ($i = 0; $i -lt $lines.Length; $i++) {
        if ($lines[$i] -match 'breadcrumb|Beranda') {
            # print surrounding 5 lines
            $start = [Math]::Max(0, $i - 1)
            $end = [Math]::Min($lines.Length - 1, $i + 10)
            for ($j = $start; $j -le $end; $j++) {
                Write-Host $lines[$j]
            }
            $found = $true
            break
        }
    }
    if (-not $found) { Write-Host "Not found" }
}
