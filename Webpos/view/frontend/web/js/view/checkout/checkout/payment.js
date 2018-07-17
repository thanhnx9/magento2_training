define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magestore_Webpos/js/model/checkout/checkout/payment'
    ],
    function ($, ko, Component, PaymentModel) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Magestore_Webpos/checkout/checkout/payment',
            },
            items: PaymentModel.items,
            visible: ko.observable(true),
            initialize: function () {
                this._super();
                this.initObserver();
            },
            initObserver: function(){
                var self = this;
            },
            setPaymentMethod: function (data) {
                PaymentModel.setPaymentMethod(data);
            }
        });
    }
);
