define(
    [
        'Magestore_Webpos/js/model/resource/checkout/abstract'
    ],
    function (resourceAbstract) {
        "use strict";

        return resourceAbstract.extend({
            /**
             * Init API routes
             */
            initialize: function () {
                this._super();
                this.apiSelectCustomerUrl = "/webpos/checkout/selectCustomer";
                this.apiPlaceOrderUrl = "/webpos/checkout/placeOrder";
                this.apiSavePaymentMethodUrl = "/webpos/checkout/savePaymentMethod";
                this.apiSaveShippingMethodUrl = "/webpos/checkout/saveShippingMethod";
            },
            /**
             * Get callback event name
             * @param key
             * @returns {*}
             */
            getCallBackEvent: function(key){
                switch(key){
                    case "selectCustomer":
                        return "select_customer_after";
                    case "placeOrder":
                        return "place_order_after";
                    case "saveShippingMethod":
                        return "save_shipping_method_after";
                    case "savePaymentMethod":
                        return "save_payment_method_after";
                }
            },
            /**
             * API to set customer for online quote
             * @param params
             * @param deferred
             */
            selectCustomer: function(params,deferred){
                var apiUrl,
                    urlParams,
                    callBackEvent;
                apiUrl = this.apiSelectCustomerUrl;
                callBackEvent = this.getCallBackEvent("selectCustomer");
                urlParams = {};
                this.callRestApi(apiUrl, "post", urlParams, params, deferred, callBackEvent);
            },
            /**
             * API to save shipping method
             * @param params
             * @param deferred
             */
            saveShippingMethod: function(params,deferred){
                var apiUrl = this.apiSaveShippingMethodUrl;
                var callBackEvent = this.getCallBackEvent("saveShippingMethod");
                this.callApi(apiUrl, params, deferred, callBackEvent);
            },
            /**
             * API to save payment method
             * @param params
             * @param deferred
             */
            savePaymentMethod: function(params,deferred){
                var apiUrl = this.apiSavePaymentMethodUrl;
                var callBackEvent = this.getCallBackEvent("savePaymentMethod");
                this.callApi(apiUrl, params, deferred, callBackEvent);
            },
            /**
             * API place order
             * @param params
             * @param deferred
             */
            placeOrder: function(params,deferred){
                var apiUrl = this.apiPlaceOrderUrl;
                var callBackEvent = this.getCallBackEvent("placeOrder");
                this.callApi(apiUrl, params, deferred, callBackEvent);
            }
        });
    }
);
