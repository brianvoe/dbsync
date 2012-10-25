<?php 

/*
  PHP Mysql Database Syncing Class
  Copyright (c) 2012 Brian Voelker (webiswhatido.com)
  Licensed under GPLv3
  http://www.opensource.org/licenses/gpl-3.0.html
  Version: 1
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
    public $engine_type = 'InnoDB'; // Set engine type
    public $char_set = 'utf8'; // Set collation type
    public $collation = 'utf8_bin'; // Set collation type

    // Settings variables
    public $allow_deletion = false; // By default table deletions are turned off for possible oopsy mistake alleviations
    public $set_path = 'dbtables'; // Location to settings files
    public $end_file_name = ''; // If needing to append text to file name
    public $end_var_name = '_columns'; // Appended text for var array name in individual table file
    public $num_per_column = 20; // How many tables to show for each column on frontend
    //////////////////
    // End Settings //
    //////////////////


    ////////////////////////
    // In Class Variables //
    ////////////////////////
    // Comparison arrays for before and after
    public $want_tables = array(); // What we want the db to be
    public $itis_tables = array(); // What is currently is
    public $final_action = array(); // Final list of actions that need to happen

    // Return errors
    public $sql_errors = array();

    // Blank preset arrays
    public $blank_table = array(

    );
    public $blank_column = array(
		'type' => '',
		'constraint' => false,
        'default' => false,
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

    function db_query($query) {
        $result = $this->mysqli->query($query);
        if($this->mysqli->error){
            array_push($this->sql_errors, $this->mysqli->error);
        }
        return $result;
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
    function compile_compare() {
        $this->compile_want_tables();
        $this->compile_itis_tables();
        $this->compare_final();
        return $this->final_action;
    }

    function compile_want_tables() {
    	// Start by empting want_tables array
    	$this->want_tables = array();

    	// Variables
    	$errors = array();

    	if (file_exists($this->set_path.'/_tables.php')) {
    		// Include primary tables file
		    include $this->set_path.'/_tables.php';

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

	    			include $this->set_path.'/'.$key.$this->end_file_name.'.php';
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
            unset($_tables); // Unset table variable after use
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
    	$tables = $this->db_query("SHOW TABLES FROM $this->database");
		if($tables->num_rows > 0) {
			while($t_info = $tables->fetch_object()) {
				$table_name = $t_info->Tables_in_dbsync;
				$this->itis_tables[$table_name] = array('columns' => array());

				// Go grab columns in database
				$columns = $this->db_query("SHOW COLUMNS FROM $table_name");
				if($columns->field_count > 0) {
					while($c_info = $columns->fetch_object()) {
						$field = $this->get_type_constraint($c_info->Type);
						// Add column info
						$this->itis_tables[$table_name]['columns'][$c_info->Field] = array(
							'type' => $field['type'],
							'constraint' => $field['constraint'],
                            'default' => $c_info->Default,
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
            // Add want tables to final_action
            $this->final_action[$t_key] = $t_value;
            $this->final_action[$t_key]['action'] = 'none';

    		if(!isset($this->itis_tables[$t_key])) {
    			// want_tables is not in itis_tables, need to add it
    			$this->final_action[$t_key]['action'] = 'add';
                $this->num_adds++;
    		} else {
    			// Does exists lets check to see if we need to add anything

    			// Start looping through want_table columns
    			foreach($this->want_tables[$t_key]['columns'] as $c_key => $c_value) {
                    // Add want tables columns to current table
                    $this->final_action[$t_key]['columns'][$c_key] = $c_value;
                    $this->final_action[$t_key]['columns'][$c_key]['action'] = 'none';
                    $this->final_action[$t_key]['columns'][$c_key]['action_list'] = array();

    				if(!isset($this->itis_tables[$t_key]['columns'][$c_key])) {
    					// want_tables column is not in itis_tables column, need to add it
    					$this->final_action[$t_key]['columns'][$c_key]['action'] = 'add';
                        $this->num_adds++;
    				} else {
    					// want_tables column does exists in itis_tables column, lets check column attributes

    					// Start checking the two columns for differences
    					$want_column_info = $this->want_tables[$t_key]['columns'][$c_key];
    					$itis_column_info = $this->itis_tables[$t_key]['columns'][$c_key];

                        $a_changes = array();
    					foreach($want_column_info as $a_key => $a_value) {
    						if(strtolower($a_value) !== strtolower($itis_column_info[$a_key])) {
                                array_push($a_changes, $a_key);
                                $this->final_action[$t_key]['columns'][$c_key]['action'] = 'change';
                                $this->num_changes++;
    						}
    					}
                        $this->final_action[$t_key]['columns'][$c_key]['action_list'] = $a_changes;

                        if($this->final_action[$t_key]['columns'][$c_key]['action'] == 'change') {
                            $this->final_action[$t_key]['columns'][$c_key]['itis'] = $itis_column_info;
                        }
    				}
    			}

    			// Loop through itis table columns to see if we need to delete any
		    	foreach($this->itis_tables[$t_key]['columns'] as $c_key => $c_value) {
		    		if(!isset($this->want_tables[$t_key]['columns'][$c_key])) {
                        $this->final_action[$t_key]['columns'][$c_key] = $c_value;
                        $this->final_action[$t_key]['columns'][$c_key]['action'] = 'delete';
                        $this->final_action[$t_key]['columns'][$c_key]['action_list'] = array();
                        $this->num_deletes++;
		    		}
		    	}
    		}
    	}

    	// Loop through itis_tables to see if we need to delete any
    	foreach($this->itis_tables as $t_key => $t_value) {
    		if(!isset($this->want_tables[$t_key])) {
    			$this->final_action[$t_key] = $t_value;
                $this->final_action[$t_key]['action'] = 'delete';
                $this->num_deletes++;
    		}
    	}

    	// Uncomment to view final itis table
		// echo '<pre>';
		// print_r($this->final_action);
		// echo '</pre>';
    }

    // Place markers next to table to say whether or not
    function set_table_changes($t_value) {
        // Set variables
        $return_txt = '';
        $add = false;
        $change = false;
        $delete = false;

        // Loop through columns in table
        foreach($t_value['columns'] as $c_key => $c_value) {
            if(isset($c_value['action']) ) {
                if($c_value['action'] == 'add'){
                    $add = true;
                } else if($c_value['action'] == 'change') {
                    $change = true;
                } else if($c_value['action'] == 'delete') {
                    $delete = true;
                }
            }
        }

        // Add markers if they are true
        if($add){
            $return_txt .= '<div class="add"></div>';
        }
        if($change) {
            $return_txt .= '<div class="change"></div>';
        }
        if($delete) {
            $return_txt .= '<div class="delete"></div>';
        }

        return $return_txt;
    }

    // Loop through attributes and check for changes
    function set_attr_text($c_value) {
        // Uncommment to see each array next to each column
        // echo '<pre>'; print_r($c_value); echo '</pre>';

        // Set return variable
        $return_txt = '';

        // Type
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('type', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Type:</div> '.strtoupper($c_value['itis']['type']).' to '.strtoupper($c_value['type']).'</div>';
        } else if($c_value['type']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Type:</div> '.strtoupper($c_value['type']).'</div>';
        }

        // Constraint
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('constraint', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Constraint:</div> '.$c_value['itis']['constraint'].' to '.$c_value['constraint'].'</div>';
        } else if($c_value['constraint']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Constraint:</div> '.$c_value['constraint'].'</div>';
        }

        // Default
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('default', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Default:</div> '.$c_value['itis']['default'].' to '.$c_value['default'].'</div>';
        } else if($c_value['default']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Default:</div> '.$c_value['default'].'</div>';
        }

        // Primary
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('primary', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Primary:</div> '.($c_value['itis']['primary'] ? 'true': 'false').' to '.($c_value['primary'] ? 'true': 'false').'</div>';
        } else if($c_value['primary']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Primary:</div> '.($c_value['primary'] ? 'true': 'false').'</div>';
        }

        // Index
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('index', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Index:</div> '.($c_value['itis']['index'] ? 'true': 'false').' to '.($c_value['index'] ? 'true': 'false').'</div>';
        } else if($c_value['index']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Index:</div> '.($c_value['index'] ? 'true': 'false').'</div>';
        }

        // Unique
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('unique', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Unique:</div> '.($c_value['itis']['unique'] ? 'true': 'false').' to '.($c_value['unique'] ? 'true': 'false').'</div>';
        } else if($c_value['unique']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Unique:</div> '.($c_value['unique'] ? 'true': 'false').'</div>';
        }

        // Auto Increment
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('auto_increment', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Auto Incr:</div> '.($c_value['itis']['auto_increment'] ? 'true': 'false').' to '.($c_value['auto_increment'] ? 'true': 'false').'</div>';
        } else if($c_value['auto_increment']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Auto Incr:</div> '.($c_value['auto_increment'] ? 'true': 'false').'</div>';
        }

        // Null
        if(isset($c_value['action']) && $c_value['action'] == 'change' && in_array('null', $c_value['action_list'])) {
            $return_txt .= '<div class="attrname change"><div class="width80 inline">Null:</div> '.($c_value['itis']['null'] ? 'true': 'false').' to '.($c_value['null'] ? 'true': 'false').'</div>';
        } else if($c_value['null']) {
            $return_txt .= '<div class="attrname"><div class="width80 inline">Null:</div> '.($c_value['null'] ? 'true': 'false').'</div>';
        }
        
        return $return_txt;
    }

    //////////////////////////////////
    // Primary alteration fucntions //
    //////////////////////////////////
    function process_add($final) {
        // Loop through and process tables only
        foreach($final as $t_key => $t_value) {
            // echo '<pre>'; print_r($t_value); echo '</pre>';
            if($t_value['action'] == 'add') {
                // Set variables
                $columns = array();

                // Loop through columns and put together array
                foreach($t_value['columns'] as $c_key => $c_value) {
                    $c_txt = '`'.$c_key.'` '.strtoupper($c_value['type']).($c_value['constraint'] ? '('.$c_value['constraint'].')': '').' ';
                    $c_txt .= ($c_value['default'] ? "DEFAULT '".$c_value['default']."' ": '');
                    $c_txt .= ($c_value['null'] ? 'NULL ': 'NOT NULL ');
                    $c_txt .= ($c_value['auto_increment'] ? 'AUTO_INCREMENT ': '');
                    
                    array_push($columns, trim($c_txt));
                }

                // Loop through columns and put together array
                foreach($t_value['columns'] as $c_key => $c_value) {
                    if($c_value['primary']) {
                        array_push($columns, 'PRIMARY KEY ('.$c_key.')');
                    }

                    if($c_value['index']) {
                        array_push($columns, 'INDEX ('.$c_key.')');
                    }

                    if($c_value['unique']) {
                        array_push($columns, 'UNIQUE ('.$c_key.')');
                    }
                }

                // Add columns to table database
                $sql = 'CREATE TABLE `'.$t_key.'`(';
                $sql .= implode(', ', $columns);
                $sql .= ') ENGINE='.$this->engine_type.' CHARACTER SET '.$this->char_set.' COLLATE '.$this->collation;

                $this->db_query($sql);
            }
        }

        // Loop through and process columns only
        foreach($final as $t_key => $t_value) {
            $cur_column = false;
            foreach($t_value['columns'] as $c_key => $c_value) {
                if(isset($c_value['action']) && $c_value['action'] == 'add') {
                    // Add column 
                    $sql = 'ALTER TABLE '.$t_key.' ADD COLUMN '.$c_key.' '.strtoupper($c_value['type']).($c_value['constraint'] ? '('.$c_value['constraint'].')': '').' ';
                    $sql .= ($c_value['default'] ? "DEFAULT '".$c_value['default']."' ": '');
                    $sql .= ($c_value['null'] ? 'NULL ': 'NOT NULL ');
                    $sql .= ($c_value['auto_increment'] ? 'AUTO_INCREMENT PRIMARY KEY ': '');
                    $sql .= ($cur_column ? 'AFTER '.$cur_column.' ': 'FIRST ');
                    $this->db_query($sql);

                    // Check for indexes
                    if($c_value['primary'] && !$c_value['auto_increment']) {
                        $this->db_query('ALTER TABLE '.$t_key.' ADD PRIMARY KEY ('.$c_key.')');
                    }

                    if($c_value['index']) {
                        $this->db_query('ALTER TABLE '.$t_key.' ADD INDEX ('.$c_key.')');
                    }

                    if($c_value['unique']) {
                        $this->db_query('ALTER TABLE '.$t_key.' ADD UNIQUE ('.$c_key.')');
                    }
                }
                // Set current column
                $cur_column = $c_key;
            }
        }
    }

    function process_change($final) {
        // Loop through and process tables only
        foreach($final as $t_key => $t_value) {
            if($t_value['action'] == 'change') {
                // Currently dont have table changes
            }
        }

        // Loop through columns and make changes and necessary
        foreach($final as $t_key => $t_value) {
            foreach($t_value['columns'] as $c_key => $c_value) {
                if(isset($c_value['action']) && $c_value['action'] == 'change') {
                    //echo '<pre>'; print_r($c_value); echo '</pre>';
                    if(in_array('type', $c_value['action_list']) || in_array('constraint', $c_value['action_list']) || in_array('default', $c_value['action_list']) || in_array('auto_increment', $c_value['action_list']) || in_array('null', $c_value['action_list'])) {
                        // Change column
                        $sql = 'ALTER TABLE '.$t_key.' MODIFY '.$c_key.' '.strtoupper($c_value['type']).($c_value['constraint'] ? '('.$c_value['constraint'].')': '').' ';
                        $sql .= ($c_value['default'] ? "DEFAULT '".$c_value['default']."' ": '');
                        $sql .= ($c_value['null'] ? 'NULL ': 'NOT NULL ');
                        $sql .= ($c_value['auto_increment'] ? 'AUTO_INCREMENT PRIMARY KEY ': '');
                        $this->db_query($sql);
                    }

                    // Check for indexes
                    if(in_array('primary', $c_value['action_list']) && (!$c_value['primary'] || !in_array('auto_increment', $c_value['action_list']))) {
                        if($c_value['primary']) {
                            // Add primary key
                            $this->db_query('ALTER TABLE '.$t_key.' ADD PRIMARY KEY ('.$c_key.')');
                        } else {
                            // Drop primary key
                            $this->db_query('ALTER TABLE '.$t_key.' DROP PRIMARY KEY');
                        }
                    }

                    if(in_array('index', $c_value['action_list'])) {
                        if($c_value['index']) {
                            // Add index key
                            $this->db_query('ALTER TABLE '.$t_key.' ADD INDEX ('.$c_key.')');
                        } else {
                            // Drop index key
                            $this->db_query('ALTER TABLE '.$t_key.' DROP INDEX ('.$c_key.')');
                        }
                    }

                    if(in_array('unique', $c_value['action_list'])) {
                        if($c_value['unique']) {
                            // Add unique key
                            $this->db_query('ALTER TABLE '.$t_key.' ADD UNIQUE ('.$c_key.')');
                        } else {
                            // Drop unique key
                            $this->db_query('ALTER TABLE '.$t_key.' DROP UNIQUE ('.$c_key.')');
                        }
                    }
                }
            }
        }
    }

    function process_delete($final) {
        if(!$this->allow_deletion) {
            return;
        }

        // Loop through and process tables only
        foreach($final as $t_key => $t_value) {
            if($t_value['action'] == 'delete') {
                // Drop table
                $this->db_query('DROP TABLE '.$t_key);
            }
        }

        // Loop through columns and drop those who need to be deleted
        foreach($final as $t_key => $t_value) {
            foreach($t_value['columns'] as $c_key => $c_value) {
                if(isset($c_value['action']) && $c_value['action'] == 'delete') {
                    // Drop column
                    $this->db_query('ALTER TABLE '.$t_key.' DROP COLUMN '.$c_key);
                }
            }
        }
    }
}

?>