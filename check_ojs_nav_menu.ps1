$content = Get-Content temp_audit/ojs_about.html -Raw
if ($content -match '(?s)(<ul id="navigationPrimary".*?<\/ul>)') {
    Write-Host $matches[1]
}
