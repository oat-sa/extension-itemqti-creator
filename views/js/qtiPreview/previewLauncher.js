/*
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2016 (original work) Open Assessment Technlogies SA
 *
 */

/**
 * This wraps the launch of the preview
 *
 * @author Bertrand Chevrier <bertrand@taotesting.com>
 */
define([
    'jquery',
    'lodash',
    'module',
    'core/promise',
    'taoItems/preview/preview'
], function($, _, module, Promise, preview){
    'use strict';

    /**
     * Launch the preview of an item
     * @param {String} [previewUrl] - the configured preview URL (could be configured in the module's config as well)
     * @param {String} [returnUrl] - where to go on close URL (could be configured in the module's config as well)
     * @returns {Promise} resolve once the preview is shown
     */
    var previewLauncher = function previewLauncher(previewUrl, returnUrl){

        var config = module.config();

        previewUrl = previewUrl || config.previewUrl;
        returnUrl = config.returnUrl;

        if(_.isEmpty(previewUrl)){
            return Promise.reject(new TypeError('Unable to to run the preview without a launch URL'));
        }

        preview.init(config.previewUrl);
        return preview
            .show()
            .then(function(){
                //listen on the button once the preview is shown.
                //FIXME It's a fragile implementation that may break on GUI changes. This should be migrated to the plugin system.
                $('.preview-closer').on('click', function closeHandler(e){
                    if(!_.isEmpty(returnUrl)){
                        _.delay(function(){
                            window.location = returnUrl;
                        }, 300);
                    }
                });
            });
    };

    return previewLauncher;
});
