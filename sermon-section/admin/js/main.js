var frame;
var framepdf;
;(function ($) {
    $(document).ready(function () {

        var audio_url = $("#sermon_audio_url").val();
        if (audio_url) {
            //$("#pdf-container").html(`<img src='${pdf_url}' />`);
            $("#audio-container").html(`<input class="widefat" type="url" name="sermon_audio_link" id="sermon_audio_link" value="${audio_url}"/>`);
        }
        //pdf value
        var pdf_url = $("#sermon_pdf_url").val();
        if (pdf_url) {
            //$("#pdf-container").html(`<img src='${pdf_url}' />`);
            $("#pdf-container").html(`<input class="widefat" type="url" name="sermon_pdf_link" id="sermon_pdf_link" value="${pdf_url}"/>`);
        }
//audio button
        $("#upload_audio").on("click", function () {

            if (frame) {
                frame.open();
                return false;
            }

            frame = wp.media({
                title: "Select Audio",
                button: {
                    text: "Insert Audio File"
                },
                multiple: false,
                library: {
                    type: [ 'audio']
                },
                //type: "application/pdf"
            });

            frame.on('select', function () {
                var attachment = frame.state().get('selection').first().toJSON();
                console.log(attachment);
                $("#sermon_audio_id").val(attachment.id);
                $("#sermon_audio_url").val(attachment.url);
                $("#audio-container").html(`<input class="widefat" type="url" name="sermon_audio_link" id="sermon_audio_link" value="${attachment.url}"/>`);
            });


            frame.open();
            return false;
        });
//PDF button
        $("#upload_pdf").on("click", function () {

            if (framepdf) {
                framepdf.open();
                return false;
            }

            framepdf = wp.media({
                title: "Select PDF",
                button: {
                    text: "Insert PDF"
                },
                multiple: false,
                library: {
                    type: [ 'application/pdf']
                },
                //type: "application/pdf"
            });

            framepdf.on('select', function () {
                var attachment = framepdf.state().get('selection').first().toJSON();
                console.log(attachment);
                $("#sermon_pdf_id").val(attachment.id);
                $("#sermon_pdf_url").val(attachment.url);
                //$("#pdf-container").html(`<img src='${attachment.sizes.thumbnail.url}' />`);
                $("#pdf-container").html(`<input class="widefat" type="url" name="sermon_pdf_link" id="sermon_pdf_link" value="${attachment.url}"/>`);
            });


            framepdf.open();
            return false;
        });
    });
})(jQuery);