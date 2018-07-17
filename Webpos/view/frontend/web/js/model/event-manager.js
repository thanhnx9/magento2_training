define(
    [
        'jquery'
    ],
    function ($) {
        "use strict";

        return {
            dispatch: function (eventName, data) {
                $("body").trigger(eventName, data);
            },
            observer: function (eventName, callback) {
                $("body").on(eventName, callback);
            }
        };
    }
);
