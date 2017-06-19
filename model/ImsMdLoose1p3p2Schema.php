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
 */
namespace oat\taoLom\model;

interface ImsMdLoose1p3p2Schema
{
    /** Base details. */
    const PATH_NAMESPACE = 'http://ltsc.ieee.org/xsd/LOM';
    const PATH_SCHEMA    = 'https://standards.ieee.org/downloads/LOM/lomv1.0/xsd/lom.xsd';
//    const PATH_NAMESPACE = 'http://www.imsglobal.org/xsd/imsmd_v1p2';
    CONST FIELD_PREFIX   = 'lom';

    /** LOM structure url. */
    const PATH_LOM  = self::PATH_NAMESPACE . '#lom';

    /** General node. */
    const PATH_GENERAL            = self::PATH_NAMESPACE . '#general';
    const PATH_GENERAL_IDENTIFIER = self::PATH_NAMESPACE . '#identifier';
    const PATH_GENERAL_TITLE      = self::PATH_NAMESPACE . '#title';

    /** Value types. */
    const PATH_ENTRY      = self::PATH_NAMESPACE . '#entry';
    const PATH_STRING     = self::PATH_NAMESPACE . '#string';
}
