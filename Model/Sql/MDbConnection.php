<?php
class MDbConnection
{
    private $connection=null;
    private static $istance=null;

    private function  __construct()
    {
        $this->connection=array();
    }

    public static function dbConnection( /* string */ $name="DefaultConnection" )
    {
        if( is_null( MDbConnection::$istance ) )
            return null;

        return MDbConnection::$istance->connection[$name];
    }

    public static function addDbConnection( /* mixed */ $connection
                                          , /* string */ $name="DefaultConnection" )
    {
        if( is_null( MDbConnection::$istance ) )
            MDbConnection::$istance=new MDbConnection();

        MDbConnection::$istance->connection[$name]=$connection;
    }

    public static function removeDbConnection( /* string */ $name="DefaultConnection" )
    {
        if( is_null( MDbConnection::$istance ) )
            return;

        MDbConnection::$istance->connection[$name]=null;
    }
}

