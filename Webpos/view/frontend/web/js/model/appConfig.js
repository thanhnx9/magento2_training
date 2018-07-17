define(
    [],
    function () {
        "use strict";

        return {
            MAIN_CONTAINER:'#checkout_container',
            ELEMENT_SELECTOR:{
                COL_LEFT:".col-left",
                MENU:"#c-menu--push-left",
                SHOW_MENU_BUTTON:".show-menu-button",
                MENU_MASK:"#c-mask",
                WRAPPER:"#o-wrapper",
                ACTIVE_CONTAINER:".pos_container.active",
                CHECKOUT_SECTION:'#webpos_checkout'
            },
            CLASS:{
                ACTIVE:"active",
                POS_CONTAINER:"pos_container",
                HAS_ACTIVE_MENU:"has-active-menu",
                MENU_ACTIVE:"is-active",
                WRAPPER_MENU_ACTIVE:"has-push-left",
                SHOW_MENU:"showMenu",
                HIDE:"hide",
                SHOW:"show"
            },
            EVENT:{
                SHOW_CONTAINER_AFTER:'show_container_after',
                DATA_MANAGER_SET_DATA_AFTER:'data_manager_set_data_after'
            }
        };
    }
);
