
define([
    'jquery',
    'Magento_Ui/js/modal/alert',
    'Magestore_Webpos/js/lib/jquery.toaster',
], function ($, Alert, $toaster) {
    'use strict';
    return function(data) {
        if(data && data.priority){
            $.toaster({
                priority: data.priority,
                title: (data.title),
                message: (data.message)
            });
        }else{
            Alert({
                title: (data.title),
                content: (data.content),
                autoOpen: true,
                clickableOverlay: true,
                focus: "",
                actions: {
                    always: function(){
                    }
                }
            });
        }
    }
});
