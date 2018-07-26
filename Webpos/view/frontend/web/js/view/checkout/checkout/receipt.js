define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magestore_Webpos/js/model/checkout/checkout',
        'Magestore_Webpos/js/model/event-manager',
        'mage/translate',
        'Magento_Catalog/js/price-utils'
    ],
    function ($, ko, Component, CheckoutModel, Event, __, PriceUtils) {
        "use strict";

        return Component.extend({
            containerId: 'checkout_success_print_receipt',
            defaults: {
                template: 'Magestore_Webpos/checkout/checkout/receipt'
            },
            totalsCode: ko.observableArray(),
            configs: ko.observableArray(),
            customerAdditionalInfomation: ko.observableArray(),
            printWindow: ko.observable(),
            initialize: function () {
                this._super();
                console.log("COME ON receipt...");
                this.orderData = ko.pureComputed(function(){
                    var result = CheckoutModel.createOrderResult();
                    return (result && result.increment_id)?result:false;
                });
                var self = this;
                Event.observer('print_receipt',function(event,data){
                    self.printReceipt();
                });
                Event.observer('start_new_order', function(){
                    if(self.printWindow()){
                        self.printWindow().close();
                    }
                });
                Event.observer('webpos_order_save_after', function(event, data){
                    if(data && data.increment_id){
                        self.initDefaultData();
                    }
                });
            },
            
            initDefaultData: function(){
                var self = this;
                var totalsCode =[
                    {code:'subtotal',title:'Subtotal', required:true, sortOrder: 1, isPrice: true},
                    {code:'shipping_amount',title:'Shipping', required:true, sortOrder: 10, isPrice: true},
                    {code:'tax_amount',title:'Tax', required:true,  sortOrder: 20, isPrice: true},
                    {code:'discount_amount',title:'Discount', required:false,  sortOrder: 30, isPrice: true},
                    {code:'grand_total',title:'Grand Total', required:true,  sortOrder: 40, isPrice: true},
                    {code:'total_paid',title:'Total Paid', required:true,  sortOrder: 50, isPrice: true},
                    {code:'total_due',title:'Total Due', required:true,  sortOrder: 60, isPrice: true}
                ];
                console.log("totalsCode");
                totalsCode.sort(function(a, b) {
                    if(!a.sortOrder){
                        a.sortOrder = 2;
                    }
                    if(!b.sortOrder){
                        b.sortOrder = 2;
                    }
                    return parseFloat(a.sortOrder) - parseFloat(b.sortOrder);
                });
                self.totalsCode(totalsCode);
            },
            
            formatPrice: function(string){
                return PriceUtils.formatPrice(string, window.webposConfig.priceFormat);
            },
            
            getConfigData: function(code){
                if(this.configs()){
                    var config = ko.utils.arrayFirst(this.configs(), function(config){
                        return (config && config.code == code);
                    });
                    if(config){
                        return config.value;
                    }
                }
                return "";
            },
            
            getOrderData: function (key) {
                var self = this;
                var data = false;
                if(self.orderData()){
                    data = self.orderData();
                    if(key){
                        if(typeof data[key] != "undefined"){
                            data = data[key];
                        }else{
                            data = ""
                        }
                    }
                }
                return data;
            },
            getIncrementId: function(){
                return "#"+this.getOrderData('increment_id');
            },
            getCreatedDate: function(){
                return DateHelper.getDate(this.getOrderData('created_at'));
            },
            getCashierName: function(){
                return this.getOrderData('webpos_staff_name');
            },
            getCreatedTime: function(){
                return this.getOrderData('created_at');
            },
            getComment: function(){
                return this.getOrderData('customer_note');
            },
            getShipping: function(){
                return this.getOrderData('shipping_description');
            },
            hasShipping: function(){
                return (this.getOrderData('shipping_amount')>0)?true:false;
            },
            getCustomerName: function(){
                return this.getOrderData('customer_firstname')+" "+this.getOrderData('customer_lastname');
            },
            hasCustomerName: function(){
                return (this.getOrderData('customer_firstname') || this.getOrderData('customer_lastname'))?true:false;
            },
            getPayment: function(){
                var payments = [];
                return payments;
            },
            hasPayment: function(){
                return (this.getPayment() && this.getPayment().length >0)?true:false;
            },
            getItems: function(){
                console.log("Vao receipt()-getItems");
                return this.getOrderData('items');
            },
            getOrderTotals: function(){
                var self = this;
                var totals = [];
                if(self.totalsCode() && self.totalsCode().length > 0){
                    ko.utils.arrayForEach(self.totalsCode(), function(data) {
                        var amount = self.getOrderData(data.code);
                        if(amount || (data.required && data.required == true)){
                            var value = (data.isPrice == false)?(amount +' '+data.valueLabel):self.formatPrice(amount);
                            var total = {
                                'label':data.title,
                                'value':value
                            };
                            totals.push(total);
                        }
                    });
                }
                return totals;
            },
            getCustomerAdditionalInfo: function(){
                var self = this;
                if(self.customerAdditionalInfomation() && self.customerAdditionalInfomation().length > 0){
                    return self.customerAdditionalInfomation();
                }
                return [];
            },
            toHtml: function(){
                var self = this;
                var html = "";
                if($("#"+self.containerId).length > 0){
                    var settings = {
                        output:"css",
                        bgColor: "#FFFFFF",
                        color: "#000000",
                        barWidth: 1,
                        barHeight: 20
                      };
                    html = $("#"+self.containerId).html();
                }
                return html;
            },
            printReceipt: function(){
                var self = this;
                self.initDefaultData();
                var print_window = window.open('', 'print_offline', 'status=1,width=500,height=700');
                var html = self.toHtml();
                if(print_window){
                    self.printWindow(print_window);
                    print_window.document.open();
                    print_window.document.write(html);
                    print_window.print();
                }else{
                    alert(__("Your browser has blocked the automatic popup, please change your browser setting or print the receipt manually"));
                }
            }
            
        });
    }
);