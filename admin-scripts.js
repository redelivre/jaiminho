jQuery.fn.filterByText = function(textbox) {
    return this.each(function() {
        var select = this;
        var options = [];
        jQuery(select).find('option').each(function() {
            options.push({value: jQuery(this).val(), text: jQuery(this).text()});
        });
        jQuery(select).data('options', options);

        jQuery(textbox).bind('change keyup', function() {
            var options = jQuery(select).empty().data('options');
            var search = jQuery.trim(jQuery(this).val());
            var regex = new RegExp(search,"gi");

            jQuery.each(options, function(i) {
                var option = options[i];
                if(option.text.match(regex) !== null) {
                    jQuery(select).append(
                        jQuery('<option>').text(option.text).val(option.value)
                    );
                }
            });
        });
    });
};

jQuery(function() {
    jQuery('select').filterByText(jQuery('#filter'));
});

