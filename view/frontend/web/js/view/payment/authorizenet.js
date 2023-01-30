define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component, rendererList) {
        'use strict';

        rendererList.push({
            type: 'silin_authorizenet',
            component: 'Silin_Authorizenet/js/view/payment/method-renderer/cc-form'
        });

        return Component.extend({});
    }

);
