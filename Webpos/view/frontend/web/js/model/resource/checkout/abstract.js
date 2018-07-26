define(
    [
        'jquery',
        'uiClass',
        'Magestore_Webpos/js/model/event-manager',
        'mage/translate',
        'Magestore_Webpos/js/model/url-builder',
        'mage/storage'
    ],
    function ($, Class, Event, __, urlBuilder, storage) {
        "use strict";

        return Class.extend({
            getCallBackEvent: function(key){

            },
            /* Call Magento Rest Api*/
            callRestApi: function (apiUrl, params, deferred, callBack) {
                var self = this;
                deferred = (deferred)?deferred:$.Deferred();
                try {
                    var serviceUrl = urlBuilder.createUrl(apiUrl, {});
                }catch (e) {
                    console.log(e);
                }
                storage.post(
                    serviceUrl, JSON.stringify(params)
                ).done(
                    function (response) {
                        deferred.resolve(response);
                        if(callBack) {
                            Event.dispatch(callBack, {'response': response});
                        }
                    }
                ).fail(
                    function (response) {
                        if (response.status == 401) {
                            window.location.reload();
                        } else {
                            deferred.reject(response);
                        }
                    }
                );
                return deferred;
            },
            /**
             * Function to send API request and control respose
             * @param apiUrl
             * @param params
             * @param deferred
             * @param callBackEvent
             */
            callApi: function(apiUrl, params, deferred, callBackEvent){
                var self = this;
                console.log("vao day call API");
                self.callRestApi(apiUrl, params, deferred, callBackEvent);
                deferred.done(function (response) {

                    if(response.status && response.quote_data){
                        console.log("call Api thanh cong");
                        self.processResponseData(response.quote_data);
                    }
                }).fail(function (response) {
                    if(response.responseText){
                        var error = JSON.parse(response.responseText);
                        if(error.message != undefined){
                            alert(error.message);
                        }
                    }else{
                        console.log(response);
                        alert(__('Please check your network connection'));
                    }
                }).always(function(response){
                    response = (response.responseText)?JSON.parse(response.responseText):response;
                    if(response.messages){
                        self.processResponseMessages(response.messages, response.status);
                    }
                });
            },
            /**
             * Function to process response data - update sections - online checkout
             * @param data
             */
            processResponseData: function(data){
                if(data){
                    if (data.quote_id) {
                        Event.dispatch('init_quote_after', {
                            quote_id: data.quote_id
                        });
                    }
                    if(data.payment){
                        Event.dispatch('load_payment_after', {
                            items: data.payment
                        });
                    }
                    if(data.shipping) {
                        Event.dispatch('load_shipping_after', {
                            items: data.shipping
                        });
                    }
                    if(data.totals) {
                        Event.dispatch('load_totals_after', {
                            items: data.totals
                        });
                    }
                    if(data.items) {
                        Event.dispatch('load_items_after', {
                            items: data.items
                        });
                    }
                }
            },
            /**
             * Function to process API response messages
             * @param messages
             */
            processResponseMessages: function(messages, status){
                if(messages && messages.error){
                    $.each(messages.error, function(index, message){
                        if(message.message){
                            alert(message.message);
                        }
                    });
                }
                if(messages && messages.success){
                    $.each(messages.success, function(index, message){
                        if(message.message){
                            alert(message.message);
                        }
                    });
                }
                if($.isArray(messages)){
                    $.each(messages, function(index, message){
                        alert(message);
                    });
                }
            }
        });
    }
);
