$content = Get-Content temp_audit/proto_about.html -Raw
if ($content -match '(?s)(<header.*?</header>)') {
    Write-Host $matches[1]
}
