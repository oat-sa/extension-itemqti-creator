/**
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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA ;
 */


/**
 * This plugin add a "save & close" button, that does that.
 * The close means either going back to a configured returnUrl (from config.properties.returnUrl)
 * or close the window.
 *
 * @author Bertrand Chevrier <bertrand@taotesting.com>
 */
define([
    'jquery',
    'lodash',
    'i18n',
    'core/plugin',
    'ui/hider',
    'tpl!taoQtiItem/qtiCreator/plugins/button'
], function($, _, __, pluginFactory, hider, buttonTpl){
    'use strict';

    /**
     * Returns the configured plugin
     * @returns {Function} the plugin
     */
    return pluginFactory({

        name : 'saveAndClose',

        /**
         * Initialize the plugin (called during host's init)
         */
        init : function init(){
            var self = this;
            var itemCreator = this.getHost();
            var config      = itemCreator.getConfig();

            //create the button
            this.$element = $(buttonTpl({
                icon: 'save',
                title: __('Save and close the creator'),
                text : __('Save & Close'),
                cssClass: ''
            })).on('click', function saveHandler(e){
                e.preventDefault();
                self.disable();


                itemCreator
                  .on('saved.closing', function(){
                    itemCreator.off('saved.closing');

                    //either move to the return URL or close the window. (delay for better visual feedback)
                    if(config && config.properties && _.isString(config.properties.returnUrl)){
                        _.delay(function(){
                            window.location = config.properties.returnUrl;
                        }, 300);
                    } else {
                        _.delay(function(){
                            self.enable(); //close might fail
                            window.close();
                        }, 300);
                    }
                  })
                  .trigger('save');
            });

            this.hide();
        },

        /**
         * Hook to the host's render
         */
        render : function render(){

            //attach the element to the menu area
            var $container = this.getAreaBroker().getMenuArea();
            $container.append(this.$element);
            //this.disable();
            this.show();

        },

        /**
         * Hook to the host's destroy
         */
        destroy : function destroy (){
            this.$element.remove();
        },

        /**
         * Enable the button
         */
        enable : function enable (){
            this.$element.removeProp('disabled')
                         .removeClass('disabled');
        },

        /**
         * Disable the button
         */
        disable : function disable (){
            this.$element.prop('disabled', true)
                         .addClass('disabled');
        },

        /**
         * Show the button
         */
        show: function show(){
            hider.show(this.$element);
        },

        /**
         * Hide the button
         */
        hide: function hide(){
            hider.hide(this.$element);
        }
    });
});

