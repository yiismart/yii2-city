var city = {
    init: function() {
        $('#make-url').on('click', this.make_url);
    },
    make_url: function() {
        var $button = $(this), $input = $('#cityform-url');
        if ($input.hasClass('state-loading')) {
            return;
        }
        $input.addClass('state-loading');
        $.get($button.data('url'), {s: $('#cityform-name').val()}, function(data) {
            $input.val(data).removeClass('state-loading');
        }, 'json');
    }
};

city.init();
