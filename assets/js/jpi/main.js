window.jpi = window.jpi || {};
window.jpi.main = (function () {

    "use strict";

    var initListeners = function () {
            //Custom code to collapse mobile menu when user clicks off it.
            $(document).click(function (event) {
                if(!$(event.target).closest('.nav').length && !$(".nav__links-container").hasClass("closed") && $(".nav__links__toggle").css("display") !== "none") {
                    $(".nav__links__toggle").trigger("click");
                }
            });

            $(".nav__links__toggle").on("click", function () {
                var container = $(".nav__links-container");
                container.toggleClass("closed");
                container.toggleClass("opening");

                if (container[0].clientHeight) {
                    container[0].style.height = 0;
                } else {
                    var wrapper = $(".nav__links")[0];
                    container[0].style.height = wrapper.clientHeight + "px";
                }

                setTimeout(function() {
                    container.toggleClass("opening");
                }, 670);

                $(".nav").toggleClass("opened");
            });

            $(window).on("orientationchange resize", function () {

                if ($(window).width() > 768)
                {
                    var container = $(".nav__links-container");
                    container[0].style.height = "";
                    container.addClass("closed");
                    $(".nav").removeClass("opened");
                    container.removeClass("opening");
                }
            });

            $(window).on("scroll", function() {
                var nav_height = $(".nav").height();
                var scroll_pos = $(window).scrollTop() + nav_height;
                var win_height = $(window).height();

                if (scroll_pos >= win_height)
                    $(".nav").addClass("scrolled");
                else
                    $(".nav").removeClass("scrolled");
            });

            $(".js-scroll-to-content").on("click", function () {
                $('html, body').animate({
                    scrollTop: jQuery("section").offset().top - jQuery(".nav").height()
                }, 1000);
            });

            $(".js-expand-label").on("click", function () {
                var selected = $(this).children(".label__more_content"); // Get the new label that was clicked
                var selected_icon = $(this).children(".label__expand-icon");

                // Reset all other label to closed
                $(".label__more_content").not(selected).slideUp();
                $(".label__expand-icon").not(selected_icon).addClass("fa-plus").removeClass("fa-minus");

                //Toggle the clicked label
                selected_icon.toggleClass("fa-plus");
                selected_icon.toggleClass("fa-minus");
                selected.slideToggle();

                $(this).toggleClass("expanded-label");
                $('.js-expand-label').not(this).removeClass("expanded-label");
            });
        },

        init = function () {

            initListeners();

            var count = function (options) {
                var $this = $(this);
                options = $.extend({}, options || {}, $this.data('countToOptions') || {});
                $this.countTo(options);
            };

            $('.counter').waypoint(function () {
                $('.counter').each(count);
            }, {offset: '100%'});

            var secsElem = $(".js-seconds-on-site");
            if (secsElem.length > 0)
            {
                setTimeout(function () {
                    setInterval(function () {
                        var lastSec = secsElem.text();
                        lastSec = parseInt(lastSec);
                        secsElem.text(lastSec + 1);
                    }, 1000);
                }, 1000);
            }
        };

    $(document).on("ready", init);
}());