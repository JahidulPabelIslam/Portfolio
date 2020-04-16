<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/src/bootstrap.php");

$site = Site::get();
$page = Page::get();

$error = basename(__DIR__);
$errorDesc = "Forbidden Page";
$headDesc = "Error: {$error} - Forbidden Page message on the portfolio of Jahidul Pabel Islam, a Full Stack Developer in Web &amp; Software based at Bognor Regis, West Sussex down by the South Coast of England.";

$pageData = [
    "headTitle" => "{$error} - {$errorDesc}",
    "headDesc" => $headDesc,
    "headerTitle" => $error,
    "headerDesc" => $errorDesc,
];
$page->addPageData($pageData);

$page->renderHTMLHead();
$page->renderNav();
$page->renderHeader();
?>

                <div class="row row--split">
                    <div class="container">
                        <div class="row__column">
                            <img class="row__column-image" src="<?php echoWithAssetVersion("/assets/images/no-entry.png"); ?>" alt="No entry sign" />
                        </div>
                        <div class="row__column">
                            <p>Access to the requested page is strictly forbidden.</p>
                        </div>
                    </div>
                </div>

<?php
$similarLinks = [
    [
        "title" => "Projects",
        "url" => "projects",
        "text" => "View My Work",
        "colour" => "purple",
    ],
    [
        "title" => "Contact",
        "url" => "contact",
        "text" => "Get in Touch",
        "colour" => "dark-blue",
    ],
];
$page->renderFooter($similarLinks);
