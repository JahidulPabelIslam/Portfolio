<?php
include $_SERVER["DOCUMENT_ROOT"] . "/site.php";

$headTitle = $headerTitle = "403";

$headDesc = "Error: 403 - Forbidden Page message on the portfolio of Jahidul Pabel Islam, a Full Stack Web & Software Developer in Bognor Regis, West Sussex Down by the South Coast of England.";
Site::echoHTMLHead($headTitle, $headDesc);

$headerDesc = "Forbidden Page";
Site::echoHeader($headerTitle, $headerDesc);
?>

				<div class="article article--halved">
					<div class="container">
						<div class="article__half">
							<img src="/assets/images/no-entry.png?v=2" alt="No entry sign" class="error__img">
						</div>
						<div class="article__half">
							<p>The access to the requested page is strictly forbidden.</p>
						</div>
					</div>
				</div>

<?php
Site::echoFooter();
?>