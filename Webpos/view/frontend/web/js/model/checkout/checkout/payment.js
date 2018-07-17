define(
    [
        'jquery',
        'ko',
        'Magestore_Webpos/js/model/event-manager',
        'Magestore_Webpos/js/model/checkout/checkout'
    ],
    function ($, ko, Event, CheckoutModel) {
        "use strict";
        var PaymentModel = {
            /**
             * List of payment methods
             */
            items: ko.observableArray([]),
            /**
             * Constuctor
             */
            initialize: function(){
                var self = this;
                Event.observer('load_payment_after', function(event, data){
                    if(data && data.items){
                        self.items(data.items);
                    }
                });
            },
            /**
             * Save payment data
             * @param data
             */
            setPaymentMethod: function(data){
                var self = this;
                if(data && data.code){
                    CheckoutModel.savePaymentMethod(data.code);
                }
            }
        };
        PaymentModel.initialize();
        return PaymentModel;
    }
);
