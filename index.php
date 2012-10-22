<?php

include 'dbsync.php';
$dbsync = new dbsync();

// List settings
$num_per_column = 2;

$final_list = $dbsync->compile_compare();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to Database Sync</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="resources/main.css" />
        <script>
	        $(document).ready(function(){
	        	$('.tablename, .columnname').click(function(){
	                var nextitem = $(this).next('div');
	                if(nextitem.is(":visible")){
	                    nextitem.hide('fast');
	                } else {
	                    nextitem.show('fast');
	                }
	            });
	        });
        </script>
    </head>
    <body>
    	<div class="header">
    		<h1 class="center">DB<span class="green">sync</span></h1>
    		<h4 class="center">Mysql Database Syncing Class</h4>
    	</div>
    	<div class="header_shadow"></div>
    	<div class="needslist">
    		<h4>What needs to happen:</h4>
    		<?php if($dbsync->num_adds != 0 || $dbsync->num_changes != 0 || $dbsync->num_deletes != 0): ?>
                <span class="needstoadd"><?php echo $dbsync->num_adds; ?> Additions</span>
                <span class="needstochange"><?php echo $dbsync->num_changes; ?> Changes</span>
                <span class="needstodelete"><?php echo $dbsync->num_deletes; ?> Deletions</span>
            <?php else: ?>
                <div class="needstoadd">nothing</div>
            <?php endif; ?>
    	</div>
    	<div class="container">
    		<?php if(isset($final_list)): ?>
	    		<div class="groupcontainer">
	    			<?php $cur_group_num = 1;  ?>
		    		<?php foreach($final_list as $t_key => $t_value): ?>
		    			<div class="tablecontainer">
		    				<?php echo '<pre>'; print_r($t_value); echo '</pre>'; ?>
		    				<div class="tablename"><?php echo $t_key; ?></div>
		    				<div class="columncontainer">
		    					<?php foreach($t_value['columns'] as $c_key => $c_value): ?>
		    						<div class="columnname"><?php echo $c_key; ?></div>
		    						<div class="attrcontainer">
		    							<div class="attrname"><div class="width110 inline">Type:</div> <?php echo strtoupper($c_value['type']); ?></div>
		    							<?php if($c_value['constraint']): ?>
		    								<div class="attrname"><div class="width110 inline">Constraint:</div> <?php echo $c_value['constraint']; ?></div>
		    							<?php endif; ?>
		    							<?php if($c_value['default']): ?>
		    								<div class="attrname"><div class="width110 inline">Default:</div> <?php echo $c_value['default']; ?></div>
		    							<?php endif; ?>
		    							<?php if($c_value['primary']): ?>
		    								<div class="attrname"><div class="width110 inline">Primary:</div> <?php echo ($c_value['primary'] ? 'True': 'False'); ?></div>
		    							<?php endif; ?>
		    							<?php if($c_value['index']): ?>
		    								<div class="attrname"><div class="width110 inline">Index:</div> <?php echo ($c_value['index'] ? 'True': 'False'); ?></div>
		    							<?php endif; ?>
		    							<?php if($c_value['unique']): ?>
		    								<div class="attrname"><div class="width110 inline">Unique:</div> <?php echo ($c_value['unique'] ? 'True': 'False'); ?></div>
		    							<?php endif; ?>
		    							<?php if($c_value['auto_increment']): ?>
		    								<div class="attrname"><div class="width110 inline">Auto Increment:</div> <?php echo ($c_value['auto_increment'] ? 'True': 'False'); ?></div>
		    							<?php endif; ?>
		    							<?php if($c_value['null']): ?>
		    								<div class="attrname"><div class="width110 inline">Null:</div> <?php echo ($c_value['null'] ? 'True': 'False'); ?></div>
		    							<?php endif; ?>
		    						</div>
		    					<?php endforeach; ?>
		    				</div>
		    			</div>
			    		<!-- Seperate Columns -->
			    		<?php if($cur_group_num == $num_per_column): ?>
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