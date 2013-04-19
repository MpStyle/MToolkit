<?php
namespace MToolkit\Core\Enum;

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

/**
 * This enum type defines what happens to the aspect ratio when scaling an rectangle.
 */
final class AspectRatioMode
{
    // The size is scaled freely. The aspect ratio is not preserved.
    const IGNORE_ASPECT_RATIO=	0;	
    
    // The size is scaled to a rectangle as large as possible inside a given rectangle, 
    // preserving the aspect ratio.
    const KEEP_ASPECT_RATIO=	1;	
    
    // The size is scaled to a rectangle as small as possible outside a given rectangle, 
    // preserving the aspect ratio.    
    const KEEP_ASPECT_RATIO_BY_EXPANDING=	2;	
}

