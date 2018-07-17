define(
    [
        'jquery',
        'ko',
        'Magestore_Webpos/js/model/checkout/cart/items',
        'Magestore_Webpos/js/model/checkout/cart/totals',
        'Magestore_Webpos/js/model/event-manager',
        'Magestore_Webpos/js/model/data-manager',
        'Magestore_Webpos/js/model/resource/checkout/cart'
    ],
    function ($, ko, Items, Totals, Event, DataManager, CartResource) {
        "use strict";

        var CartModel = {
            /**
             * Variable to show ajax loader
             */
            loading: ko.observable(),
            /**
             * Variable to check current page - checkout or cart
             */
            currentPage: ko.observable(),
            /**
             * Current customer id
             */
            customerId: ko.observable(''),
            /**
             * Some const variable
             */
            BACK_CART_BUTTON_CODE: "back_to_cart",
            CHECKOUT_BUTTON_CODE: "checkout",
            PAGE:{
                CART:"cart",
                CHECKOUT:"checkout"
            },
            KEY: {
                ITEMS:'items',
                SHIPPING:'shipping',
                PAYMENT:'payment',
                TOTALS:'totals',
                QUOTE_ID:"quote_id",
                CUSTOMER_ID:"customer_id"
            },
            DATA:{
                STATUS: {
                    SUCCESS: '1',
                    ERROR: '0'
                }
            },
            /**
             * Initialize
             * @returns {CartModel}
             */
            initialize: function(){
                var self = this;
                self.initObserver();
                self.initDefaultData();
                console.log("vao model/cart");
                return self;
            },
            /**
             * Observer events
             */
            initObserver: function(){
                var self = this;
                self.isOnCheckoutPage = ko.pureComputed(function(){
                    return (self.currentPage() == self.PAGE.CHECKOUT)?true:false;
                });
                Event.observer('init_quote_after', function(event, response){
                    self.saveQuoteData(response);
                });
            },
            /**
             * Set default data
             */
            initDefaultData: function(){
                var self = this;
                self.customerId(1);
            },
            /**
             * Clear cart
             */
            emptyCart: function(){
                var self = this;
                Items.items.removeAll();
                self.removeCustomer();
                Totals.totals.removeAll();
                Event.dispatch('cart_empty_after','');
                self.resetQuoteInitData();
            },
            /**
             * Add customer
             * @param data
             */
            addCustomer: function(data){
                this.customerId(data.id);
            },
            /**
             * Remove customer
             */
            removeCustomer: function(){
                var self = this;
                self.customerId(1);
                Event.dispatch('cart_remove_customer_after','');
            },
            /**
             * Remove cart item
             * @param itemId
             */
            removeItem: function(itemId){
                Items.removeItem(itemId);
                if(Items.items().length == 0){
                    Totals.totals.removeAll();
                }
                Event.dispatch('cart_item_remove_after',Items.items());
            },
            /**
             * Add product to cart
             * @param data
             * @returns {boolean}
             */
            addProduct: function(data){
                var self = this;
                if(self.loading()){
                    return false;
                }
                try {
                    Items.addItem(data);
                    console.log("add Item thanh cong");
                }catch (e) {
                    console.log(e);
                }
            },
            /**
             * Update cart item data
             * @param itemId
             * @param key
             * @param value
             */
            updateItem: function(itemId, key, value){
                var validate = true;
                var item = Items.getItem(itemId);
                if(item){
                    Items.setItemData(itemId, key, value);
                }
            },
            /**
             * Get cart item data
             * @param itemId
             * @param key
             * @returns {*}
             */
            getItemData: function(itemId, key){
                return Items.getItemData(itemId, key);
            },
            /**
             * Get items info buy request
             * @returns {Array}
             */
            getItemsInfo: function(){
                var itemsInfo = [];
                if(Items.items().length > 0){
                    ko.utils.arrayForEach(Items.items(), function(item) {
                        itemsInfo.push(item.getInfoBuyRequest());
                    });
                }
                return itemsInfo;
            },
            /**
             * Get items init data
             * @returns {Array}
             */
            getItemsInitData: function(){
                var itemsData = [];
                if(Items.items().length > 0){
                    ko.utils.arrayForEach(Items.items(), function(item) {
                        itemsData.push(item.getData());
                    });
                }
                return itemsData;
            },
            /**
             * Get total items number
             * @returns {*}
             */
            totalItems: function(){
                return Items.totalItems();
            },
            /**
             * Reset quote data
             */
            resetQuoteInitData: function(){
                var self = this;
                var data = {
                    quote_id: 0
                };
                self.saveQuoteData(data);
            },
            /**
             * Get quote data params for API request
             * @returns {{quote_id: number}}
             */
            getQuoteInitParams: function(){
                var self = this;
                var quoteId = DataManager.getData(self.KEY.QUOTE_ID);
                return {
                    quote_id: (quoteId)?quoteId:0
                };
            },
            /**
             * Save cart and dispatch events
             * @returns {*}
             */
            saveQuoteBeforeCheckout: function(){
                var self = this;
                var params = self.getQuoteInitParams();
                params.items = self.getItemsInfo();
                params.customer_id = (self.customerId())?self.customerId():0;
                params.section = [];
                self.loading(true);
                var apiRequest = $.Deferred();
                console.log(apiRequest+"  VA   "+ params);
                try {
                    console.log("Vao CartResource() roi kia");
                    CartResource().saveQuoteBeforeCheckout(params, apiRequest);
                }catch(Exception){
                    console.log(Exception);
                }
                apiRequest.always(function(){
                    self.loading(false);
                });
                return apiRequest;
            },
            /**
             * Call API to empty cart - remove quote
             * @returns {*}
             */
            removeQuote: function(){
                var self = this;
                var params = self.getQuoteInitParams();
                self.loading(true);
                var apiRequest = $.Deferred();
                CartResource().removeQuote(params, apiRequest);

                apiRequest.done(
                    function (response) {
                        if(response.status == self.DATA.STATUS.SUCCESS){
                            self.emptyCart();
                        }
                    }
                ).always(function(){
                    self.loading(false);
                });
                return apiRequest;
            },
            /**
             * Call API to remove cart item online
             * @param itemId
             * @returns {*}
             */
            removeQuoteItem: function(itemId){
                var self = this;
                if(Items.items().length == 1){
                    return self.removeQuote();
                }

                var params = self.getQuoteInitParams();
                params.item_id = itemId;

                self.loading(true);
                var apiRequest = $.Deferred();
                CartResource().removeQuoteItem(params, apiRequest);

                apiRequest.done(
                    function (response) {
                        if(response.status == self.DATA.STATUS.SUCCESS){
                            self.removeItem(itemId);
                        }
                    }
                ).always(function(){
                    self.loading(false);
                });
                return apiRequest;
            },
            /**
             * Check if cart has been saved online or not
             * @returns {boolean}
             */
            hasQuote: function(){
                var self = this;
                return (DataManager.getData(self.KEY.QUOTE_ID))?true:false;
            },
            /**
             * Save quote init data to data manager
             * @param quoteData
             */
            saveQuoteData: function(quoteData){
                if(quoteData){
                    $.each(quoteData, function(key, value){
                        DataManager.setData(key, value);
                    })
                }
            }
        };
        return CartModel.initialize();
    }
);
