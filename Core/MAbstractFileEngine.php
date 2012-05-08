<?php

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
 * along with Nome-Programma.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author  Michele Pagnin
 * @version 0.01
 */

class MAbstractFileEngine
{
    private $fileName=null;
   
    /*
bool	atEnd () const
virtual Iterator *	beginEntryList ( QDir::Filters filters, const QStringList & filterNames )
virtual bool	caseSensitive () const
virtual bool	close ()
virtual bool	copy ( const QString & newName )
virtual QStringList	entryList ( QDir::Filters filters, const QStringList & filterNames ) const
QFile::FileError	error () const
QString	errorString () const
virtual bool	extension ( Extension extension, const ExtensionOption * option = 0, ExtensionReturn * output = 0 )
virtual FileFlags	fileFlags ( FileFlags type = FileInfoAll ) const
virtual QString	fileName ( FileName file = DefaultName ) const
virtual QDateTime	fileTime ( FileTime time ) const
virtual bool	flush ()
virtual int	handle () const
virtual bool	isRelativePath () const
virtual bool	isSequential () const
virtual bool	link ( const QString & newName )
uchar *	map ( qint64 offset, qint64 size, QFile::MemoryMapFlags flags )
virtual bool	mkdir ( const QString & dirName, bool createParentDirectories ) const
virtual bool	open ( QIODevice::OpenMode mode )
virtual QString	owner ( FileOwner owner ) const
virtual uint	ownerId ( FileOwner owner ) const
virtual qint64	pos () const
virtual qint64	read ( char * data, qint64 maxlen )
virtual qint64	readLine ( char * data, qint64 maxlen )
virtual bool	remove ()*/
    public function /* bool */ rename ( $newName )
    {
        return rename( $this->fileName, $newName );
    }
    /*
virtual bool	rmdir ( const QString & dirName, bool recurseParentDirectories ) const
virtual bool	seek ( qint64 offset )
     */
    public function setFileName ( $file )
    {
        if( is_string($file)==false )
        {
            throw new MWrongTypeException( "\$fileName", "string", gettype($file) );
        }
        
        $this->fileName=$file;
    }
     /*
virtual bool	setPermissions ( uint perms )
virtual bool	setSize ( qint64 size )
virtual qint64	size () const
virtual bool	supportsExtension ( Extension extension ) const
bool	unmap ( uchar * address )
virtual qint64	write ( const char * data, qint64 len )
    */
        
     
    public static function /* MAbstractFileEngine */ create( /* string */ $fileName )
    {
        if( is_string($fileName)==false )
        {
            throw new MWrongTypeException( "\$fileName", "string", gettype($fileName) );
        }
        
        $fileHandle = fopen($fileName, 'w');
        
        if( $fileHandle===false )
        {
            return null;
        }
        
        fclose($fileHandle);
        
        $return=new MAbstractFileEngine();
        $return->setFileName( $fileName );
        
        return $return;
    }
            
    // protected
    /*
    QAbstractFileEngine ()
    void	setError ( QFile::FileError error, const QString & errorString )
     */
}

