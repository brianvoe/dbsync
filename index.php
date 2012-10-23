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
	        	$('.tablename').click(function(){
	        		var t_this = $(this);
	                var nextitem = t_this.next('div');
	                if(nextitem.is(":visible")){
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
                <span class="add"><?php echo $dbsync->num_adds; ?> Additions</span>
                <span class="change"><?php echo $dbsync->num_changes; ?> Changes</span>
                <span class="delete"><?php echo $dbsync->num_deletes; ?> Deletions</span>
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
		    				<?php //echo '<pre>'; print_r($t_value); echo '</pre>'; ?>
		    				<div class="tablename <?php echo $t_value['action']; ?>">
		    					<?php echo $t_key; ?>
		    					<?php echo $dbsync->set_table_changes($t_value); ?>
		    				</div>
		    				<div class="columncontainer <?php echo $t_value['action']; ?>">
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