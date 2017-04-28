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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA;
 *
 *
 */
use oat\itemqtiCreator\controller\QtiCreator;
use oat\itemqtiCreator\controller\QtiPreview;

return array(
    'name' => 'itemqtiCreator',
    'label' => 'QTI Item Creator',
    'description' => 'Editor for QTI items',
    'license' => 'GPL-2.0',
    'version' => '2.0.0',
	'author' => 'Open Assessment Technologies SA',
	'requires' => array(
        'taoQtiItem' => '>=2.27.0',
        'taoLti' => '>=1.3.0'
    ),
    'managementRole' => 'http://www.tao.lu/Ontologies/generis.rdf#itemqtiCreatorManager',
    'acl' => array(
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#itemqtiCreatorManager', array('ext'=>'itemqtiCreator')),
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#AnonymousRole', array('act' => 'oat\itemqtiCreator\controller\AuthorTool@launch')),
        array('grant', 'http://www.imsglobal.org/imspurl/lis/v1/vocab/membership#ContentDeveloper', array('act' => 'oat\itemqtiCreator\controller\AuthorTool@run')),
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#AnonymousRole', array('act' => 'oat\itemqtiCreator\controller\PreviewTool@launch')),
        array('grant', 'http://www.imsglobal.org/imspurl/lis/v1/vocab/membership#ContentDeveloper', array('act' => 'oat\itemqtiCreator\controller\PreviewTool@run')),
        array('grant', 'http://www.imsglobal.org/imspurl/lis/v1/vocab/membership#ContentDeveloper', array('controller'=> QtiCreator::class))
    ),
    'install' => array(
        'rdf' => array(
            __DIR__.'/install/role.rdf'
        )
    ),

    'update' => 'oat\\itemqtiCreator\\scripts\\update\\Updater',
    'uninstall' => array(
    ),
    'routes' => array(
        '/itemqtiCreator' => 'oat\\itemqtiCreator\\controller'
    ),
    'constants' => array(
        # views directory
        "DIR_VIEWS" => dirname(__FILE__).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR,

        #BASE URL (usually the domain root)
        'BASE_URL' => ROOT_URL.'itemqtiCreator/',
    )
);
