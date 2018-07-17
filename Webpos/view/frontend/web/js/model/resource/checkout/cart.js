define(
    [
        'Magestore_Webpos/js/model/resource/checkout/abstract'
    ],
    function (resourceAbstract) {
        "use strict";

        return resourceAbstract.extend({
            initialize: function () {
                this._super();
                this.apiSaveCartUrl = "/webpos/cart/save";
                this.apiRemoveCartUrl = "/webpos/cart/removeCart";
                this.apiRemoveItemUrl = "/webpos/cart/removeItem";
            },
            getCallBackEvent: function(key){
                switch(key){
                    case "saveCart":
                        return "save_cart_after";
                    case "removeCart":
                        return "remove_cart_after";
                    case "removeItem":
                        return "remove_item_after";
                }
            },
            saveQuoteBeforeCheckout: function(params,deferred){
                var apiUrl = this.apiSaveCartUrl;
                var callBackEvent = this.getCallBackEvent("saveCart");
                console.log("URL la: "+apiUrl);
                try {
                    console.log("Vao resource cart roi kia...");
                    this.callApi(apiUrl, params, deferred, callBackEvent);
                }catch ($e) {
                    console.log($e);
                }

            },
            removeQuote: function(params,deferred){
                var apiUrl = this.apiRemoveCartUrl;
                var callBackEvent = this.getCallBackEvent("removeCart");
                this.callApi(apiUrl, params, deferred, callBackEvent);
            },
            removeQuoteItem: function(params,deferred){
                var apiUrl = this.apiRemoveItemUrl;
                var callBackEvent = this.getCallBackEvent("removeItem");
                this.callApi(apiUrl, params, deferred, callBackEvent);
            }
        });
    }
);
