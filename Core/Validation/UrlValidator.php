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

require_once dirname( __FILE__ ) . '/AbstractValidator.php';

class UrlValidator extends AbstractValidator
{
    public function __construct( &$value )
    {
        $this->setValue($value);
    }
    
    /**
     * @return boolean
     */
    public function isValid()
    {
        if( filter_var($this->getValue(), FILTER_VALIDATE_URL)===false )
        {
            return false;
        }
        
        return true;
    }
}