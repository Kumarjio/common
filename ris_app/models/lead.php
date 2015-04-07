<?php
class Lead extends DataMapper
{
    public $has_one = array('country', 'state', 'city', 'businesscategory', 'businesssubcategory');

    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
