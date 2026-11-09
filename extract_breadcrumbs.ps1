$files = Get-ChildItem temp_audit/ojs_*.html
foreach ($f in $files) {
    if ($f.Name -match 'home') { continue }
    Write-Host "`n================ $($f.Name) ================"
    $content = Get-Content $f.FullName -Raw
    $lines = $content -split "`n"
    for ($i = 0; $i -lt $lines.Length; $i++) {
        if ($lines[$i] -match 'breadcrumb') {
            # print surrounding 10 lines
            $start = [Math]::Max(0, $i - 2)
            $end = [Math]::Min($lines.Length - 1, $i + 15)
            for ($j = $start; $j -le $end; $j++) {
                Write-Host $lines[$j]
            }
            break
        }
    }
}
