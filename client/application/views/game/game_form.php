<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Game <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Genre <?php echo form_error('genre') ?></label>
            <input type="text" class="form-control" name="genre" id="genre" placeholder="Genre" value="<?php echo $genre; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Game Name <?php echo form_error('game_name') ?></label>
            <input type="text" class="form-control" name="game_name" id="game_name" placeholder="Game Name" value="<?php echo $game_name; ?>" />
        </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('game') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>
</html>