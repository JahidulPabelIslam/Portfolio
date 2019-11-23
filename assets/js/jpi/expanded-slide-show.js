;/**
 * Used to expand a projects slide show
 */
window.jpi = window.jpi || {};
window.jpi.expandedSlideShow = (function(jQuery, jpi) {

    "use strict";

    var global = {
        body: null,
        expandedImageDivContainer: null,
        bulletsContainer: null,
        currentElem: null,
        totalElem: null,
        nav: null,
        slides: {},
        currentSlide: 0,
        timeout: null,
    };

    var fn = {

        displaySlide: function(expandedImage) {
            expandedImage.attr("src", global.slides[global.currentSlide].src);

            global.currentElem.text(global.currentSlide + 1);
            jQuery(".expanded-slide-show__bullet:eq(" + global.currentSlide + ")").addClass("active");
        },

        // Changes the current slide to new slide
        changeSlide: function(newSlideIndex) {
            if (newSlideIndex >= global.slides.length) {
                newSlideIndex = 0;
            }
            else if (newSlideIndex < 0) {
                newSlideIndex = global.slides.length - 1;
            }

            if (newSlideIndex === global.currentSlide) {
                return;
            }

            global.currentSlide = newSlideIndex;

            var expandedImageOld = jQuery(".expanded-slide-show__image.active");
            var expandedImageNew = jQuery(".expanded-slide-show__image:not(.active)");

            jQuery(".expanded-slide-show__bullet").removeClass("active");
            fn.displaySlide(expandedImageNew);

            expandedImageNew.addClass("active");
            expandedImageOld.removeClass("active");
        },
        next: function() {
            fn.changeSlide(global.currentSlide + 1);
        },
        previous: function() {
            fn.changeSlide(global.currentSlide - 1);
        },

        close: function() {
            global.expandedImageDivContainer.removeClass("active").addClass("hiding");

            global.timeout = setTimeout(function() {
                global.expandedImageDivContainer.removeClass("hiding");
                jpi.modal.close();
                global.timeout = null;
            }, 990);
        },

        // Sets up slide show when image is clicked on
        open: function(e) {
            // Get all slides in group
            var slidesGroup = jQuery(e.target).parents(".js-expandable-image-group");
            global.slides = slidesGroup.find(".js-expandable-image");

            var slidesCount = global.slides.length;
            global.totalElem.text(slidesCount);

            // Only show navigations if there are more than one slide show image to slide through
            if (slidesCount > 1) {
                var bulletsContainer = global.bulletsContainer;
                bulletsContainer.text("");

                // Loops through all slide shows images and set up a bullet navigation for each
                for (var i = 0; i < slidesCount; i++) {
                    // Checks if the current loop is the current image on slideShow
                    if (global.slides[i] === e.target) {
                        global.currentSlide = i;
                    }

                    // Set up bullet navigation for slide
                    jpi.helpers.renderNewElement("button", bulletsContainer[0], {
                        "class": "expanded-slide-show__bullet",
                        "data-slide-id": i,
                    });
                }

                global.nav.show();
            }
            else {
                global.nav.hide();
            }

            clearTimeout(global.timeout);

            fn.displaySlide(jQuery(".expanded-slide-show__image.active"));
            jpi.modal.open(global.expandedImageDivContainer);
            global.expandedImageDivContainer.addClass("active");
        },

        initListeners: function() {
            global.expandedImageDivContainer = jQuery(".expanded-slide-show");
            if (!global.expandedImageDivContainer.length) {
                return;
            }

            global.body = jQuery("body");
            global.bulletsContainer = jQuery(".expanded-slide-show__bullets");
            global.currentElem = jQuery(".expanded-slide-show__current-count");
            global.totalElem = jQuery(".expanded-slide-show__total-count");
            global.nav = jQuery(".expanded-slide-show__nav");

            global.body.on("click", ".expanded-slide-show__bullet", function(e) {
                var slideId = jQuery(e.target).attr("data-slide-id");
                slideId = jpi.helpers.getInt(slideId);
                fn.changeSlide(slideId);
            });

            global.body.on("click", ".js-expandable-image", fn.open);
            global.nav.on("click", function() {
                var direction = jQuery(this).attr("data-direction");
                fn[direction]();
            });
            jQuery(".expanded-slide-show__close").on("click", fn.close);
        },
    };

    jQuery(document).on("ready", fn.initListeners);

    return {};

})(jQuery, jpi);
