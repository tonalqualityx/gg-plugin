<?php defined( 'ABSPATH' ) or die( 'Sectumsempra!' );//For enemies

function mdgg_video() {

    ob_start(); ?>

    <div id="mdgg-player">
        <script src="https://fast.wistia.com/embed/medias/ezpbmlky1x.jsonp" async></script>
        <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
        <div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;">
            <div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;">
                <div class="wistia_embed wistia_async_ezpbmlky1x videoFoam=true" style="height:100%;position:relative;width:100%">
                    <div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;">
                        <img src="https://fast.wistia.com/embed/medias/ezpbmlky1x/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 

    return ob_get_clean();
}

add_shortcode( 'mdgg-video', 'mdgg_video' );