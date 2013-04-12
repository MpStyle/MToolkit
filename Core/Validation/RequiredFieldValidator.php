<?php


namespace Core\Validation;

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

require_once __DIR__ . '/AbstractValidator.php';

class RequiredFieldValidator extends AbstractValidator
{
    public function __construct( &$value )
    {
        $this->setValue($value);
    }
    
    /**
     * The field is valid if:
     * <ul>
     * <li>it is setted</li>
     * <li>it is not equal to null</li>
     * <li>it is not equal to empty string</li>
     * </ul>
     * 
     * @return boolean
     */
    public function isValid()
    {
        if( isset( $this->getValue() )===false )
        {
            return false;
        }
        
        if( $this->getValue()==null )
        {
            return false;
        }
        
        if( $this->getValue()=='' )
        {
            return false;
        }
        
        return true;
    }    
}
