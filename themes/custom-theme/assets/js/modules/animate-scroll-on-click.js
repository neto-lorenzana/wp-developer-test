const $ = jQuery;

export default {

    init () {
        this.listen_for_on_page_anchors();
    },

    listen_for_on_page_anchors () {

        function link_is_targeting_on_page_anchor (link) {
            return /^#/.test(link);
        }

        $('a').on('click', function (e) {

            var href = $(this).attr('href');

            if (link_is_targeting_on_page_anchor(href)) {

                var $target_element = $(href);
                if (!$target_element.length) {
                    return;
                }

                e.preventDefault();

                var scroll_top = $target_element.offset().top - 100;

                // subtract any additional height considerations to scroll_top (e.g; height of sticky header)
                //scroll_top -= $('.oxy-sticky-header-active').outerHeight();

                $('html, body').animate({scrollTop: scroll_top}, 600);
            }

        });
    }

}