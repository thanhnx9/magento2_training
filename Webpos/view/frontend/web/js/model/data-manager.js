define(
    [
        'jquery',
        'ko',
        'Magestore_Webpos/js/model/event-manager',
        'Magestore_Webpos/js/model/appConfig'
    ],
    function ($, ko, Event, AppConfig) {
        "use strict";

        var DataManager = {
            /**
             * Data JSON
             */
            _data: ko.observable({}),
            /**
             * Available keys
             */
            _availableKeys: ko.observableArray([]),
            /**
             * Initialize
             * @returns {DataManager}
             */
            initialize: function(){
                var self = this;
                return self;
            },
            /**
             *
             * @param key
             * @returns {*}
             */
            getData: function(key){
                var self = this;
                var data = self._data();
                return (key)?data[key]:data;
            },
            /**
             * Set data
             * @param key
             * @param value
             */
            setData: function(key, value){
                var self = this;
                var data = self._data();
                if(typeof key == 'object'){
                    data = key;
                }else{
                    data[key] = value;
                }
                self._data(data);
                self._initAvailableDataKeys();
                Event.dispatch(AppConfig.EVENT.DATA_MANAGER_SET_DATA_AFTER, self.getData());
            },
            /**
             * Get all available data key
             * @returns {Array}
             */
            _initAvailableDataKeys: function(){
                var self = this;
                var data = self.getData();
                var keys = [];
                $.each(data, function(index){
                    keys.push(index);
                });
                self._availableKeys(keys);
            },
            /**
             * Get all available data key
             * @returns {Array}
             */
            getAvailableDataKeys: function(){
                var self = this;
                return self._availableKeys();
            }
        };
        return DataManager.initialize();
    }
);
