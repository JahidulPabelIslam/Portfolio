<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/../bootstrap.php");

$site = site();
$page = page();

$name = $site::NAME;
$job = $site::JOB;

$page->renderHtmlStart();
$page->renderHead([
    "title" => "$name's Site - $job",
    "description" => "Site of $name, a $job at Bognor Regis, West Sussex down in the South Coast of England.",
]);
$page->renderBodyStart();
$page->renderPageStart();
$page->renderNav();
$page->renderHeader([
    "title" => "<span class='tablet-show'>[ Ja-He-Dul Pa-Bel Is-Lam ]</span><span class='tablet-hide'>$name</span>",
    "description" => $job,
    "hideHeaderHr" => true,
    "showSocialLinksHeader" => true,
]);
$page->renderContentStart();

// Work out the time since I started to today
$yearsSinceStarted = getTimeDifference($site->getDateStarted(), new DateTime(), "%r%y");
?>

<div class="row row--alt home-hello">
    <div class="container">
        <h3 class="home-hello__hello"><span>Hello</span> there everyone!</h3>
        <div class="home-hello__images">
            <img class="home-hello__image" src="<?php echo $site::asset("/assets/images/jahidul-pabel-islam.jpg"); ?>" alt="<?php echo $name; ?> Graduating" />
            <img class="home-hello__image home-hello__image--logo" src="<?php echo $site::asset("/assets/images/logo-v2-2.png"); ?>" alt="<?php echo $name; ?>'s Logo" />
        </div>
        <p class="home-hello__welcome">Welcome and thanks for visiting me!</p>
        <p>
            Here you will be able to look at some of the <a class="link" href="<?php echo $site->makeURL("/portfolio/"); ?>">projects</a>
            I have worked on, <a class="link js-scroll-to" href="#about">learn about me</a> also be able to
            <a class="link js-scroll-to" href="#connect">connect with me</a>.
        </p>
    </div>
</div>

<div class="row about" id="about">
    <h3 class="row__heading">Quick Facts</h3>
    <div class="container">
        <div class="row__column">
            <?php
            // Work out my age by the time difference from DOB to today
            $age = getTimeDifference($site::DATE_OF_BIRTH, new DateTime(), "%r%y");
            ?>
            <p>I am <?php echo $age; ?> years old.</p>
        </div>
        <div class="row__column">
            <p>Currently working as a Web Developer @ D3R</p>
        </div>
        <div class="row__column">
            <p>I can speak English &amp; Bengali.</p>
        </div>
        <div class="row__column">
            <p>
                Based down in the South coast of England in a town called
                <a class="link link--brand" href="https://goo.gl/maps/KEJgpYCxm6x/" title="Link to map of Bognor Regis." target="_blank" rel="noopener noreferrer">
                    Bognor Regis
                </a>.
            </p>
        </div>
    </div>
</div>

<div class="row row--flush">
    <div class="map js-map"></div>
</div>

