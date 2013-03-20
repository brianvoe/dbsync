dbsync
======

PHP Mysql Database Syncing Class

This class allows you to be able to set php files to establish what database changes need to happen to your local database copy. 
Primary use is for groups of people who use version control systems(like git) to maintain projects, 
but want keep a local database copy for testing.

<div id="setup">
	<h3 style="padding: 0 0 10px 0;">Installation and Setup</h3>
	<h4>Settings</h4>
	<ol style="padding: 0 0 10px 0;">
		<li>Open up dbsync.php file:
			<ol>
    			<li>Set database variable to desired database</li>
    			<li>Set other class variables if you need to change them from current value - recommended to leave as is</li>
			</ol>
		</li>
	</ol>
	<h4>Files Structure</h4>
	<ol style="padding: 0 0 10px 0;">
		<li>Unless changed all database files are in dbtables folder</li>
		<li>_tables.php is your primary table for setting all the database tables you need.
			<ol>
				<li>In the _tables.php file is a $tables assoc array that contains table(key) and a value(array)
					<ol>
						<li>
							Example:<br />
							$_tables = array(<br />
							&nbsp;&nbsp;&nbsp;&nbsp;'table1' => array('notes' => 'Here are some notes about this table'),<br />
							&nbsp;&nbsp;&nbsp;&nbsp;'table2' => array(),<br />
							&nbsp;&nbsp;&nbsp;&nbsp;'table3' => array()<br />
							);
						</li>
					</ol>
				</li>
    			<li>
    				Each table may have a notes variable in array if desired to set notes for that table<br />
    				Ex: 'table' => array('notes' => 'Here are some notes about this table')
    			</li>
    		</ol>
		</li>
		<li>
			Dbsync runs through each key in $_tables array and looks for the correspoding ${key}.php file.<br />
			Ex: If key = 'table1' dbsync will look for table1.php files for that tables columns.
		</li>
		<li>
			In each tables file there should be a ${table}_columns array<br />
			Ex: Inside the table1.php file should be a $table1_columns array
		</li>
	</ol>
	<h4>Column Settings</h4>
	<ol>
		<li>In each table file the main array will consist of the key(column name) and value(list of possible column attributes)</li>
		<li>Ex:<br />
			<strong>'{columnname}'</strong> => array(<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'type' => 'INT',</strong> // Type of column - NOT case sensative anymore<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'constraint' => 11,</strong> // Optional - Constraint for type - Ex: INT(11) or DECIMAL(10,2)<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'default' => '{defaultvalue}',</strong> // Optional - Default value if inset is null or non existant<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'primary' => false,</strong> // Optional - Default is false - Indicates whether or not column is a primary<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'index' => false,</strong> // Optional - Default is false - Indicates whether or not column is indexed<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'unique' => false,</strong> // Optional - Default is false - Indicates whether or not column is a unique index<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'auto_increment' => false,</strong> // Optional - Default is false - Indicates whether or not column is auto_incremented to next number<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'null' => false</strong> // Optional - Default is false - Indicates whether or not column can be null<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'on_update_time' => false</strong> // Optional - Default if false - Whether or not to update on row modification<br />
			&nbsp;&nbsp;&nbsp;&nbsp;<strong>'extra' => {attribute value}</strong> // Optional - BINARY, UNSIGNED or UNSIGNED ZEROFILL<br />
			)
		</li>
	</ol>
</div>