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

require_once __DIR__.'/MSession.php';

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
        MSession::set( MCoreApplication::DEBUG, $bool );
    }

    /**
     * Return if the debug mode is actived.
     * 
     * @return string|null
     */
    public static function getDebug()
    {
        $debug = MSession::get( MCoreApplication::DEBUG );

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
        MSession::set( MCoreApplication::APPLICATION_DIR_PATH, $path );
    }

    /**
     * Return the root path of the project.
     * 
     * @return string|null
     */
    public static function getApplicationDirPath()
    {
        $rootPath = MSession::get( MCoreApplication::APPLICATION_DIR_PATH );

        if ($rootPath == null)
        {
            return '.';
        }

        return $rootPath;
    }
    
    public static function getApplicationName()
    {
        return MSession::get(MCoreApplication::APPLICATION_NAME);
    }
    
    public static function getApplicationVersion()
    {
        return MSession::get(MCoreApplication::APPLICATION_VERSION);
    }
    
    public static function getOrganizationDomain()
    {
        return MSession::get(MCoreApplication::ORGANIZATION_DOMAIN);
    }
    
    public static function getOrganizationName()
    {
        return MSession::get(MCoreApplication::ORGANIZATION_NAME);
    }
    
    public static function setApplicationName ( $application )
    {
        MSession::set(MCoreApplication::APPLICATION_NAME, $application);
    }
    
    public static function setApplicationVersion ( $version )
    {
        MSession::set(MCoreApplication::APPLICATION_VERSION, $version);
    }
    
    public static function setOrganizationDomain ( $orgDomain )
    {
        MSession::set(MCoreApplication::ORGANIZATION_DOMAIN, $orgDomain);
    }
    
    public static function setOrganizationName ( $orgName )
    {
        MSession::set(MCoreApplication::ORGANIZATION_NAME, $orgName);
    }
}
