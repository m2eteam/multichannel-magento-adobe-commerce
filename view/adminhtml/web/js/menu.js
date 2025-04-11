define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';

    return function (config) {
        const menuConfigs = config.menuConfigs || [];

        menuConfigs.forEach((menuItem) => {
            const itemId = menuItem.itemId;
            const $maintenanceItem = $(`${itemId}-maintenance`);
            const $menuItem = $(itemId);
            const $targetContainer = $(menuItem.containerSelector);

            if (!$targetContainer.length) {
                $menuItem.show();

                return;
            }

            if (hasSubmenu($menuItem)) {
                handleSubmenu($menuItem, $targetContainer);
            } else {
                handleMenuLinkReplacement($maintenanceItem, $menuItem, $targetContainer);
            }
        });
    };

    function hasSubmenu($menuItem) {
        return $menuItem.find('.submenu').length > 0;
    }

    function handleSubmenu($menuItem, $targetContainer) {
        handleOutsideClick($targetContainer);

        if (!$menuItem.parent().is($targetContainer)) {
            $menuItem.appendTo($targetContainer);
        }

        $targetContainer.on('click', '> a', function (event) {
            event.preventDefault();
            $targetContainer.parent('ul').find('li._show').removeClass('_show');
            $menuItem.find('> a').trigger('click');
        });
    }

    function handleMenuLinkReplacement($maintenanceItem, $menuItem, $targetContainer) {
        if ($maintenanceItem.length) {
            replaceMenuItemLink($maintenanceItem, $targetContainer);
        } else if ($menuItem.length) {
            replaceMenuItemLink($menuItem, $targetContainer);
        }
    }

    function handleOutsideClick($targetContainer) {
        $(document).on('click', function (event) {
            if (!$targetContainer.is(event.target) && !$targetContainer.has(event.target).length) {
                $targetContainer.find('li._show').removeClass('_show');
            }
        });
    }

    function replaceMenuItemLink($menuItem, $targetContainer) {
        if ($targetContainer.length) {
            const $link = $menuItem.find('> a');
            if ($link.length) {
                $targetContainer.find('> a').attr('href', $link.attr('href'));
            }
            $menuItem.remove();
        }
    }
});
