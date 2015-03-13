<?php
class Student extends DataMapper {

	public $has_many = array('studentfee');
    public $has_one = array('batch');
    
    // Optionally, don't include a constructor if you don't need one.
    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
