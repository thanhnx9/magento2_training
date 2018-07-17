define([
    'Magestore_Webpos/js/view/container/abstract' //khai bao Customer Container extends từ Container Abstract
], function (Container) {
    'use strict';

    return Container.extend({
        defaults: {
            container_id:"customer_list"
        }
    });
});
