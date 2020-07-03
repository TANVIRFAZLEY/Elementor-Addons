<?php
class SermonMetabox {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'sermon_add_metabox' ) );
        add_action( 'save_post', array( $this, 'sermon_save_media' ) );
    }

    private function is_secured( $nonce_field, $action, $post_id ) {
        $nonce = isset( $_POST[$nonce_field] ) ? $_POST[$nonce_field] : '';

        if ( $nonce == '' ) {
            return false;
        }
        if ( !wp_verify_nonce( $nonce, $action ) ) {
            return false;
        }

        if ( !current_user_can( 'edit_post', $post_id ) ) {
            return false;
        }

        if ( wp_is_post_autosave( $post_id ) ) {
            return false;
        }

        if ( wp_is_post_revision( $post_id ) ) {
            return false;
        }

        return true;

    }

    function sermon_save_media( $post_id ) {

        if ( !$this->is_secured( 'sermon_media_field', 'sermon_media', $post_id ) ) {
            return $post_id;
        }

        $video = isset( $_POST['sermon_video'] ) ? $_POST['sermon_video'] : '';
        $audio_id = isset( $_POST['sermon_audio_id'] ) ? $_POST['sermon_audio_id'] : '';
        $audio_url = isset( $_POST['sermon_audio_url'] ) ? $_POST['sermon_audio_url'] : '';
        $pdf_id = isset( $_POST['sermon_pdf_id'] ) ? $_POST['sermon_pdf_id'] : '';
        $pdf_url = isset( $_POST['sermon_pdf_url'] ) ? $_POST['sermon_pdf_url'] : '';

        if ( $video == '' ) {
            return $post_id;
        }

        $video = esc_url( $video );

        update_post_meta( $post_id, 'sermon_video', $video );
        update_post_meta( $post_id, 'sermon_audio_id', $audio_id );
        update_post_meta( $post_id, 'sermon_audio_url', $audio_url );
        update_post_meta( $post_id, 'sermon_pdf_id', $pdf_id );
        update_post_meta( $post_id, 'sermon_pdf_url', $pdf_url );
    }

    function sermon_add_metabox() {
        add_meta_box(
            'sermon_media_metabox',
            __( 'Sermon Media Info', 'sermon-section' ),
            array( $this, 'sermon_display_post_media' ),
            array( 'sermon' )
        );
    }

    function sermon_display_post_media( $post ) {
        $video = get_post_meta( $post->ID, 'sermon_video', true );
        $audio_id = esc_attr( get_post_meta( $post->ID, 'sermon_audio_id', true ) );
        $audio_url = esc_attr( get_post_meta( $post->ID, 'sermon_audio_url', true ) );
        $pdf_id = esc_attr( get_post_meta( $post->ID, 'sermon_pdf_id', true ) );
        $pdf_url = esc_attr( get_post_meta( $post->ID, 'sermon_pdf_url', true ) );
        $videolabel = __( 'Video Link', 'sermon-section' );
        $audiolabel = __( 'Audio Link', 'sermon-section' );
        $pdflabel = __( 'PDF Link', 'sermon-section' );
        $btnlabelaudio = __( 'Upload Audio', 'sermon-section' );
        $btnlabel = __( 'Upload PDF', 'sermon-section' );
        wp_nonce_field( 'sermon_media', 'sermon_media_field' );
        $metabox_html = <<<EOD

<div class="sermon-metabox-fields">
    <div class="field_section">
        <div class="sermon_label">
            <label for="sermon_video">{$videolabel}: </label>
        </div>
        <div class="sermon_input">
            <input class="widefat" type="url" name="sermon_video" id="sermon_video" value="{$video}"/>
        </div>
		<div class="float_clear"></div>
    </div>
    <div class="field_section">
        <div class="sermon_label">
            <label>{$audiolabel}: </label>
        </div>
        <div class="sermon_input">
            <button class="button" id="upload_audio">{$btnlabelaudio}</button>
            <input type="hidden" name="sermon_audio_id" id="sermon_audio_id" value="{$audio_id}"/>
            <input type="hidden" name="sermon_audio_url" id="sermon_audio_url" value="{$audio_url}"/>
            <div id="audio-container"></div>
        </div>
		<div class="float_clear"></div>
    </div>
    <div class="field_section">
        <div class="sermon_label">
            <label>{$pdflabel}: </label>
        </div>
        <div class="sermon_input">
            <button class="button" id="upload_pdf">{$btnlabel}</button>
            <input type="hidden" name="sermon_pdf_id" id="sermon_pdf_id" value="{$pdf_id}"/>
            <input type="hidden" name="sermon_pdf_url" id="sermon_pdf_url" value="{$pdf_url}"/>
            <div id="pdf-container"></div>
        </div>
		<div class="float_clear"></div>
    </div>
</div>
EOD;
        echo $metabox_html;

    }
}

new SermonMetabox();