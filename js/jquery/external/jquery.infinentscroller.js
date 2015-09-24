(function ($) {

    $.fn.infinentScroll = function (settings) {

        // variables
        var isLoading = false;

        // setup default config
        var config = {
            'url': '?page={page}',
            'modifier': '{page}',
            'initialUpdate': 'true',
            'currentPage': '1',
            'setupLoadingPanel': true,
            'loadingPanelID': 'loadingPanel',
            'loadingImage': '',
            'loadingImageAlt': 'Loading more...',
            'loadingMessage': '<b>Loading more...</b>',
            'completeMessage': '<b>No more to show...</b>'
        };

        // merge user provided settings into config object
        if (settings) $.extend(config, settings);


        // check if an update is needed
        var isTimeToUpdate = function () {
            var container = $(element).offset().top + $(element).height() - $(window).height();
            var scroll = $(window).scrollTop();
            return scroll > container;
        };

        // listen to scroll event
        var scrollHandler = function (event) {

            if (!isTimeToUpdate() || isLoading) {
                return;
            }

            config.currentPage++;

            fetchContent();
        };

        var showLoading = function () {
            if (config.loadingPanelID != null) {
                $("#" + config.loadingPanelID).fadeIn();
            }
        }

        var showComplete = function () {
            if (config.loadingPanelID != null && config.completeMessage != null && config.completeMessage.length > 0) {
                $("#" + config.loadingPanelID).hide().empty().append(config.completeMessage).fadeIn().delay(2000).fadeOut();
            }
        }

        var hideLoading = function () {
            if (config.loadingPanelID != null) {
                $("#" + config.loadingPanelID).fadeOut();
            }
        }
        // update content
        var fetchContent = function () {

            isLoading = true;

            // unbind scroll event
            unregisterScrollEvent();

            // show loading message
            showLoading()

            // format url
            var url = config.url.replace(config.modifier, config.currentPage);

            // do request
            $.ajax({
                url: url,
                async: true,
                cache: false,
                success: function (data) { receiveContent(data); }
            });
        };

        // add content to element
        var receiveContent = function (data) {

            hideLoading();

            // if no content is received -> stop listing to the scroll event
            data = jQuery.trim(data);
            if (data.length == 0) {
                showComplete();
                return;
            }

            $(element).append(data);

            isLoading = false;

            // rebind scroll event again
            registerScrollEvent();

            // call more to fill the page
            if (isTimeToUpdate()) {
                config.currentPage++;
                fetchContent();
            }
        };

        var registerScrollEvent = function () {
            $(window).bind("scroll", scrollHandler);
        };
        var unregisterScrollEvent = function () {
            $(window).unbind("scroll", scrollHandler);
        };

        var setupLoadingPanel = function () {
            if (config.loadingPanelID == null) {
                return;
            }
            $(element).after('<div id="' + config.loadingPanelID + '"></div>');
            $("#" + config.loadingPanelID).hide().empty().css('text-align', 'center');

            if (config.loadingImage != null && config.loadingImage.length > 0) {
                var image = new Image();
                image.src = config.loadingImage;
                $("#" + config.loadingPanelID).append('<img src="' + image.src + '" alt="' + config.loadingImageAlt + '" /><br />');
            }

            if (config.loadingMessage != null && config.loadingMessage.length > 0) {
                $("#" + config.loadingPanelID).append(config.loadingMessage);
            }
        };

        // current limitiations -> only allow 1 element
        if (this.length != 1) {
            alert("Only 1 element can be registed");
        }

        var element = this[0];

        if (config.setupLoadingPanel) {
            setupLoadingPanel();
        }

        if (config.initialUpdate) {
            // perform an initial update
            fetchContent();
        }
        else {
            // register scroll events
            registerScrollEvent();
        }

        return this;
    };



})(jQuery);
