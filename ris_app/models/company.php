<?php
class Company extends DataMapper
{
 
 	public $table = 'companies';
 	public $has_one = array( 'country', 'state', 'city', 'businesscategory', 'businesssubcategory');

    // Optionally, don't include a constructor if you don't need one.
    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
