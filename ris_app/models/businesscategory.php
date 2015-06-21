<?php
class Businesscategory extends DataMapper
{
	public $has_many = array('lead', 'company');
    
    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
