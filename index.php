<?php

include 'dbsync.php';
$dbsync = new dbsync();

$final_list = $dbsync->compile_compare();

if(isset($_POST['all'])){
	if($_POST['all'] == 'yes') {
		$dbsync->process_add($final_list);
		$dbsync->process_change($final_list);
		$dbsync->process_delete($final_list);
		$final_list = $dbsync->compile_compare();
	}
	if($_POST['add'] == 'yes') {
		$dbsync->process_add($final_list);
		$final_list = $dbsync->compile_compare();
	}
	if($_POST['change'] == 'yes') {
		$dbsync->process_change($final_list);
		$final_list = $dbsync->compile_compare();
	}
	if($_POST['delete'] == 'yes') {
		$dbsync->process_delete($final_list);
		$final_list = $dbsync->compile_compare();
	}
}

$dbsync->db_close();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
        <title>Welcome to Database Sync</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="main.css" />
        <script>
	        $(document).ready(function(){
	        	// Show and hide tables 
	        	$('.tablename').click(function(){
	        		var t_this = $(this);
	                var nextitem = t_this.next('div');
	                if(nextitem.is(':visible')){
	                	nextitem.find('div.attrcontainer').each(function(index) {
							$(this).hide('fast');
						});
						setTimeout(function(){
	                    	nextitem.hide('fast');
						}, 100);
	                } else {
	                    nextitem.show('fast');
	                    setTimeout(function(){
	                    	var animationtime = 75;
		                    nextitem.find('div.attrcontainer').each(function(index) {
								$(this).delay(animationtime).show('fast');
								animationtime += 75;
							});
						}, 100);
	                }
	            });

	        	// Process action buttons
	            $('.actions .process .items .all').click(function(){
	            	$('#process_form input').val('no'); // set all to no
					if(confirm('Are you sure you want to process all items?<?php echo (!$dbsync->allow_deletion ? '\r\nDeletion is currently turned off': ''); ?>')) {
		            	$('#process_form input.all').val('yes');
		            	$('#process_form').submit();
					}
	        	});
	        	$('.actions .process .items .add').click(function(){
	            	$('#process_form input').val('no'); // set add to no
	            	if(confirm('Are you sure you want to process all adds?')) {
		            	$('#process_form input.add').val('yes');
		            	$('#process_form').submit();
		            }
	        	});
	        	$('.actions .process .items .change').click(function(){
	            	$('#process_form input').val('no'); // set change to no
	            	if(confirm('Are you sure you want to process all changes?')) {
		            	$('#process_form input.change').val('yes');
		            	$('#process_form').submit();
		            }
	        	});
	        	$('.actions .process .items .delete').click(function(){
	            	$('#process_form input').val('no'); // set delete to no
	            	if(!<?php echo "'".$dbsync->allow_deletion."'"; ?>){
	            		alert('Deletion is currently turned off in settings.');
	            		return false;
	            	}
	            	if(confirm('Are you sure you want to process all deletions?')) {
		            	$('#process_form input.delete').val('yes');
		            	$('#process_form').submit();
		            }
	        	});

	        	// Show and hide all, add, change and delete
	        	$('.actions .showhide .items .all').click(function(){
	        		// Show all groups
	        		$('.groupcontainer').show('fast');

	        		// Hide all columns
	        		$('.sh_columns').hide('fast');

	        		// Show all tables
	        		$('.sh_table_name').show('fast');
	        	});
	        	$('.actions .showhide .items .add').click(function(){
	        		// Show hide by type
	        		show_hide_by_type('add');
	        	});
	        	$('.actions .showhide .items .change').click(function(){
	        		// Show hide by type
	        		show_hide_by_type('change');
	        	});
	        	$('.actions .showhide .items .delete').click(function(){
	        		// Show hide by type
	        		show_hide_by_type('delete');
	        	});

	        	// Show and hide setup
	        	$('.actions .setup .click').click(function(){
	        		if($('#setup').is(':visible')){
	        			$('#setup').hide('fast');
	        		} else {
	        			$('#setup').show('fast');
	        		}
	        	});

	        	// Show and hide hints
	        	$('.actions .hints .click').click(function(){
	        		if($('#hints').is(':visible')){
	        			$('#hints').hide('fast');
	        		} else {
	        			$('#hints').show('fast');
	        		}
	        	});
	        });

			// Show Hide functions
			function show_hide_by_type(type) {
				// Show full groups
	        	show_full_groups(type);

				// Hide all columns
	        	$('.sh_columns').hide('fast');

	        	// Show all tables with type
        		$('.sh_'+type).show('fast');

        		// Loop through each table name and show those with type
        		$('.tablename .'+type).each(function(index) {
					$(this).parent().show('fast');
				});

				// Loop through each table name and hide those that dont have .sh_type
				$('.tablename').each(function(index) {
					if($(this).find('.'+type).length == 0 && !$(this).hasClass('sh_'+type)) {
						$(this).hide('fast');
					}
				});

				// hide empty groups
				hide_empty_groups();
			}
			function show_full_groups(type) {
				$('.groupcontainer').each(function(index) {
					var cur_group = $(this);
					var cur_table;
					var should_show_group = false;

					cur_group.find('.tablename').each(function(index) {
						cur_table = $(this).next('div'); // Grab column container
						if($(this).hasClass('sh_'+type)) {
							// If it has sh_type they show group
							should_show_group = true;
							return false;
						} else {
							// Doesnt have sh_type but lets check columns
							cur_table.find('.columnname').each(function(index) {
								if($(this).hasClass(type)) {
									should_show_group = true;
									return false;
								}
							});
						}
					});

					if(should_show_group){
						cur_group.show('fast');
					} else {
						cur_group.hide('fast');
					}
				});
			}
			function hide_empty_groups() {
				setTimeout(function(){					
					$('.groupcontainer').each(function(index) {
						var cur_group = $(this);
						var should_hide_group = true;

						cur_group.find('.tablename').each(function(index) {
							if($(this).is(':visible')) {
								should_hide_group = false;
								return false;
							}
						});

						if(should_hide_group){
							cur_group.hide('fast');
						} else {
							cur_group.show('fast');
						}
					});
				}, 210);
			}
        </script>
    </head>
    <body>
    	<div class="header">
    		<h1>DB<span class="green">sync</span></h1>
    		<h4>PHP Mysql Database Syncing Class</h4>
    	</div>
    	<div class="actions">
    		<div class="status">
	    		<h4>What Needs to Happen:</h4>
	    		<?php if($dbsync->num_adds != 0 || $dbsync->num_changes != 0 || $dbsync->num_deletes != 0): ?>
	                <span class="add"><?php echo $dbsync->num_adds; ?> Additions</span> - 
	                <span class="change"><?php echo $dbsync->num_changes; ?> Changes</span> - 
	                <span class="delete"><?php echo $dbsync->num_deletes; ?> Deletions</span>
	            <?php else: ?>
	                <div class="add"><strong>nothing</strong></div>
	            <?php endif; ?>
	        </div>
	        <div class="process">
	        	<h4 style="padding-bottom: 5px;">Process Requests:</h4>
	        	<div class="items">
	        		<span class="all">All</span>
	        		<span class="add">Add</span>
	        		<span class="change">Change</span>
	        		<span class="delete">Delete</span>
	        	</div>
	        	<form id="process_form" action="" method="post">
	        		<input type="hidden" class="all" name="all" value="no" />
	        		<input type="hidden" class="add" name="add" value="no" />
	        		<input type="hidden" class="change" name="change" value="no" />
	        		<input type="hidden" class="delete" name="delete" value="no" />
	        	</form>
	        </div>
	        <div class="showhide">
	        	<h4>Show and Hide Tables:</h4>
	        	<div class="items">
	        		<span class="all">All</span>
	        		<span class="add">Add</span>
	        		<span class="change">Change</span>
	        		<span class="delete">Delete</span>
	        	</div>
	        </div>
	        <div class="setup">
	        	<h4>Install and Setup:</h4>
	        	<div class="click">Click to View</div>
	        </div>
	        <div class="hints">
	        	<h4>Tips and Tricks:</h4>
	        	<div class="click">Click to View</div>
	        </div>
    	</div>
    	<div class="clear"></div>
    	<?php echo (!empty($dbsync->sql_errors) ? '<div class="errormessage">'.implode('<br />', $dbsync->sql_errors).'</div>': '') ?>
    	<div class="clear"></div>
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
					)
    			</li>
    		</ol>
    	</div>
    	<div class="clear"></div>
    	<div id="hints">
    		<h3>Some Tips, Tricks and things to keep in mind</h3>
    		<strong>Important!</strong>
    		<ol>
    			<li>If you are worried about <strong>ANYTHING</strong> at all, use this as a guide as to things that need to be done only.</li>
    			<li>When making changes to columns in tables that have a lot of data in them, be aware you may get a PHP timeout error.</li>
    			<li>Be aware DBsync will attempt to process your requests but may not fully work if given unrealistic requests. Ex: VARCHAR constraint of 50000000</li>
    			<li>If you get an error, its an error from php mysqli->error text. If not descriptive enough, process what you can and try to minize it to a specific table.</li>
    			<li>Ensure if you change a column type from one type to another that the data in the column will translate over properly.</li>
    			<li>To ensure additional database security remove database connection settings after running processes.</li>
    		</ol>
    		<strong>Column settings</strong>
    		<ol>
    			<li>When setting type integer ensure you have a constraint number.</li>
    			<li>When changing DECIMAL constraint and you have a default make sure to change the default to reflect the constraint.</li>
    			<li>When setting timestamp default value must also be 'CURRENT_TIMESTAMP'.</li>
    			<li>When setting auto increment to a column ensure you have primary set as well.</li>
    			<li>When setting a type enum set the constraints with a double quote and each value in a single qoute. Ex: 'type' => 'ENUM', 'constraint' => " 'flat','percentage' "</li>
    		</ol>
    		<strong>Minor</strong>
    		<ol>
    			<li>Alphabetize your tables in your _tables.php file.</li>
    			<li>Organize your columns in the order in which you want them set in mysql.</li>
    			<li>Check tables for notes before processing there may be something important noted.</li>
    			<li>Click on table name to pull down its column information.</li>
    			<li>The circles next to table names indicates that there are changes that need to happen to columns in table.</li>
    			<li>Add notes to tables to help others understand what may need to happen or general information about the table.</li>
    		</ol>
    	</div>
    	<div class="clear"></div>
    	<div class="container">
    		<?php if(isset($final_list)): ?>
	    		<div class="groupcontainer">
	    			<?php $cur_group_num = 1;  ?>
		    		<?php foreach($final_list as $t_key => $t_value): ?>
		    			<div class="tablecontainer">
		    				<div class="tablename <?php echo $t_value['action']; ?> sh_table_name sh_<?php echo $t_value['action']; ?>">
		    					<?php echo $t_key; ?>
		    					<?php echo $dbsync->set_table_changes($t_value); ?>
		    				</div>
		    				<div class="columncontainer <?php echo $t_value['action']; ?> sh_columns">
		    					<?php echo (isset($t_value['notes']) ? '<div class="tablenotes"><strong>Notes:</strong> '.$t_value['notes'].'</div>': ''); ?>
		    					<?php foreach($t_value['columns'] as $c_key => $c_value): ?>
		    						<div class="columnname <?php echo $c_value['action']; ?>"><?php echo $c_key; ?></div>
		    						<div class="attrcontainer <?php echo ($c_value['action'] != 'change' ? $c_value['action']: ''); ?>">
		    							<?php echo $dbsync->set_attr_text($c_value); ?>
		    						</div>
		    					<?php endforeach; ?>
		    				</div>
		    			</div>
			    		<!-- Seperate Columns -->
			    		<?php if($cur_group_num == $dbsync->num_per_column): ?>
			    			</div>
			    			<div class="groupcontainer">
			    			<?php $cur_group_num = 0; ?>
			    		<?php endif; ?>
			    		<?php $cur_group_num++; ?>
			    		<!-- End Seperate Columns -->
		    		<?php endforeach; ?>
		    	</div>
		    <?php endif; ?>
    	</div>
    </body>
</html>