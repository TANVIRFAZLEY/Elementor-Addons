jQuery(document).ready(function () {
    // Audio Player Visibility 
    (function ($) {
        $('audio').mediaelementplayer({
            pluginPath: "https://cdnjs.com/libraries/mediaelement/",
            shimScriptAccess: "always",
            // When using jQuery's `mediaelementplayer`, an `instance` argument
            // is available in the `success` callback
            success: function (mediaElement, originalNode, instance) {
                // do things
            }
        });
        $('.sermon a.on-off').on('click', function (i) {
            var active_audio = $(this).parents('.sermon').find('.on-off.current_audio .audio-wrap'),
                toggle = $(this).parents('.sermon-media'),
                dropDown = toggle.find('.audio-wrap');


            if (toggle.hasClass('current_audio')) {
                toggle.removeClass('current_audio');
            } else {
                toggle.addClass('current_audio');
            }


            i.preventDefault();
        });
    })(jQuery);
});
