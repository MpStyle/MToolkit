<?php

namespace MToolkit\DebugConsole\Languages;

/*
 * Copyright (C) 2014 michele_pagnin.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

use MToolkit\Core\MTranslator;
use MToolkit\Core\MTranslatorFileType;
use MToolkit\Network\MNetworkSession;

class Languages
{
    const IT_IT = 'it-it';
    const EN_EN = 'en-en';
    const CURRENT_LANGUAGE = "MToolkit\DebugConsole\Languages\CurrentLanguage";
    const DEFAULT_LANG = self::EN_EN;

    /**
     * @var MTranslator 
     */
    private static $translator;

    private static function getTranslator()
    {
        if( Languages::$translator == null )
        {
            Languages::$translator = new MTranslator();

            Languages::$translator->addTranslationFile( __DIR__ . "/en-en.json", self::EN_EN, MTranslatorFileType::JSON );
        }

        return Languages::$translator;
    }

    /**
     * @param string $language
     */
    public static function setCurrentLanguage( $language )
    {
        MNetworkSession::set( self::CURRENT_LANGUAGE, $language );
    }

    public static function getCurrentLanguage()
    {
        $currenLanguage = MNetworkSession::get( self::CURRENT_LANGUAGE );

        if( $currenLanguage == null )
        {
            $currenLanguage = Languages::DEFAULT_LANG;
        }

        return $currenLanguage;
    }

    public static function getAvailableLanguages()
    {
        return array(self::EN_EN/*, self::IT_IT*/);
    }

    /**
     * @param string $key
     * @return string
     */
    public static function getString( $key )
    {
        $value = Languages::getTranslator()->translate( self::getCurrentLanguage(), $key );

        if( $value == null )
        {
            $value = Languages::getTranslator()->translate( Languages::DEFAULT_LANG, $key );
        }

        return $value;
    }

}
