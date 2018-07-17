define([
    'mage/translate'
], function (__) {
    'use strict';
    return {
        getTotalOrderView: function(){
            return [
                {totalName: 'base_subtotal', totalLabel: 'Subtotal', required: true, isPrice:true},
                {totalName: 'rewardpoints_earn', totalLabel: 'Earned Points', required: false, isPrice:false, valueLabel:__('Points') },
                {totalName: 'rewardpoints_spent', totalLabel: 'Spent Points', required: false, isPrice:false, valueLabel:__('Points')},
                {totalName: 'base_shipping_amount', totalLabel: 'Shipping', required: true, isPrice:true},
                {totalName: 'base_tax_amount', totalLabel: 'Tax', required: false, isPrice:true},
                {totalName: 'base_discount_amount', totalLabel: 'Discount', required: false, isPrice:true},
                {totalName: 'base_gift_voucher_discount', totalLabel: 'Gift Voucher', required: false, isPrice:true},
                {totalName: 'rewardpoints_base_discount', totalLabel: 'Points Discount', required: false, isPrice:true},
                {totalName: 'base_grand_total', totalLabel: 'Grand Total', required: true, isPrice:true},
                {totalName: 'base_total_paid', totalLabel: 'Total Paid', required: true, isPrice:true},
                {totalName: 'base_total_refunded', totalLabel: 'Total Refunded', required: false, isPrice:true},
                {totalName: 'webpos_base_change', totalLabel: 'Change', required: false, isPrice:true},
            ]
        },

        getTotalOrderHold: function(){
            return [
                {totalName: 'base_subtotal', totalLabel: 'Subtotal', required: true},
                {totalName: 'base_shipping_amount', totalLabel: 'Shipping', required: true},
                {totalName: 'base_tax_amount', totalLabel: 'Tax', required: false},
                {totalName: 'base_discount_amount', totalLabel: 'Discount', required: false},
                {totalName: 'base_grand_total', totalLabel: 'Grand Total', required: true}
            ]
        },

        getTotalOrderPrint: function(){
            return this.getTotalOrderView();
        }
    }
});
