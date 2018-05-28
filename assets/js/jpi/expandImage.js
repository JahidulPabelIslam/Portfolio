//Used to expand a projects slide show
window.jpi = window.jpi || {};
window.jpi.expandImage = (function (jQuery) {

    "use strict";

    //initiates variables
    var currentSlide = 0,
        slides = {},
        expandedImageDivContainer = jQuery(".expanded-image-slide-show"),

        //changes current slide to new slide
        changeElement = function(nextSlideId) {
            jQuery(".expanded-image-slide-show__bullets .slide-show__bullet:eq(" + currentSlide + ")").removeClass("active");
            currentSlide = nextSlideId;

            if (currentSlide >= slides.length) currentSlide = 0;
            else  if (currentSlide < 0) currentSlide = slides.length - 1;

            var expandedImage = jQuery(".expanded-image.current"),
                expandedImage2 = jQuery(".expanded-image:not(.current)");

            expandedImage2.attr("src", slides[currentSlide].src);
            expandedImage.removeClass("current");
            expandedImage2.addClass("current");
            jQuery(".expanded-image-counter__current").text((currentSlide + 1).toString());

            jQuery(".expanded-image-slide-show__bullets .slide-show__bullet:eq(" + currentSlide + ")").addClass("active");
        },

        //sends event to change to next slide
        next = function() {
            changeElement(currentSlide+1);
        },

        //sends event to change to previous slide
        previous = function() {
            changeElement(currentSlide-1);
        },

        //closes expanded image div
        close = function() {

            expandedImageDivContainer.removeClass("active").addClass("hiding");

            setTimeout(function() {
                document.body.style.overflow = "auto";
                expandedImageDivContainer.removeClass("hiding");
            }, 990);

            jpi.slideShow.loopThroughSlideShows(jpi.slideShow.startSlideShow);

            jQuery(".expanded-image-slide-show__bullets").text("");
        },

        //sets up slide show when image is clicked on
        expandImageSetUp = function(e) {
            var expandedImage = jQuery(".expanded-image.current");

            //stops all the slide shows
            jpi.slideShow.loopThroughSlideShows(jpi.slideShow.stopSlideShow);

            expandedImageDivContainer.addClass("active");

            //display the expanded image div
            expandedImage.attr("src", e.target.src).show();

            document.body.style.overflow = "hidden";

            //get all slides in slide show
            var slideShowId = jQuery(e.target).data("slideShowId");
            slides = jQuery(slideShowId+" .slide");

            //loops through all slide shows images and set up a bullet navigation for each
            for (var i = 0; i < slides.length; i++) {

                //checks if the current loop is the current image on slideShow
                if (slides[i] === e.target) {
                    currentSlide = i;
                }

                //set up bullet navigation for slide
                jpi.helpers.createElement(jQuery(".expanded-image-slide-show__bullets")[0], "label", {class: "slide-show__bullet expanded-image-slide-show__bullet js-expanded-image-bullet", "data-slide-id": i});
            }

            //display the current slide number and slide show length
            jQuery(".expanded-image-counter__current").text((currentSlide + 1).toString());
            jQuery(".expanded-image-counter__total").text(slides.length);

            //check there are more than one slide show image to slide through
            if (slides.length > 1) {
                //set up next and previous buttons
                jQuery(".expanded-image-slide-show__nav-previous, .expanded-image-slide-show__nav-next, .expanded-image-slide-show__bullets").show();
            }
            //only one slide show image so stop next and previous buttons
            else {
                jQuery(".expanded-image-slide-show__nav-previous, .expanded-image-slide-show__nav-next, .expanded-image-slide-show__bullets").hide();
            }

            //makes current slides bullet navigation display as active
            jQuery(".expanded-image-slide-show__bullets .slide-show__bullet:eq(" + currentSlide + ")").addClass("active");

            jQuery(".modal--detailed-project").removeClass("open").hide();

            setTimeout(function() {
                //display the expanded image div
                expandedImage.attr("src", "");
                expandedImage.attr("src", e.target.src);
            }, 1000);
        },

        initListeners = function () {
            jQuery("body").on("click", ".js-expandable-image", expandImageSetUp);

            jQuery("body").on("click", ".js-expanded-image-bullet", function(e) {
                changeElement(parseInt(jQuery(e.target).data("slideId")));
            });

            //add listener for when the user wants to close expanded image
            jQuery(".expanded-image-slide-show__close").click(close);

            jQuery(".expanded-image-slide-show__nav-next").click(next);
            jQuery(".expanded-image-slide-show__nav-previous").click(previous);
        };

    jQuery(document).on("ready", initListeners);

}(jQuery));