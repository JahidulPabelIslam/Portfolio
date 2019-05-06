;/*
 * Holds all the functions needed for the projects page
 * e.g. display projects
 */
window.jpi = window.jpi || {};
window.jpi.projects = (function(jQuery, jpi) {

    "use strict";

    // Grabs elements for later use
    var global = {
        url: new URL(window.location),
        titleStart: "Projects",
        titleEnd: " | Jahidul Pabel Islam - Full Stack Web & Software Developer",

        templateRegexes: {},
        navColourRegex: null,
    };

    var fn = {

        getCurrentPageNum: function() {
            var currentPageNum = jQuery(".js-projects-page").val();
            currentPageNum = jpi.helpers.getInt(currentPageNum, 1);

            return currentPageNum;
        },

        // Prints out a error message provided
        renderError: function(error) {
            jQuery(".feedback--error").text(error).show("fast");
            jQuery(".projects__loading-img, .pagination").text("").hide("fast");
            jpi.main.resetFooter();
        },

        getTemplateRegex: function(regex) {
            if (!global.templateRegexes[regex]) {
                global.templateRegexes[regex] = new RegExp("{{" + regex + "}}", "g");
            }

            return global.templateRegexes[regex];
        },

        addSkills: function(project, divID) {
            var skills = project.skills,
                skillsContainer = jQuery(divID + " .project__skills")[0],
                search = jQuery(".search-form__input").val().trim(),
                lowerCasedSearch = search.toLowerCase(),
                searches = lowerCasedSearch.split(" ");

            for (var i = 0; i < skills.length; i++) {
                var skill = skills[i].trim();

                if (skill !== "") {
                    var lowerCasedSkill = skill.toLowerCase();

                    var isInSearch = false;
                    for (var j = 0; j < searches.length; j++) {
                        if (searches[j].trim() !== "" && lowerCasedSkill.includes(searches[j])) {
                            isInSearch = true;
                            break;
                        }
                    }

                    var classes = "skill skill--" + project.colour;
                    classes += isInSearch ? " searched" : " js-searchable-skill";

                    jpi.helpers.createElement(skillsContainer, "a", {
                        innerHTML: skill,
                        class: classes,
                        href: "/projects/" + skill + "/",
                    });
                }
            }
        },

        addLinks: function(project, divID) {
            var linksContainer = jQuery(divID + " .project__links");

            if (!project.link && !project.download && !project.github) {
                linksContainer.remove();
                return;
            }

            linksContainer = linksContainer[0];

            if (project.link) {
                jpi.helpers.createElement(linksContainer, "a", {
                    href: project.link,
                    title: "Link to " + project.name + " Site",
                    target: "_blank",
                    innerHTML: "<i class='fa fa-external-link fa-2x'></i>",
                    class: "project__link project__link--" + project.colour,
                });
            }

            if (project.download) {
                jpi.helpers.createElement(linksContainer, "a", {
                    href: project.download,
                    title: "Link to Download " + project.name,
                    target: "_blank",
                    innerHTML: "<i class='fa fa-download fa-2x'></i>",
                    class: "project__link project__link--" + project.colour,
                });
            }

            if (project.github) {
                jpi.helpers.createElement(linksContainer, "a", {
                    href: project.github,
                    title: "Link to " + project.name + "  Code On GitHub",
                    target: "_blank",
                    innerHTML: "<i class='fa fa-github fa-2x'></i>",
                    class: "project__link project__link--" + project.colour,
                });
            }
        },

        addProjectImages: function(project, slideShowId) {
            var slidesContainer = jQuery(slideShowId + " .slide-show__slides-container"),
                slideShowBullets = jQuery(slideShowId + " .js-slide-show-bullets");

            // Loop through each row of data in rows
            for (var i = 0; i < project.images.length; i++) {
                if (project.images.hasOwnProperty(i)) {
                    var slideTemplate = jQuery("#tmpl-slide-template").text();
                    var bulletTemplate = jQuery("#tmpl-slide-bullet-template").text();

                    for (var field in project.images[i]) {
                        if (project.images[i].hasOwnProperty(field) && typeof field === "string") {
                            var regex = fn.getTemplateRegex(field);
                            var data = project.images[i][field];
                            slideTemplate = slideTemplate.replace(regex, data);
                            bulletTemplate = bulletTemplate.replace(regex, data);
                        }
                    }

                    var colourRegex = fn.getTemplateRegex("colour");
                    slideTemplate = slideTemplate.replace(colourRegex, project.colour);
                    bulletTemplate = bulletTemplate.replace(colourRegex, project.colour);

                    var idRegex = fn.getTemplateRegex("slide-show-id");
                    bulletTemplate = bulletTemplate.replace(idRegex, slideShowId);

                    slidesContainer.append(slideTemplate);
                    slideShowBullets.append(bulletTemplate);
                }
            }

            if (project.images.length) {
                jpi.slideShow.setUp(slideShowId);
            }
        },

        openProjectsExpandModal: function() {
            var projectDataString = jQuery(this).attr("data-project-data"),
                project = JSON.parse(projectDataString),
                modal = jQuery(".detailed-project");

            // Stops all the slide shows
            jpi.slideShow.loopThroughSlideShows(jpi.slideShow.stopSlideShow);

            modal.addClass("open").show();

            jQuery("body").css({overflow: "hidden"});

            modal.find(".project__links, .project__skills, .slide-show__slides-container, .js-slide-show-bullets").text("");

            modal.find(".project__title").text(project.name);

            var projectDateString = new Date(project.date).toLocaleDateString();
            modal.find(".project__date").text(projectDateString);

            fn.addSkills(project, ".detailed-project");

            modal.find(".project__description").html(project.long_description);

            fn.addLinks(project, ".detailed-project");

            fn.addProjectImages(project, "#detailed-project__slide-show");

            if (!global.navColourRegex) {
                global.navColourRegex = new RegExp("slide-show__nav--\\w*", "g");
            }

            modal.find(".slide-show__nav").each(function() {
                var slideShowNav = jQuery(this);
                var classList = slideShowNav.attr("class");
                classList = classList.replace(global.navColourRegex, "slide-show__nav--" + project.colour);
                slideShowNav.attr("class", classList);
            });
        },

        closeProjectsExpandModal: function(e) {
            var modal = jQuery(".detailed-project");
            if (!jQuery(e.target).closest(".modal__content").length && modal.hasClass("open")) {
                modal.removeClass("open").hide();

                jQuery("body").css({overflow: "auto"});

                var viewpoint = jQuery("#detailed-project__slide-show .slide-show__viewpoint")[0];
                viewpoint.removeEventListener("mousedown", jpi.slideShow.dragStart);
                viewpoint.removeEventListener("touchstart", jpi.slideShow.dragStart);

                // Reset slide show
                jQuery("#detailed-project__slide-show .slide-show__slides-container").css({left: "0px"});
                clearInterval(jpi.slideShow.slideShows["#detailed-project__slide-show"]);
                jQuery("#detailed-project__slide-show").removeClass("js-has-slide-show");

                jpi.slideShow.loopThroughSlideShows(jpi.slideShow.startSlideShow);
            }
        },

        // Renders a single project
        renderProject: function(project) {
            if (!document.getElementById("project--" + project.id)) {
                var template = jQuery("#tmpl-project-template").text();

                for (var field in project) {
                    if (project.hasOwnProperty(field) && typeof field === "string") {
                        var regex = fn.getTemplateRegex(field);

                        var data = project[field];
                        if (field === "date") {
                            data = new Date(data).toLocaleDateString();
                        }

                        template = template.replace(regex, data);
                    }
                }
                jQuery(".projects").append(template);

                fn.addSkills(project, "#project--" + project.id);
                fn.addLinks(project, "#project--" + project.id);
                fn.addProjectImages(project, "#slide-show--" + project.id);

                jQuery("#project--" + project.id + " .js-open-modal").attr(
                    "data-project-data",
                    JSON.stringify(project)
                );
            }

            jpi.main.resetFooter();
        },

        scrollToProjects: function() {
            var projectsPos = jQuery(".projects").offset().top,
                navHeight = jQuery(".nav").height();

            jQuery("html, body").animate(
                {
                    scrollTop: projectsPos - navHeight - 20,
                },
                2000
            );
        },

        // Adds pagination buttons/elements to the page
        addPagination: function(totalItems) {
            var paginationElem = jQuery(".pagination");

            if (jpi.helpers.getInt(totalItems) > 10) {
                var page = 1,
                    ul = paginationElem[0],
                    currentPage = fn.getCurrentPageNum();

                for (var i = 0; i < totalItems; i += 10, page++) {
                    var attributes = {class: "pagination__item"},
                        item = jpi.helpers.createElement(ul, "li", attributes),
                        url = fn.getNewURL(page);

                    url += global.url.search;

                    attributes = {
                        "innerHTML": page,
                        "class": "pagination__item-link js-pagination-item",
                        "data-page": page,
                        "href": url,
                    };
                    if (page === currentPage) {
                        attributes.class = "pagination__item-link active";
                    }
                    jpi.helpers.createElement(item, "a", attributes);
                }

                paginationElem.show();
            }
            else {
                paginationElem.hide();
            }
        },

        // Sets up events when projects were received
        gotProjects: function(response) {
            jQuery(".feedback--error, .projects__loading-img").text("").hide("fast");
            jQuery(".projects, .pagination").text("");

            // Send the data, the function to do if data is valid
            jpi.ajax.renderRowsOrFeedback(response, fn.renderProject, fn.renderError, "No Projects Found.");

            if (response && response.meta && response.meta.total_count) {
                fn.addPagination(response.meta.total_count);
            }

            jpi.main.resetFooter();
        },

        getProjects: function() {
            var page = fn.getCurrentPageNum(),
                search = jQuery(".search-form__input").val(),
                query = {
                    page: page,
                    search: search,
                };

            // Stops all the slide shows
            jpi.slideShow.loopThroughSlideShows(jpi.slideShow.stopSlideShow);

            // Send request to get projects for page and search
            jpi.ajax.sendRequest({
                method: "GET",
                url: jpi.config.jpiAPIEndpoint + "projects/",
                params: query,
                onSuccess: fn.gotProjects,
                onError: fn.renderError,
            });
        },

        getNewURL: function(page) {
            var url = "/projects/",
                searchValue = jQuery(".search-form__input").val();

            if (searchValue.trim() !== "") {
                url += searchValue + "/";
            }

            if (page > 1) {
                url += page + "/";
            }

            return url;
        },

        getNewTitle: function(page) {
            var title = global.titleStart,
                searchValue = jQuery(".search-form__input").val();

            if (searchValue.trim() !== "") {
                title += " with " + searchValue;
            }

            if (page > 1) {
                title += " - Page " + page;
            }

            title += global.titleEnd;

            return title;
        },

        storeLatestSearch: function() {
            var searchValue = jQuery(".search-form__input").val(),
                page = fn.getCurrentPageNum(),
                title = fn.getNewTitle(page),
                url = fn.getNewURL(page),
                state = {
                    search: searchValue,
                    page: page,
                };

            global.url.pathname = url;
            document.title = title;
            history.pushState(state, title, global.url.toString());

            if (typeof ga !== "undefined") {
                ga("set", "page", url);
                ga("send", "pageview");
            }
        },

        // Sends request when the user has done a search
        doSearch: function() {
            jQuery(".js-projects-page").val(1);

            fn.storeLatestSearch();

            fn.getProjects();
            return false;
        },

        // Set up page
        initListeners: function() {
            jQuery(".search-form").on("submit", fn.doSearch);

            jQuery("body").on("click", ".skill", function(e) {
                e.preventDefault();
            });

            jQuery("body").on("click", ".js-searchable-skill", function(e) {
                jQuery(".detailed-project").trigger("click");
                jQuery(".search-form__input").val(e.target.innerHTML);
                fn.scrollToProjects();
                fn.doSearch();
            });

            jQuery(".pagination--projects").on("click", ".js-pagination-item", function(e) {
                e.preventDefault();
                e.stopPropagation();

                fn.scrollToProjects();

                var page = jQuery(this).attr("data-page");
                if (!page) {
                    page = 1;
                }

                jQuery(".js-projects-page").val(page);

                fn.storeLatestSearch();
                fn.getProjects();
            });

            jQuery(".projects").on("click", ".js-open-modal", fn.openProjectsExpandModal);

            window.addEventListener("popstate", function(e) {
                var page = e.state.page;

                document.title = fn.getNewTitle(page);

                jQuery(".js-projects-page").val(page);
                jQuery(".search-form__input").val(e.state.search);

                fn.scrollToProjects();
                fn.getProjects();
            });

            // Close the modal
            jQuery(".detailed-project").on("click", fn.closeProjectsExpandModal);
        },

        init: function() {
            if (jQuery(".js-all-projects").length) {
                fn.initListeners();
                fn.getProjects();
            }
        },
    };

    jQuery(document).on("ready", fn.init);

    return {};

})(jQuery, jpi);
