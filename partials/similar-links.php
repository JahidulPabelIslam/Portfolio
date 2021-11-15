<?php
$site = site();
$page = page();

$links = $this->links;

if (count($links)) {
    $linksContent = "";
    foreach ($links as $link) {
        $pageTitle = $link["title"];
        $buttonText = $link["text"] ?? $pageTitle;

        $url = $link["url"];
        $url = $site->makeURL($url);

        $colour = $link["colour"] ?? "brand";

        $linksContent .= <<<HTML
<div class="row__column">
    <a class="button button--$colour" href="$url" title="Link to $pageTitle Page">
        $buttonText
    </a>
</div>
HTML;
    }

    echo <<<HTML
<div class="row row--halves similar-links">
    <div class="container">
        $linksContent
    </div>
</div>
HTML;
}
