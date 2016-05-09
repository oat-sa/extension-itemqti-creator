<?php
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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 *
 */

namespace oat\itemqtiCreator\controller;

use taoLti_actions_ToolModule;
use tao_models_classes_accessControl_AclProxy;
use tao_helpers_Uri;
/**
 * LTI tool to author items using the QtiCreator 
 */
class AuthorTool extends taoLti_actions_ToolModule
{
    /**
     * (non-PHPdoc)
     * @see taoLti_actions_ToolModule::run()
     */
    public function run()
    {
        if (!$this->hasRequestParameter('id')) {
            return $this->returnError(__('No item has been specified'));
        } elseif (tao_models_classes_accessControl_AclProxy::hasAccess('index', 'QtiCreator','itemqtiCreator', array('id' => $this->getRequestParameter('id')))) {
            // user authorised to author the item
            $this->forward('index', 'QtiCreator', null, array('id' => $this->getRequestParameter('id')));
        } else {
            // user NOT authorised to select the Delivery
            $this->returnError(__('You are not authorized to author this item'), false);
        }
    }
}