define([
    'jquery',
    'ko',
    'Magestore_Webpos/js/model/checkout/cart/items',
    'Magestore_Webpos/js/model/checkout/cart/totals/total',
    'Magestore_Webpos/js/model/event-manager'
],function($, ko, Items, Total, Event){

    /**
     * Totals object to manage quote total
     * @type {{totals: *, initialize: Totals.initialize, initObserver: Totals.initObserver, getGrandTotal: Totals.getGrandTotal, getTotals: Totals.getTotals, getTotalValue: Totals.getTotalValue, getTotal: Totals.getTotal, updateTotalsFromQuote: Totals.updateTotalsFromQuote, processQuoteTotals: Totals.processQuoteTotals}}
     */
    var Totals = {
        /**
         * List of totals
         */
        totals: ko.observableArray(),
        /**
         * Constructor
         * @returns {Totals}
         */
        initialize: function () {
            var self = this;
            self.initObserver();
            console.log("MODEL TOTAL");

            return this;
        },
        /**
         * Init events
         */
        initObserver: function(){
            var self = this;
            /**
             * Remove all totals when clear cart
             */
            Event.observer('cart_empty_after', function(event, data){
                self.totals([]);
            });

            /**
             * Binding totals from quote to model data after get response from API
             */
            Event.observer('load_totals_after', function(event, data){
                if(data && data.items){

                    self.updateTotalsFromQuote(data.items);
                }
            });
        },
        /**
         * Get grand total value
         * @returns {number}
         */
        getGrandTotal: function(){
            var self = this;
            var grandTotal = self.getTotalValue('grand_total');
            return (grandTotal)?grandTotal:0;
        },
        /**
         * Get list totals
         * @returns {*}
         */
        getTotals: function () {
            return this.totals();
        },
        /**
         * Get total value
         * @param totalCode
         * @returns {string}
         */
        getTotalValue: function (totalCode) {
            var value = "";
            var total = this.getTotal(totalCode);
            if (total !== false) {
                value = total.value();
                console.log("Total co gia tri: "+ value);
            }
            return value;
        },
        /**
         * Get total object by code from list
         * @param totalCode
         * @returns {boolean}
         */
        getTotal: function (totalCode) {
            var totalFound = ko.utils.arrayFirst(this.totals(), function (total) {
                return total.code() == totalCode;
            });
            return (totalFound) ? totalFound : false;
        },
        /**
         * Use totals from quote
         * @param totals
         */
        updateTotalsFromQuote: function(totals){
            if(totals && totals.length > 0){
                var self = this;
                var quoteTotals = [];
                $.each(totals, function(index, data){
                    var total = self.processQuoteTotals(data);
                    quoteTotals.push(total);
                });
                self.totals(quoteTotals);
            }
        },

        /**
         * Init total object data
         * @param data
         * @returns {*}
         */
        processQuoteTotals: function(data){
            var self = this;
            console.log("total data:"+ data);
            var total = new Total();
            // total.init({
            //     code: data.code,
            //     title: data.title,
            //     value: data.value
            // });
            //Before data is a array String=> convert to array Object
            total.init(JSON.parse(data));
            return total;
        }
    }
    return Totals.initialize();
});

