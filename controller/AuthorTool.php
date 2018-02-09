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

use oat\taoLti\controller\ToolModule;
use oat\taoLti\models\classes\LtiLaunchData;
use oat\taoLti\models\classes\LtiService;
use tao_models_classes_accessControl_AclProxy;

/**
 * LTI tool to author items using the QtiCreator
 */
class AuthorTool extends ToolModule
{
    /**
     * (non-PHPdoc)
     * @see ToolModule::run()
     * @return void
     * @throws \InterruptedActionException
     * @throws \ResolverException
     * @throws \common_exception_Error
     * @throws \common_exception_IsAjaxAction
     * @throws \oat\taoLti\models\classes\LtiException
     * @throws \oat\taoLti\models\classes\LtiVariableMissingException
     */
    public function run()
    {
        if (!$this->hasRequestParameter('id')) {
            return $this->returnError(__('No item has been specified'));
        } elseif (tao_models_classes_accessControl_AclProxy::hasAccess('index', 'QtiCreator','itemqtiCreator', array('id' => $this->getRequestParameter('id')))) {

            $parameters = array('id' => $this->getRequestParameter('id'));

            //retrieve the return URL from the LTI session
            $launchData = LtiService::singleton()->getLtiSession()->getLaunchData();
            if ($launchData->hasVariable(LtiLaunchData::LAUNCH_PRESENTATION_RETURN_URL)) {
                $parameters['returnUrl'] = $launchData->getVariable(LtiLaunchData::LAUNCH_PRESENTATION_RETURN_URL);
            }

            // user authorised to author the item
            $this->forward('index', 'QtiCreator', null, $parameters);
        } else {
            // user NOT authorised to select the Delivery
            $this->returnError(__('You are not authorized to author this item'), false);
        }
    }
}
