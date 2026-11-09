$content = Get-Content temp_audit/proto_editorial.html -Raw
if ($content -match '(?s)(<nav.*?</nav>)') {
    Write-Host $matches[1]
}
