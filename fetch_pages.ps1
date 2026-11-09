$pages = @(
    @{name='home'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc'; proto='https://adptrawork.github.io/build-OJS/'},
    @{name='about'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc/about'; proto='https://adptrawork.github.io/build-OJS/about.html'},
    @{name='editorial'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc/about/editorialTeam'; proto='https://adptrawork.github.io/build-OJS/editorial-team.html'},
    @{name='archive'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc/issue/archive'; proto='https://adptrawork.github.io/build-OJS/archive.html'},
    @{name='issue'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc/issue/view/2'; proto='https://adptrawork.github.io/build-OJS/issue.html'},
    @{name='article'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc/article/view/6'; proto='https://adptrawork.github.io/build-OJS/article.html'},
    @{name='search'; ojs='http://ojs-3.3.0-24.test/index.php/jrdc/search'; proto='https://adptrawork.github.io/build-OJS/search.html'}
)

if (-not (Test-Path 'temp_audit')) {
    New-Item -ItemType Directory -Path 'temp_audit' | Out-Null
}

foreach ($p in $pages) {
    Write-Host "Fetching $($p.name)..."
    curl.exe -s -L $p.ojs -o "temp_audit/ojs_$($p.name).html"
    curl.exe -s -L $p.proto -o "temp_audit/proto_$($p.name).html"
}

Get-ChildItem temp_audit | Select-Object Name, Length
