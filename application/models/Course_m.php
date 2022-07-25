<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_m extends MY_Model{

	protected $table_name = 'tblcourse';
	protected $primary_key = "CourseId";
	protected $order_by = "CourseDesc";

	protected $timestamps = FALSE;
	protected $soft_delete = FALSE;

	protected $protected_attribute = array(
		'is_actived', 'created_at', 'updated_at', 'deleted_at'
	);

	/*public $rules = array(
		'CourseCode' => array('field' => 'CourseCode', 'label' => 'Course Code', 'rules' => 'trim|required|t|max_length[10]'),
        'CourseDesc' => array('field' => 'CourseDesc', 'label' => 'Course Description', 'rules' => 'trim|required|t|max_length[255]'),
        'Units' => array('field' => 'Units', 'label' => 'Units', 'rules' => 'trim|required|t|max_length[255]'),
        'LabUnits' => array('field' => 'LabUnits', 'label' => 'Lab Units', 'rules' => 'trim|required|t|max_length[255]'),
        'EquivalentCourse' => array('field' => 'EquivalentCourse', 'label' => 'Equivalent Course', 'rules' => 'trim|required|t|max_length[255]'),
	);*/

	/*public $options = array(
		'CourseCode' =>'Course Code',
		'CourseDesc' =>'Course Description',
		'Units' =>'Units',
	);*/

	// public function get_new();
	// {
	// 	$course = new stdClass();
	// 	$course->CourseCode = '';
	// 	$course->CourseDesc = '';

	// 	return $college;
	// }

	





}