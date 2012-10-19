<?php 

////////////////////////
///// Instructions /////
////////////////////////
// Add and Remove Database Tables below in the $dbtables array
/* - Create New tables -
 * In helpers/db_tables folder add {tablename}_helper.php
 * Inside that file create the function called {tablename}_columns(){}
 * Create your array variable and return the variable back
 */

/* - Create or Edit Columns
 * Inside your array variable Add your columns
 * Keep them in the order you want for the database
  '{columnname}' => array(
  'type' => 'INT', // Insert Type
  'constraint' => 11, // Optional - Insert Constraint for types that need it
  'primary' => '1', // Optional - If primary 0 for no 1 for yes - default is 0
  'auto_increment' => TRUE, // Optional - If column needs to auto increment set to TRUE - id usually should be auto incremented
  'index' => '1', // Optional - If you would like to index this column set to 1
  'default' => '{defaultvalue}', // Optional - Insert default value
  'null' => false, Optional - default if false
  ),
 */

class Dbsync {
	//////////////
	// Settings //
	//////////////
    // Database information
    private $mysqli; // Connection variable
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'dbsync';

	// Settings variables
	public $set_path = 'dbtables'; // Location to settings files
	public $end_file_name = ''; // If needing to append text to file name
	public $end_var_name = '_columns'; // Appended text for var array name in individual table file 
    public $engine_type = 'InnoDB'; // Set engine type
    public $collation = 'utf8_bin'; // Set collation type

    /////////////////////
    // Class Variables //
    /////////////////////
    // Comparison arrays for before and after
    public $want_tables = array(); // What we want the db to be
    public $itis_tables = array(); // What is currently is
    public $final_action = array(); // Final list of actions that need to happen

    // Blank preset arrays
    public $blank_table = array(

    );
    public $blank_column = array(
		'type' => '',
		'constraint' => false,
		'primary' => false,
		'index' => false,
		'unique' => false,
		'auto_increment' => false,
		'null' => false
	);

    // Usable Variables
    public $num_adds = 0;
    public $num_changes = 0;
    public $num_deletes = 0;

    function __construct() {
        $this->db_connect();
    }

    ////////////////////////
    // Basic Db functions //
    ////////////////////////
    function db_connect() {
    	$this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->database);
		if ($this->mysqli->connect_error) {
		    die('Connect Error (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
		}
    }

    function db_close() {
    	$this->mysqli->close();
    }

    ////////////////////
    // Misc fucntions //
    ////////////////////
    function get_type_constraint($type) {
    	if (strpos($type, '(') !== false) {
    		$split = explode('(', $type);
    		$type = $split[0];
    		$constraint = str_replace(')', '', $split[1]);

		    return array('type' => $type, 'constraint' => $constraint);
		} else {
			return array('type' => $type, 'constraint' => false);
		}
    }

    /////////////////////////////////
    // Table compilation fucntions //
    /////////////////////////////////
    function compile_want_tables() {
    	// Start by empting want_tables array
    	$this->want_tables = array();

    	// Variables
    	$errors = array();

    	if (file_exists($this->set_path.'/_tables.php')) {
    		// Include primary tables file
		    include_once $this->set_path.'/_tables.php';

		    // Run through primary tables array
	    	foreach($_tables as $key => $value) {
	    		// Set variables
	    		$filename = $key.$this->end_file_name.'.php';

	    		// Add table and attributes to want table
	    		$this->want_tables[$key] = $value;
	    		$this->want_tables[$key]['columns'] = array();

	    		// Go get file for setting up table column items
	    		if (file_exists($this->set_path.'/'.$filename)) {
		    		// Set file modified date
		    		$this->want_tables[$key]['modified'] = date ("Y-m-d H:i:s", filemtime($this->set_path.'/'.$filename));

	    			include_once $this->set_path.'/'.$key.$this->end_file_name.'.php';
	    			if(isset(${$key.$this->end_var_name})){
	    				$columns = ${$key.$this->end_var_name};

	    				// Loop through setting and add to current table columns array
	    				foreach($columns as $c_key => $c_value) {
	    					$this->want_tables[$key]['columns'][$c_key] = array_merge($this->blank_column, $c_value);
	    				}

	    				unset($columns); // Unset variable after use
	    				unset(${$key.$this->end_var_name}); // Unset variable after use
	    			} else {
	    				array_push($errors, 'Could not find variable <strong>$'.$key.$this->end_var_name.'</strong> in <strong>'.$filename.'</strong> file');
	    			}
				} else {
					array_push($errors, 'The file <strong>'.$filename.'</strong> does not exist. Add file <strong>'.$filename.'</strong> to <strong>'.$this->set_path.'</strong> folder');
				}
	    	}
		} else {
		    array_push($errors, 'Could not locate primary tables file <strong>_tables.php</strong> in <strong>'.$this->set_path.'</strong> folder.');
		}


    	if(!empty($errors)) {
    		echo '<h2 style="color: red;">File, folder, or variable naming issue!!!</h2>';
    		echo implode('<br />', $errors);
    		die();
    	}

    	// Uncomment to view final want table list
    	// echo 'Want List';
    	// echo '<pre>';
    	// print_r($this->want_tables);
    	// echo '</pre>';
    }

