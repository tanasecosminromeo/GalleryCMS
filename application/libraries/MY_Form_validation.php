<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	
function __construct()
		{
		     log_message('debug', "MY_FORM_VALIDATION Extension Initialized");
		   
		    parent::__construct();
		}  
			
	 function run($module = '', $group = '') {
	 (is_object($module)) AND $this->CI =& $module;
	 return parent::run($group);
	 }


	// --------------------------------------------------------------------



	/**
	 * * Adds one validation rule, "unique" and accepts a
 	* parameter, the name of the table and column that
 	* you are checking, specified in the forum table.column
 	*
 	* Note that this update should be used with the
 	* form_validation library introduced in CI 1.7.0
 	* http://www.scottnelle.com/41/extending-codeigniters-validation-library/
	 * Unique
	 *
	 * @access	public
	 * @param	string
	 * @param	field
	 * @return	bool
	 */
	function unique($str, $field)
	{
		$CI =& get_instance();
		list($table, $column) = explode('.', $field, 2);

		$CI->form_validation->set_message('unique', 'The %s that you requested is unavailable.');

		$query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
		$row = $query->row();
		return ($row->dupe > 0) ? FALSE : TRUE;
	}


    /**
    * Overwrites CI's native validation set_select method to work
    * with arrays.
    *
    * @access   public
    * @param    string
    * @param    string
    * @return   string
    * @author   r.vadivelan / hivelan [.at.] gmail [.dot.] com
    * @link     http://codeigniter.com/forums/viewthread/73012/
    */
    public function set_select($field = '', $value = '')
    {
        if ($field == '' OR $value == '' OR  ! isset($_POST[$field]))
        {
            return '';
        }

        if(is_array($_POST[$field])) {
            if(in_array($value,$_POST[$field])) {
                return ' selected="selected"';
            }
        } elseif ($_POST[$field] == $value) {
            return ' selected="selected"';
        }

    }

    // --------------------------------------------------------------------


    /**
    * Overwrites CI's native validation set_checkbox method to work
    * with arrays.
    *
    * @access   public
    * @param    string
    * @param    string
    * @return   string
    * @author   r.vadivelan / hivelan [.at.] gmail [.dot.] com
    * @link     http://codeigniter.com/forums/viewthread/73012/
    */
    public function set_checkbox($field = '', $value = '')
    {
        if ($field == '' OR $value == '' OR  ! isset($_POST[$field]))
        {
            return '';
        }

        if(is_array($_POST[$field])) {
            if(in_array($value,$_POST[$field])) {
                return ' checked="checked"';
            }
        } elseif ($_POST[$field] == $value) {
            return ' checked="checked"';
        }
    }

    // --------------------------------------------------------------------


    /**
    * Overwrites CI's native validation prep_for_form method to work
    * with arrays. Takes a string or an array and returns the same.
    *
    * @access   public
    * @param    mixed
    * @return   mixed
    * @author   r.vadivelan / hivelan [.at.] gmail [.dot.] com
    * @link     http://codeigniter.com/forums/viewthread/73012/
    */
    public function prep_for_form($data = '')
    {
        if (is_array($data))
        {
            foreach ($data as $key => $val)
            {
                $data[$key] = $this->prep_for_form($val);
            }
        }

        if ($this->_safe_form_data == FALSE OR $data == '')
        {
            return $data;
        }

        if(is_array($data)) {
            return $data;
        } else {
            return str_replace(array("'", '"', '<', '>'), array("&#39;", "&quot;", '<', '>'), stripslashes($data));
        }
    }

    // --------------------------------------------------------------------


    /**
     * native php function caller
     *
     * This function calls native php functions for each values submitted from the form
     *
     * @access  public
     * @param   string
     * @return  string
     * @author  r.vadivelan / hivelan [.at.] gmail [.dot.] com
     * @link    http://codeigniter.com/forums/viewthread/73012/
     */
    public function php_func_caller($rule, $data = '')
    {
        if (is_array($data))
        {
            foreach ($data as $key => $val)
            {
                $data[$key] = $this->php_func_caller($rule,$val);
            }
        }

        if ($data == '')
        {
            return $data;
        }

        if(is_array($data)) {
            return $data;
        } else {
            return $rule($data);
        }
    }

    // --------------------------------------------------------------------
	



}// end of my_form_validation class

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */  