define(
    [
        'uiComponent'
    ],
    function (Component) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Magestore_Webpos/menu/group'
            },
            hasChilds: function(){
                return (this.elems().length > 0)?true:false;
            }
        });
    }
);