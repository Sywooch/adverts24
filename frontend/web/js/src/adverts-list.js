jQuery(function ($) {
    var filter = $('#adverts-list-filter');
    // filter affixing
    var initFilterAffix = function () {
        if (filter.outerHeight() > ($(window).height() - 120)) {
            filter.removeClass('less-than-screen').addClass('more-than-screen').data('affix', null).affix({offset: {top: function () {
                return filter.outerHeight() + 120 - $(window).height();
            }}});
        } else {
            filter.removeClass('more-than-screen').addClass('less-than-screen').data('affix', null).affix({offset: {top: 0}});
        }
    }
    initFilterAffix();
    $(window).resize(initFilterAffix);

    // filter form pjax reloading
    $('#filter-form').on('change.yiiActiveForm', function(event) {
        $.pjax.submit(event, '#adverts-list-pjax');
    });
    $(document).on('pjax:beforeSend', function(data, xhr, options) {
        var targetId = options.target ? options.target.id : null;
        if (targetId == 'filter-form' || targetId == 'search-form') {
            var params = {}, url = [];
            $.each(window.location.search.slice(window.location.search.indexOf('?') + 1).split('&'), function(i, field) {
                var parts = field.split('=');
                if (parts.length == 2) {
                    params[parts[0]] = parts[1];
                }
            });
            $.each(jQuery('#filter-form').serializeArray(), function(i, field) {
                if (field.value) {
                    params[field.name] = field.value;
                }
            });
            $.each(params, function(name, value) {
                url.push(name + '=' + value);
            });
            options.url = options.url.split('?')[0] + '?' + url.join('&');
        }
    });

    // price select buttons
    $('#adverts-list-filter').on('blur', '[name=min_price], [name=max_price]', function() {
        var currencyField = $('#adverts-list-filter .field-currency_id'),
            form = $('#adverts-list-filter');
        if (!form.find('[name=min_price]')[0].value && !form.find('[name=max_price]')[0].value) {
            currencyField.fadeOut(1000, initFilterAffix);
        } else {
            currencyField.fadeIn(1000, initFilterAffix);
        }
    });
});