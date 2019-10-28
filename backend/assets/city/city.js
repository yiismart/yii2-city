var city = {
    init: function() {
        $('#make-alias').on('click', this.make_alias);
    },
    make_alias: function() {
        var $button = $(this), $input = $('#cityform-alias');
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
