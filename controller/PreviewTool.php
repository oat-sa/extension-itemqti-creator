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

use common_exception_Error;
use core_kernel_classes_Resource;
use oat\taoLti\controller\ToolModule;
use oat\taoLti\models\classes\LtiLaunchData;
use oat\taoLti\models\classes\LtiService;
use tao_helpers_Request;
use tao_helpers_Uri;

/**
 * LTI tool to review qti items
 */
class PreviewTool extends ToolModule
{
    /**
     * (non-PHPdoc)
     * @see ToolModule::run()
     * @requiresRight id READ
     * @return void
     * @throws \InterruptedActionException
     * @throws \ResolverException
     * @throws \common_exception_IsAjaxAction
     * @throws \oat\taoLti\models\classes\LtiException
     * @throws \oat\taoLti\models\classes\LtiVariableMissingException
     * @throws common_exception_Error
     */
    public function run()
    {
        if (!$this->hasRequestParameter('id')) {
            return $this->returnError(__('No item has been specified'));
        }
        if (tao_helpers_Request::isAjax()) {
            throw new common_exception_Error("Wrong request mode, this is a plain document.");
        }

        $item = new core_kernel_classes_Resource(tao_helpers_Uri::decode($this->getRequestParameter('id')));
        if (!$item->exists()) {
            throw new common_exception_Error('We\'re unable to find the item ' . $item->getUri());
        }

        $this->setData('client_config_url', $this->getClientConfigUrl());

        $this->setData(
            'previewUrl',
            \tao_helpers_Uri::url(
                'index',
                'QtiPreview',
                'taoQtiItem',
                array('uri' => $item->getUri(), 'lang' => DEFAULT_LANG)
            )
        );

        //retrieve the return URL from the LTI session
        $launchData = LtiService::singleton()->getLtiSession()->getLaunchData();
        if ($launchData->hasVariable(LtiLaunchData::LAUNCH_PRESENTATION_RETURN_URL)) {
            $this->setData('returnUrl', $launchData->getVariable(LtiLaunchData::LAUNCH_PRESENTATION_RETURN_URL));
        }

        $this->setData('content-template', array('QtiPreview/index.tpl', 'itemqtiCreator'));

        $this->setView('layout.tpl', 'itemqtiCreator');
    }
}
