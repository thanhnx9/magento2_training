define(
    [
        'jquery',
        'ko',
        'Magestore_Webpos/js/model/event-manager',
        'Magestore_Webpos/js/model/checkout/checkout'
    ],
    function ($, ko, Event, CheckoutModel) {
        "use strict";

        /**
         * Shipping model to manage shipping methods
         * @type {{items: *, isSelected: *, initialize: ShippingModel.initialize, saveShippingMethod: ShippingModel.saveShippingMethod}}
         */
        var ShippingModel = {
            /**
             * Shipping methods
             */
            items: ko.observableArray([]),
            /**
             * Check selected shipping method
             */
            isSelected: CheckoutModel.selectedShippingCode,
            /**
             * Initialize
             */
            initialize: function(){
                var self = this;
                Event.observer('load_shipping_after', function(event, data){
                    if(data && data.items){
                        self.items(data.items);
                    }
                });
            },
            /**
             * Save shipping method
             * @param data
             */
            saveShippingMethod: function (data) {
                CheckoutModel.saveShipping(data);
            },

        };
        ShippingModel.initialize();
        return ShippingModel;
    }
);
