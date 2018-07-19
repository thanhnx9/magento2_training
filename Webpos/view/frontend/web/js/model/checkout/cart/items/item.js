define(
    [
        'jquery',
        'ko',
        'uiClass',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, ko, UiClass, PriceUtils) {
        "use strict";
        return UiClass.extend({
            initialize: function () {
                this._super();
                /**
                 * Object fields key.
                 * @type {string[]}
                 */
                this.initFields = [
                    'product_id',
                    'name',
                    'item_id',
                    'qty',
                    'unit_price',
                    'custom_price',
                    'image_url',
                    'saved_item'
                ];
                console.log("GET ITEM>>>>");
            },
            /**
             * Init data
             * @param data
             */
            init: function(data){
                console.log("Item added: "+data);
                var self = this;
                $.each(self.initFields, function(index, fieldKey){
                    self[fieldKey] = ko.observable((typeof data[fieldKey] != "undefined")?data[fieldKey]:'');
                })

                self.row_total = ko.pureComputed(function () {
                    var rowTotal = self.qty() * self.unit_price();
                    console.log(rowTotal);
                    return rowTotal;
                });

                self.row_total_formated = ko.pureComputed(function () {
                    var rowTotal = self.row_total();
                    console.log("Vao row_total: "+rowTotal);
                    return PriceUtils.formatPrice(rowTotal, window.webposConfig.priceFormat);
                });
            },
            /**
             * Set data
             * @param key
             * @param value
             */
            setData: function(key, value){
                var self = this;
                if($.type(key) == 'string') {
                    self[key](value);
                }else{
                    $.each(key, function(index, val){
                        self[index](val);
                    });
                }
            },
            /**
             * Get item data
             * @param key
             * @returns {{}}
             */
            getData: function(key){
                var self = this;
                var data = {};
                if(typeof key != "undefined"){
                    data = self[key]();
                }else{
                    var data = {};
                    $.each(self.initFields, function(){
                        data[this] = self[this]();
                    });
                }
                return data;
            },
            /**
             * Get item info buy request to send to API
             * @returns {{}}
             */
            getInfoBuyRequest: function(){
                var self = this;
                var infobuy = {};
                infobuy.item_id = self.item_id();
                infobuy.id = self.product_id();
                infobuy.qty = self.qty();
                infobuy.custom_price = self.custom_price();
                return infobuy;
            }
        });
    }
);