<section class="row row--alt">
    <h3 class="row__heading">My Journey So Far</h3>
    <div class="timeline">
        <div class="timeline__viewport">
            <div class="timeline__navs">
                <button type="button" class="timeline__nav button button--white" data-direction="previous">
                    <span class="screen-reader-text">Navigate to the previous slide/image.</span>
                    <?php renderFile("/assets/images/previous.svg"); ?>
                </button>
                <button type="button" class="timeline__nav button button--white" data-direction="next">
                    <span class="screen-reader-text">Navigate to the next slide/image.</span>
                    <?php renderFile("/assets/images/next.svg"); ?>
                </button>
            </div>

            <div class="timeline__items">
                <?php
                $timelineItems = [
                    [
                        "date" => "1996",
                        "icon" => "baby",
                        "text" => "Born",
                    ],
                    [
                        "date" => "1996 - 2007",
                        "icon" => "childhood",
                        "text" => "Life before getting introduced to technology",
                    ],
                    [
                        "date" => "2005 - 2009",
                        "icon" => "football",
                        "text" => "Playing competitive football with
                            <a class='link link--secondary' href='http://www.felphamcolts.com/' title='Link to Felpham Colts website.' target='_blank' rel='noopener noreferrer'>
                                Felpham Colts
                            </a>",
                    ],
                    [
                        "date" => 2010,
                        "icon" => "coding",
                        "text" => "Got introduced to coding",
                    ],
                    [
                        "date" => "2012 - 2014",
                        "icon" => "school",
                        "text" => "IT Student @
                            <a class='link link--secondary' href='https://chichester.ac.uk/' title='Link to Chichester College website.' target='_blank' rel='noopener noreferrer'>
                                Chichester College
                            </a>",
                    ],
                    [
                        "date" => "2014",
                        "icon" => "food",
                        "text" => "Working Part Time @
                            <a class='link link--secondary' href='https://www.kfc.co.uk/' title='Link to KFC website.' target='_blank' rel='noopener noreferrer'>
                                KFC
                            </a>
                             as a Team Member",
                    ],
                    [
                        "date" => "2014 - 2017",
                        "icon" => "film",
                        "text" => "Working Part Time @
                            <a class='link link--secondary' href='https://uk.webuy.com/' title='Link to CeX website.' target='_blank' rel='noopener noreferrer'>
                                CeX
                            </a>
                             as a Sales Assistant",
                    ],
                    [
                        "date" => "2014 - 2017",
                        "icon" => "school",
                        "text" => "Web Technologies Student @
                            <a class='link link--secondary' href='https://www.port.ac.uk/' title='Link to University of Portsmouth website.' target='_blank' rel='noopener noreferrer'>
                                University of Portsmouth
                            </a>",
                    ],
                    [
                        "date" => "2017 - 2019",
                        "icon" => "work",
                        "text" => "Software Developer @
                            <a class='link link--secondary' href='https://brightminded.com/' title='Link to BrightMinded website.' target='_blank' rel='noopener noreferrer'>
                                BrightMinded
                            </a>",
                    ],
                    [
                        "date" => "2019 - Present",
                        "icon" => "work",
                        "text" => "Web Developer @
                            <a class='link link--secondary' href='https://d3r.com/' title='Link to D3R website.' target='_blank' rel='noopener noreferrer'>
                                D3R
                            </a>",
                        "isActive" => true,
                    ],
                ];

                foreach ($timelineItems as $timelineItem) {
                    $isActive = $timelineItem["isActive"] ?? false;
                    $activeClass = $isActive ? "timeline__item--present" : "";

                    $iconName = $timelineItem["icon"];
                    $iconClass = !empty($iconName) ? "timeline__item--{$iconName}" : "";

                    echo <<<HTML
                        <div class="timeline__item $iconClass $activeClass">
                            <div>
                                <p class="timeline__date">{$timelineItem["date"]}</p>
                                <div class="timeline__content">
                                    <p>{$timelineItem["text"]}</p>
                                </div>
                            </div>
                        </div>
                        HTML;
                }
                ?>
            </div>
        </div>
    </div>
</section>

