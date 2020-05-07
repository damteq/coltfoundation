(function ($) {

    $(document).ready(function () {
        let position = $(window).scrollTop();

        $(window).scroll(function () {
            let scroll = $(window).scrollTop(),
                header = $('.elementor-sticky'),
                sticky = 'at-top';
            if (scroll > position) {
                header.addClass(sticky);
            }
            position = scroll;
        });
        $(window).scroll(function () {
            let $this = $(this),
                header = $('.elementor-sticky'),
                sticky = 'at-top';

            if ($this.scrollTop() == 0) {
                header.removeClass(sticky);
            }
        });

    });

})
(jQuery);