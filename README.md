dbsync
======

PHP Mysql Database Syncing Class

This class allows you to be able to set php files to establish what database changes need to happen to your local database copy. 
Primary use is for groups of people who use version control systems(like git) to maintain projects, 
but want keep a local database copy for testing.

Installation and Setup
Settings
Open up dbsync.php file:
Set database variable to desired database
Set other class variables if you need to change them from current value - recommended to leave as is
Files Structure
Unless changed all database files are in dbtables folder
_tables.php is your primary table for setting all the database tables you need.
In the _tables.php file is a $tables assoc array that contains table(key) and a value(array)
Example:
$_tables = array(
    'table1' => array('notes' => 'Here are some notes about this table'),
    'table2' => array(),
    'table3' => array()
);
Each table may have a notes variable in array if desired to set notes for that table
Ex: 'table' => array('notes' => 'Here are some notes about this table')
Dbsync runs through each key in $_tables array and looks for the correspoding ${key}.php file.
Ex: If key = 'table1' dbsync will look for table1.php files for that tables columns.
In each tables file there should be a ${table}_columns array
Ex: Inside the table1.php file should be a $table1_columns array
Column Settings
In each table file the main array will consist of the key(column name) and value(list of possible column attributes)
Ex:
'{columnname}' => array(
    'type' => 'INT', // Type of column - NOT case sensative anymore
    'constraint' => 11, // Optional - Constraint for type - Ex: INT(11) or DECIMAL(10,2)
    'default' => '{defaultvalue}', // Optional - Default value if inset is null or non existant
    'primary' => false, // Optional - Default is false - Indicates whether or not column is a primary
    'index' => false, // Optional - Default is false - Indicates whether or not column is indexed
    'unique' => false, // Optional - Default is false - Indicates whether or not column is a unique index
    'auto_increment' => false, // Optional - Default is false - Indicates whether or not column is auto_incremented to next number
    'null' => false // Optional - Default is false - Indicates whether or not column can be null
)