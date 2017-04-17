(function ($) {
    
    'use strict';
    
    $('.add-collection-widget').on('click', function(e){
        e.preventDefault();
        var $collection = $($(this).data('target'));
        var $template = $collection.data('prototype').replace(/__name__/g, $collection.find('> .form-group').length);
        $collection.append($template);
    });
    
})(jQuery);
