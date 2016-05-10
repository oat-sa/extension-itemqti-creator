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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA
 *
 *
 */

namespace oat\itemqtiCreator\controller;

use common_exception_Error;
use core_kernel_classes_Resource;
use tao_helpers_Request;
use tao_helpers_Uri;

/**
 * Provides a standalone entry point for the item preview
 *
 * @author Bertrand Chevrier <bertrand@taotesting.com>
 */
class QtiPreview extends \tao_actions_CommonModule
{

    /**
     * Let's you open the preview of an item from the following URL :
     * itemqtiCreator/QtiPreview/index?id=encoded_item_uri
     */
    public function index()
    {
        if(tao_helpers_Request::isAjax()){
            throw new common_exception_Error("Wrong request mode, this is a plain document.");
        }

        if (!$this->hasRequestParameter('id')) {
            throw new common_exception_Error('The item creator needs to be opened with an item, using the "id" parameter');
        }

        $item = new core_kernel_classes_Resource(tao_helpers_Uri::decode($this->getRequestParameter('id')));
        if (!$item->exists()) {
            throw new common_exception_Error('We\'re unable to find the item '.$item->getUri());
        }

        $this->setData('client_config_url', $this->getClientConfigUrl());

        $this->setData('previewUrl', \tao_helpers_Uri::url('index', 'QtiPreview', 'taoQtiItem', array('uri' => $item->getUri(), 'lang' => DEFAULT_LANG)));
        $this->setData('content-template', array('QtiPreview/index.tpl', 'itemqtiCreator'));

        $this->setView('layout.tpl', 'itemqtiCreator');
    }
}
