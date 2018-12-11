<?php

$pageId = "privacy-policy";

// Title of page to use
$pageTitle = $headerTitle = "Privacy Policy";

// The description to use for page
$description = "Privacy policy on the portfolio of Jahidul Pabel Islam, a Full Stack Web & Software Developer in Bognor Regis, West Sussex Down by the South Coast of England.";

$headerDesc = "";

// The keywords to use for pages
$keywords = "";

$navTint = "dark";

//include the header for page
include $_SERVER['DOCUMENT_ROOT'] . '/partials/header.php';
?>
	
	<!-- Start Dynamic content for page -->
	<div class="article">
		<div class="container">
			<h2 class="article__header">Contact Form</h2>
			<p>The following applies to the contact form and your data submitted within the form:</p>
			<ul>
				<li>your data, WILL ONLY be kept in my email server</li>
				<li>your data, WILL NOT be given to any third party companies</li>
				<li>your email WILL BE deleted after the discussion is finished or viewed</li>
			</ul>
		</div>
	</div>

	<div class="article">
		<div class="container">
			<h2 class="article__header">Cookies</h2>
			<p>This website uses cookies to collect information. Cookies are files stored on your device when you come on a website which is using them. The data stored can be a whole range of data, user login session data to shopping basket.</p>
			<p>Cookies on this site is used to allow tracking user behaviour with the site, to use in analytics and improving the site.</p>
			<p>By viewing the site, it will be assumed you agree to use cookies within this site.</p>
			
			<h3 class="article__sub-heading">Cookies used</h3>
			<p><strong>Google Analytics:</strong></p>
			<table class="table">
				<tr class="table__row table__row--header">
					<th class="table__col table__col--header">Cookie Name</th>
					<th class="table__col table__col--header">Expiration Time</th>
					<th class="table__col table__col--header">Description</th>
				</tr>
				<tr  class="table__row">
					<td class="table__col">_ga</td>
					<td class="table__col">2 years</td>
					<td class="table__col">Used to distinguish unique users.</td>
				</tr>
				<tr class="table__row">
					<td class="table__col">_gat</td>
					<td class="table__col">10 minutes</td>
					<td class="table__col">Used to throttle request rate.</td>
				</tr>
			</table>
			<p>The cookies used and the Google Analytics data stored will be anonymized and cannot be used to identify individual people.</p>
			<p>To stop cookies you will need to go to your browser settings, for more information on this as well as general/more information on cookies can be found at <a href="http://www.allaboutcookies.org/" class="link-styled">allaboutcookies</a></p>
		</div>
	</div>
	<!-- End dynamic content -->

<?php
//include the footer for page
include $_SERVER['DOCUMENT_ROOT'] . '/partials/footer.php';
?>