    function compile_itis_tables() {
    	// Start by empting want_tables array
    	$this->itis_tables = array();

    	// Variables
    	$errors = array();

    	// Start by querying current list of tables in database
    	$tables = $this->mysqli->query("SHOW TABLES FROM $this->database");
		if($tables->num_rows > 0) {
			while($t_info = $tables->fetch_object()) {
				$table_name = $t_info->Tables_in_dbsync;
				$this->itis_tables[$table_name] = array('columns' => array());

				// Go grab columns in database
				$columns = $this->mysqli->query("SHOW COLUMNS FROM $table_name");
				if($columns->field_count > 0) {
					while($c_info = $columns->fetch_object()) {
						$field = $this->get_type_constraint($c_info->Type);
						// Add column info
						$this->itis_tables[$table_name]['columns'][$c_info->Field] = array(
							'type' => $field['type'],
							'constraint' => $field['constraint'],
							'primary' => ($c_info->Key == 'PRI' ? true: false),
							'index' => ($c_info->Key == 'MUL' ? true: false),
							'unique' => ($c_info->Key == 'UNI' ? true: false),
							'auto_increment' => ($c_info->Extra == 'auto_increment' ? true: false),
							'null' => ($c_info->Null == 'YES' ? true : false)
						);

						// Uncomment to view current column info
						// echo '<pre>';
						// print_r($c_info);
						// echo '</pre>';
					}
				}
				mysqli_free_result($columns); // Always free results after query
			}
		}

		mysqli_free_result($tables); // Always free results after query

		// Uncomment to view final itis table
		// echo 'Currently is list';
		// echo '<pre>';
		// print_r($this->itis_tables);
		// echo '</pre>';
    }

    function compare_final() {
    	// Put togehter final list of what needs to be done

    	// Start by empting final_action array and status numbers
    	$this->final_action = array();
    	$this->num_adds = 0;
    	$this->num_changes = 0;
    	$this->num_deletes = 0;

    	// Take want_tables list and check agains itis_tables list
    	foreach($this->want_tables as $t_key => $t_value) {
    		if(!isset($this->itis_tables[$t_key])) {
    			// want_tables is not in itis_tables, need to add it
    			$this->final_action[$t_key] = $t_value;
    			$this->final_action[$t_key]['action'] = 'add';
    		} else {
    			// Does exists lets check to see if we need to add anything
    			// Start looping through want_table columns
    			foreach($this->want_tables[$t_key]['columns'] as $c_key => $c_value) {
    				if(!isset($this->itis_tables[$t_key]['columns'][$c_key])) {
    					// want_tables column is not in itis_tables column, need to add it
    					$this->final_action[$t_key]['columns'][$c_key] = $c_value;
    					$this->final_action[$t_key]['columns'][$c_key]['action'] = 'add';
    				} else {
    					// want_tables column does exists in itis_tables column, lets check column attributes
    					// Set variable to check for changes
    					$changes = array();

    					// Set want_tables column, if there later needs to be changes this will be the after
    					$this->final_action[$t_key]['columns'][$c_key] = $c_value;
    					$this->final_action[$t_key]['columns'][$c_key]['action'] = false;

    					// Start checking the two columns for differences
    					$want_column_info = $this->want_tables[$t_key]['columns'][$c_key];
    					$itis_column_info = $this->itis_tables[$t_key]['columns'][$c_key];

    					foreach($want_column_info as $a_key => $a_value) {
    						if($a_value !== $itis_column_info[$a_key]) {

    						}
    					}
    				}
    			}

    			// Loop through itis table columns to see if we need to delete any
		    	foreach($this->itis_tables[$t_key] as $c_key => $c_value) {
		    		if(!isset($this->want_tables[$t_key]['columns'][$c_key])) {
		    			$this->final_action[$t_key]['columns'][$c_key] = $c_value;
		    			$this->final_action[$t_key]['columns'][$c_key]['action'] = 'delete';
		    		}
		    	}
    		}
    	}

    	// Loop through itis_tables to see if we need to delete any
    	foreach($this->itis_tables as $t_key => $t_value) {
    		if(!isset($this->want_tables[$t_key])) {
    			$this->final_action[$t_key] = $t_value;
    			$this->final_action[$t_key]['action'] = 'delete';
    		}
    	}

    	// Uncomment to view final itis table
		echo '<pre>';
		print_r($this->final_action);
		echo '</pre>';
    }

    //////////////////////////////////
    // Primary alteration fucntions //
    //////////////////////////////////
    function create_tables() {

    }
}

?>