<div class="row row--thirds row--brand skills">
    <h2 class="row__heading">What I'm Best At</h2>
    <div class="container">
        <?php
        function renderSkills(string $title, array $skills) {
            ?>
            <div class="row__column skills__group">
                <h3 class="row__sub-heading skills__group-title"><?php echo $title; ?></h3>
                <ul class="skills__items">
                    <?php
                    foreach ($skills as $skill) {
                        $hasDescription = !empty($skill["description"]);
                        $expandClass = $hasDescription ? "skill--expandable" : "";

                        $toggleHTML = "";
                        $descriptionHTML = "";
                        if ($hasDescription) {
                            $toggleHTML = <<<HTML
                                &nbsp;<span class="skill__toggle fa fa-plus"></span>
                            HTML;
                            $descriptionHTML = <<<HTML
                                <div class="skill__description">
                                    {$skill["description"]}
                                </div>
                            HTML;
                        }

                        echo <<<HTML
                            <li class="skills__item skill $expandClass">
                                <p>{$skill["text"]}$toggleHTML</p>
                                $descriptionHTML
                            </li>
                        HTML;
                    }
                    ?>
                </ul>
            </div>
            <?php
        }

        $skills = [
            [
                "text" => "PHP",
                "description" => "<p>Worked with Libraries, Frameworks (Wordpress, Laravel &amp; Custom/Inhouse) &amp; APIs</p>",
            ],
            [
                "text" => "Python",
                "description" => "<p>flask &amp; graphics.py</p>",
            ],
            [
                "text" => "SQL",
                "description" => "<p>MySQL/MariaDB</p>",
            ],
        ];
        renderSkills("Backend", $skills);

        $skills = [
            [
                "text" => "JavaScript",
                "description" => "<p>Node.js (socket.io &amp; Express), jQuery &amp; AngularJS</p>",
            ],
            [
                "text" => "CSS",
                "description" => "<p>CSS3, SCSS &amp; Bootstrap3/4</p>",
            ],
            [
                "text" => "HTML",
                "description" => "<p>Have used template engines (Blade &amp; Twig)</p>",
            ],
        ];
        renderSkills("Frontend", $skills);

        $skills = [
            [
                "text" => "DVCS",
                "description" => "<p>Experience with Git (GitHub &amp; GitLab) &amp; Mercurial (Bitbucket)</p>",
            ],
            [
                "text" => "Team Player",
                "description" => "<p>Playing competitive football has meant being a good team player is instilled in me</p>",
            ],
            [
                "text" => "Communication",
                "description" => "<p>Written &amp; spoken communication skills from having worked in customer focused environments</p>",
            ],
        ];
        renderSkills("Other", $skills);
        ?>
    </div>
</div>

<section class="latest-projects row row--halves row--alt">
    <div class="container">
        <div class="row__column">
            <h3 class="row__heading">Latest Projects</h3>
            <p>These are the latest projects I have been working on.</p>
            <a class="latest-projects__view button button--brand" href="<?php echo $site->makeURL("/portfolio/"); ?>">
                View More
            </a>
        </div>
        <div class="row__column row__column--flush">
            <i class="latest-projects__loading fas fa-spinner fa-spin fa-3x"></i>

            <div class="slide-show latest-projects__slide-show" id="latest-projects">
                <div class="slide-show__viewport">
                    <div class="slide-show__slides"></div>
                    <div class="slide-show__bullets"></div>
                </div>
            </div>

            <p class="latest-projects__error"></p>
        </div>
    </div>
</section>

