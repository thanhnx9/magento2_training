define(
    [
        'jquery',
        'ko',
        'Magestore_Webpos/js/model/checkout/cart/items/item',
        'Magestore_Webpos/js/model/event-manager'
    ],
    function ($, ko, Item, Event) {
        "use strict";

        /**
         * Items object to manage quote items
         * @type {{items: *, initialize: Items.initialize, getItems: Items.getItems, getAddedItem: Items.getAddedItem, addItem: Items.addItem, getItem: Items.getItem, getItemData: Items.getItemData, setItemData: Items.setItemData, removeItem: Items.removeItem, totalItems: Items.totalItems, updateItemsFromQuote: Items.updateItemsFromQuote}}
         */
        var Items = {
            /**
             * List of cart items
             */
            items: ko.observableArray(),
            /**
             * Constructor
             * @returns {Items}
             */
            initialize: function () {
                var self = this;
                /**
                 * Check if cart is empty
                 */
                self.isEmpty = ko.pureComputed(function(){
                    return (self.items().length > 0)?false:true;
                });

                /**
                 * Binding cart items to model data after get response from API
                 */
                Event.observer('load_items_after', function(event, data){
                    if(data && data.items){
                        self.updateItemsFromQuote(data.items);
                    }
                });
                return self;
            },
            /**
             * Get list of cart items
             * @returns {*}
             */
            getItems: function(){
                return this.items();
            },
            /**
             * Get cart item object, return false if it is new item
             * @param data
             * @returns {*}
             */
            getAddedItem: function(data){
                var isNew = false;
                if(typeof data.item_id != "undefined"){
                    var foundItem = ko.utils.arrayFirst(this.items(), function(item) {
                        return (item.item_id() == data.item_id);
                    });
                    if(foundItem){
                        return foundItem;
                    }
                }else{
                    var foundItem = ko.utils.arrayFirst(this.items(), function(item) {
                        return (item.product_id() == data.product_id);
                    });
                    if(foundItem){
                        return foundItem;
                    }
                }
                return isNew;
            },
            /**
             * Add product to cart
             * @param data
             */
            addItem: function(data){
                var item = this.getAddedItem(data);
                if(item === false){
                    data.item_id = (data.item_id)?data.item_id:$.now();
                    data.qty = (data.qty)?data.qty:1;
                    var item = new Item();
                    item.init(data);
                    this.items.push(item);
                }else{
                    var qty = item.qty();
                    qty += data.qty;
                    this.setItemData(item.item_id(), "qty", qty);
                }
            },
            /**
             * Get cart item by item id
             * @param itemId
             * @returns {boolean}
             */
            getItem: function(itemId){
                var item = false;
                var foundItem = ko.utils.arrayFirst(this.items(), function(item) {
                    return (item.item_id() == itemId);
                });
                if(foundItem){
                    item = foundItem;
                }
                return item;
            },
            /**
             * Get data of item
             * @param itemId
             * @param key
             * @returns {*}
             */
            getItemData: function(itemId, key){
                var item = this.getItem(itemId);
                if(item != false && typeof item[key] != "undefined"){
                    return item[key]();
                }
                return "";
            },
            /**
             * Set data for cart item
             * @param itemId
             * @param key
             * @param value
             */
            setItemData: function(itemId, key, value){
                var item = this.getItem(itemId);
                if(item != false){
                    item.setData(key,value);
                }
            },
            /**
             * Remove item by id
             * @param itemId
             */
            removeItem: function(itemId){
                this.items.remove(function (item) {
                    return item.item_id() == itemId;
                });
            },
            /**
             * Calculate total items qty
             * @returns {number}
             */
            totalItems: function(){
                var total = 0;
                if(this.items().length > 0){
                    ko.utils.arrayForEach(this.items(), function(item) {
                        total += parseFloat(item.qty());
                    });
                }
                return total;
            },
            /**
             * Binding data from api response
             * @param quoteItems
             */
            updateItemsFromQuote: function(quoteItems){
                if(quoteItems){
                    var self = this;
                    $.each(quoteItems, function(index, itemData){
                        if(itemData.offline_item_id){
                            var itemId = itemData.item_id;
                            var unitPrice = (itemData.base_original_price)?itemData.base_original_price:itemData.base_price;
                            var elementItemId = (itemData.offline_item_id == itemId)?itemId:itemData.offline_item_id;
                            var data = {};
                            data.item_id = elementItemId;
                            data.unit_price = parseFloat(unitPrice);
                            data.name = itemData.name;
                            data.qty = parseFloat(itemData.qty);
                            console.log(data.qty);
                            data.saved_item = true;
                            var added = self.getAddedItem({item_id: itemData.offline_item_id}) || self.getAddedItem({item_id: itemId});
                            if(added === false){
                                data.item_id = itemId;
                                self.addItem(data);
                            }else{
                                data.item_id = itemId;
                                self.setItemData(elementItemId, data);
                                self.setItemData(itemId, data);
                            }
                        }
                    });
                }
            }
        }
        return Items.initialize();
    }
);
