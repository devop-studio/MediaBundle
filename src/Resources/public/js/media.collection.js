(function ($) {
    
    'use strict';
    
    $('.add-collection-widget').on('click', function(e){
        e.preventDefault();
        var $collection = $($(this).data('target'));
        var $template = $($collection.data('prototype').replace(/__name__/g, $collection.find('> .form-group').length));
        $template.find('.file').fileinput()
        $template.find('label').remove();
        $template.find('.col-sm-10').removeClass('col-sm-10').addClass('col-sm-12');
        $template.appendTo($collection);
    });
    
})(jQuery);
