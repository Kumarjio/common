<?php
class Batch extends DataMapper {

	public $has_many = array('student');
    
    // Optionally, don't include a constructor if you don't need one.
    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
