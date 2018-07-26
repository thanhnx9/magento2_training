define(
    [
        'jquery',
        'ko',
        'uiClass',
        'Magento_Catalog/js/price-utils'
    ],
    function ($,ko, UiClass, PriceUtils) {
        "use strict";
        return UiClass.extend({
            initialize: function () {
                this._super();
                /**
                 * Object init fields key
                 * @type {string[]}
                 */
                this.initFields = [
                    'title',
                    'value',
                    'code'
                ];
                console.log("TOTAL SHOW>>>");
            },
            /**
             * Init data to object
             * @param data
             */
            init: function(data){
                console.log("Total added:"+data);
                var self = this;
                $.each(self.initFields, function(index, fieldKey){
                    self[fieldKey] = ko.observable((typeof data[fieldKey] != "undefined")?data[fieldKey]:'');
                    console.log("TOTAL: "+self[fieldKey]+" va "+data[fieldKey]);
                });
                self.valueFormated = ko.pureComputed(function(){
                    var value = self.value();
                    console.log("TIEN LA: "+value);
                    return PriceUtils.formatPrice(value, window.webposConfig.priceFormat);
                });

            },
            /**
             * Set total data
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
             * Get total data
             * @param key
             * @returns {{}}
             */
            getData: function(key){
                var self = this;
                var data = {};
                if(typeof key != "undefined"){
                    data = self[this]();
                }else{
                    var data = {};
                    $.each(this.initFields, function(){
                        data[this] = self[this]();
                    });
                }
                return data;
            }
        });
    }
);
