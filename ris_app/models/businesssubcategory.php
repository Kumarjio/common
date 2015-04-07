<?php
class Businesssubcategory extends DataMapper
{
    public $has_many = array('lead');

    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
