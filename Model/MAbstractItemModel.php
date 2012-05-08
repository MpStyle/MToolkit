<?php
require_once 'MToolkit/MModelIndex.php';

abstract class MAbstractItemModel
{
    abstract function rowCount();
    abstract function columnCount();
    abstract function data( MModelIndex $index );
}