<section class="row row--tall row--secondary">
    <div class="container">
        <div class="stats js-counters">
            <?php
            $baseSpeed = 1000;

            $counts = load(ROOT . "/assets/counters.json", false)->getArray();

            $totalProjects = 120;
            if (isset($counts["total_projects"])) {
                $totalProjects = (floor($counts["total_projects"] / 10)) * 10;
            }

            $totalPullRequests = 1200;
            if (isset($counts["total_pull_requests"])) {
                $totalPullRequests = (floor($counts["total_pull_requests"] / 10)) * 10;
            }

            $totalCommits = 20000;
            if (isset($counts["total_commits"])) {
                $totalCommits = (floor($counts["total_commits"] / 10)) * 10;
            }

            $counterItems = [
                [
                    "text" => "Years experience",
                    "number" => $yearsSinceStarted,
                    "speed" => $baseSpeed,
                ],
                [
                    "text" => "Projects",
                    "number" => $totalProjects,
                    "speed" => $baseSpeed + 1000,
                ],
                [
                    "text" => "Pull Requests",
                    "number" => $totalPullRequests,
                    "speed" => $baseSpeed + 2000,
                ],
                [
                    "text" => "Commits",
                    "number" => $totalCommits,
                    "speed" => $baseSpeed + 3000,
                ],
            ];

            foreach ($counterItems as $counterItem) {
                ?>
                <div class="stats__item">
                    <p class="row__heading stats__heading js-counter" data-to="<?php echo $counterItem["number"]; ?>" data-speed="<?php echo $counterItem["speed"]; ?>">
                        <?php echo $counterItem["number"]; ?>
                    </p>
                    <p class="stats__text"><?php echo $counterItem["text"]; ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="contact-me row row--halves" id="connect">
    <div class="contact-me__column contact-me__column--header row__column">
        <div>
            <h2 class="row__heading">Connect With Me</h2>
            <a class="social-link social-link--linkedin" href="https://linkto.jahidulpabelislam.com/linkedin/" target="_blank" rel="noopener noreferrer">
                <img class="social-link__image" src="<?php echo $site::asset("/assets/images/logos/linkedin.svg"); ?>" alt="Find me on LinkedIn /<?php echo $site::SOCIAL_LINKEDIN; ?>" />
                &nbsp;
                <p class="social-link__text">/<?php echo $site::SOCIAL_LINKEDIN; ?></p>
            </a>
            <a class="social-link social-link--github" href="https://linkto.jahidulpabelislam.com/github/" target="_blank" rel="noopener noreferrer">
                <img class="social-link__image" src="<?php echo $site::asset("/assets/images/logos/github.svg"); ?>" alt="Find me on GitHub /<?php echo $site::SOCIAL_GITHUB; ?>" />
                &nbsp;
                <p class="social-link__text">/<?php echo $site::SOCIAL_GITHUB; ?></p>
            </a>
            <a class="social-link social-link--instagram" href="https://linkto.jahidulpabelislam.com/instagram/" target="_blank" rel="noopener noreferrer">
                <span class="social-link__image"><i></i></span>
                &nbsp;
                <p class="social-link__text">@<?php echo $site::SOCIAL_INSTAGRAM; ?></p>
            </a>
        </div>
    </div>
    <div class="contact-me__column contact-me__column--form row__column">
        <form class="contact-me__form contact-form" name="contact-form" method="POST" action="">
            <h2 class="row__heading">Contact Me</h2>
            <p class="contact-form__intro">Message me below or email me at <a class="link" href="jahidul@jahidulpabelislam.com">jahidul@jahidulpabelislam.com</a></p>
            <div class="field">
                <label for="email-input" class="field__label">Your Email Address</label>
                <input type="email" class="contact-form__email input" id="email-input" name="email-input" placeholder="joe@example.com" title="Email Address" required />
                <p class="contact-form__email-feedback field__error"></p>
            </div>

            <div class="field">
                <label for="subject-input" class="field__label">Subject <span>(optional)</span></label>
                <input type="text" class="contact-form_subject input" id="subject-input" name="subject-input" placeholder="Site Feedback" title="Subject of Message" />
            </div>

            <div class="field">
                <label for="message-input" class="field__label">Your Message</label>
                <textarea class="contact-form__message input" id="message-input" name="message-input" placeholder="Your site could do with more colour." title="The Message" rows="10" required></textarea>
                <p class="contact-form__message-feedback field__error"></p>
            </div>

            <p class="contact-form__feedback"></p>
            <button
                type="submit"
                class="button contact-form__submit"
                id="submit"
                data-loading-text="<i class='fas fa-spinner fa-spin'></i> Sending"
                data-initial-text="Send Email"
            >
                Send Email
            </button>
        </form>
    </div>
</section>

<?php
$page->addJSGlobal("googleMapStyles", null, load(ROOT. "/assets/map-styling.json", false)->getArray());
$page->addScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyDMU8a7-Fl8_ozCH4y_ZAL6n5fdy1sLeJg", "");

$page->addJSTemplate(
    "slide",
    <<<HTML
    <div class="slide-show__slide latest-project" id="slide-{{ id }}">
        <img class="slide-show__image latest-project__image" src="{{ images.0.url }}" alt="Screen shot of {{ name }} Project" />
        <div class="latest-project__info">
            <div class="latest-project__info-content">
                <h4 class="latest-project__title">{{ name }}</h4>
                <div class="latest-project__description">{{ short_description }}</div>
            </div>
        </div>
    </div>
    HTML
);

$page->addJSTemplate(
    "slide-bullet",
    <<<HTML
    <button type="button" class="slide-show__bullet" data-slide-id="#slide-{{ id }}">
    </button>
    HTML
);

$page->addJSGlobal("projects", "apiEndpoint", $site::removeTrailingSlash($site::getAPIEndpoint()));

$page->renderContentEnd();
$page->renderFooter();
$page->renderPageEnd();
$page->renderBodyEnd();
$page->renderCookieModal();
$page->renderHtmlEnd();
