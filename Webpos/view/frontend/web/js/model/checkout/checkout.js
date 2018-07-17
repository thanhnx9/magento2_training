define(
    [
        'jquery',
        'ko',
        'Magestore_Webpos/js/model/checkout/cart',
        'Magestore_Webpos/js/model/event-manager',
        'Magestore_Webpos/js/model/resource/checkout/checkout'
    ],
    function ($, ko, CartModel, Event, CheckoutResource) {
        "use strict";
        var CheckoutModel = {
            /**
             * Selected shipping method title
             */
            selectedShippingTitle: ko.observable(),
            /**
             * Selected shipping method code
             */
            selectedShippingCode: ko.observable(),
            /**
             * Selected payment method code
             */
            paymentCode: ko.observable(),
            /**
             * Created order data
             */
            createOrderResult: ko.observable({}),
            /**
             * Variable to enable ajax loader
             */
            loading: ko.observable(),
            /**
             * Check if the order has been created
             * @returns {boolean}
             */
            isCreatedOrder: function(){
                return (this.createOrderResult() && this.createOrderResult().increment_id)?true:false;
            },
            /**
             * Init default data
             */
            initDefaultData: function(){
                var self = this;
                self.selectedShippingTitle('');
                self.selectedShippingCode('');
                self.createOrderResult({});
                self.initObservable();
            },
            /**
             * Observer events
             */
            initObservable: function(){
                var self = this;
                Event.observer('cart_empty_after', function(){
                    self.resetCheckoutData();
                });
                Event.observer('load_shipping', function(){
                    self.loadShipping();
                });
                Event.observer('load_payment', function(){
                    self.loadPaymentOnline();
                });
            },
            /**
             * Reset checkout data
             */
            resetCheckoutData: function(){
                var self = this;
                self.createOrderResult({});
                self.useDefaultShipping();
                CartModel.removeCustomer();
            },
            /**
             * Use default shipping method
             */
            useDefaultShipping: function(){

            },
            /**
             * Save shipping data
             * @param data
             */
            saveShipping: function(data){
                var self = this;
                if(data.code){
                    self.selectedShippingTitle(data.title);
                    self.selectedShippingCode(data.code);
                    self.saveShippingMethod(data.code);
                }
            },
            /**
             * Call API to save shipping method
             * @param code
             * @returns {*}
             */
            saveShippingMethod: function(code){
                var deferred = $.Deferred();
                if(code){
                    var self = this;
                    var params = CartModel.getQuoteInitParams();
                    params.shipping_method = code;
                    self.loading(true);
                    CheckoutResource().saveShippingMethod(params,deferred);
                    deferred.always(function(){
                        self.loading(false);
                    });

                }
                return deferred;
            },
            /**
             * Call API to save payment method
             * @param code
             * @returns {*}
             */
            savePaymentMethod: function(code){
                var deferred = $.Deferred();
                if(code){
                    var self = this;
                    var params = CartModel.getQuoteInitParams();
                    params.payment_method = code;
                    self.loading(true);
                    CheckoutResource().savePaymentMethod(params,deferred);
                    deferred.done(function(){
                        self.paymentCode(code);
                    }).always(function(){
                        self.loading(false);
                    });
                }
                return deferred;
            },
            /**
             * Place order online
             * @returns {*}
             */
            placeOrder: function(){
                var self = this;
                var deferred = $.Deferred();
                var params = CartModel.getQuoteInitParams();
                self.loading(true);
                CheckoutResource().placeOrder(params,deferred);
                deferred.done(function(response){
                    if(response.increment_id){
                        self.createOrderResult(response);
                    }
                }).always(function(){
                    self.loading(false);
                });
                return deferred;
            },
            /**
             * Call API to save customer
             * @returns {*}
             */
            selectCustomer: function(){
                var self = this;
                var deferred = $.Deferred();
                var params = CartModel.getQuoteInitParams();
                params.customer = CartModel.getQuoteCustomerParams();
                self.loading(true);
                CheckoutResource().selectCustomer(params,deferred);
                deferred.always(function(){
                    self.loading(false);
                });
                return deferred;
            }
        };
        CheckoutModel.initDefaultData();
        return CheckoutModel;
    }
);
