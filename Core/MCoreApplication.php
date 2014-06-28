<?php

namespace MToolkit\Core;

/*
 * This file is part of MToolkit.
 *
 * MToolkit is free software: you can redistribute it and/or modify
 * it under the terms of the LGNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * MToolkit is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * LGNU Lesser General Public License for more details.
 *
 * You should have received a copy of the LGNU Lesser General Public License
 * along with MToolkit.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 */

require_once __DIR__ . '/../Network/MNetworkSession.php';
require_once __DIR__ . '/MCore.php';

use MToolkit\Network\MNetworkSession;

/**
 * The MCoreApplication class provides an event loop for console MToolkit 
 * applications.<br />
 * This class is used by non-GUI applications to provide their event loop. For 
 * non-GUI application that uses MToolkit, there should be exactly one 
 * MCoreApplication object. For GUI applications, see MApplication.
 */
class MCoreApplication
{
    const APPLICATION_NAME='MToolkit\Core\MCoreApplication\ApplicationName';
    const APPLICATION_VERSION='MToolkit\Core\MCoreApplication\ApplicationVersion';
    const ORGANIZATION_DOMAIN='MToolkit\Core\MCoreApplication\OrganizationDomain';
    const ORGANIZATION_NAME='MToolkit\Core\MCoreApplication\OrganizationName';
    const APPLICATION_DIR_PATH = "MToolkit\Core\MCoreApplication\ApplicationDirPath";
    const DEBUG = "MToolkit\Core\MObject\Debug";
    
    /**
     * Set the debug mode.
     * 
     * @param string $path
     */
    public static function setDebug( $bool )
    {
        MNetworkSession::set( MCoreApplication::DEBUG, $bool );
    }

    /**
     * Return if the debug mode is actived.
     * 
     * @return string|null
     */
    public static function getDebug()
    {
        $debug = MNetworkSession::get( MCoreApplication::DEBUG );

        if ($debug === null)
        {
            return false;
        }

        return $debug;
    }
    
    /**
     * Set the root path of the project.
     * 
     * @param string|array $path
     */
    public static function setApplicationDirPath( $path )
    {
        $paths=array_merge(array(), (array)$path );
        MNetworkSession::set( MCoreApplication::APPLICATION_DIR_PATH, $paths );
    }

    /**
     * Return the root path of the project.
     * 
     * @return array|null
     */
    public static function getApplicationDirPath()
    {
        $rootPath = MNetworkSession::get( MCoreApplication::APPLICATION_DIR_PATH );
        return $rootPath;
    }
    
    /**
     * This property holds the name of this application.<br />
     * The value is used by the MSettings class when it is constructed using the 
     * empty constructor. This saves having to repeat this information each time 
     * a MSettings object is created.
     * 
     * @return string|null
     */
    public static function getApplicationName()
    {
        return MNetworkSession::get(MCoreApplication::APPLICATION_NAME);
    }
    
    /**
     * This property holds the version of this application.
     * 
     * @return string|null
     */
    public static function getApplicationVersion()
    {
        return MNetworkSession::get(MCoreApplication::APPLICATION_VERSION);
    }
    
    /**
     * This property holds the Internet domain of the organization that wrote 
     * this application.<br />
     * The value is used by the MSettings class when it is constructed using the 
     * empty constructor. This saves having to repeat this information each time 
     * a MSettings object is created.
     * 
     * @return string
     */
    public static function getOrganizationDomain()
    {
        return MNetworkSession::get(MCoreApplication::ORGANIZATION_DOMAIN);
    }
    
    /**
     * This property holds the name of the organization that wrote this 
     * application.<br />
     * The value is used by the MSettings class when it is constructed using the 
     * empty constructor. This saves having to repeat this information each time 
     * a MSettings object is created.
     * 
     * @return string
     */
    public static function getOrganizationName()
    {
        return MNetworkSession::get(MCoreApplication::ORGANIZATION_NAME);
    }
    
    /**
     * This property holds the name of this application.<br />
     * The value is used by the MSettings class when it is constructed using the 
     * empty constructor. This saves having to repeat this information each time 
     * a MSettings object is created.
     * 
     * @param string $application
     */
    public static function setApplicationName ( $application )
    {
        MNetworkSession::set(MCoreApplication::APPLICATION_NAME, $application);
    }
    
    /**
     * This property holds the version of this application.
     * 
     * @param string $version
     */
    public static function setApplicationVersion ( $version )
    {
        MNetworkSession::set(MCoreApplication::APPLICATION_VERSION, $version);
    }
    
    /**
     * This property holds the Internet domain of the organization that wrote 
     * this application.<br />
     * The value is used by the MSettings class when it is constructed using the 
     * empty constructor. This saves having to repeat this information each time 
     * a MSettings object is created.
     * 
     * @param string $orgDomain
     */
    public static function setOrganizationDomain ( $orgDomain )
    {
        MNetworkSession::set(MCoreApplication::ORGANIZATION_DOMAIN, $orgDomain);
    }
    
    /**
     * This property holds the name of the organization that wrote this 
     * application.<br />
     * The value is used by the MSettings class when it is constructed using the 
     * empty constructor. This saves having to repeat this information each time 
     * a MSettings object is created.
     * 
     * @param string $orgName
     */
    public static function setOrganizationName ( $orgName )
    {
        MNetworkSession::set(MCoreApplication::ORGANIZATION_NAME, $orgName);
    }
}
