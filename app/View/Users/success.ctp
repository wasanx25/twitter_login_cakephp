<?php foreach ($user_data as $data) { ?>
	<p>ようこそ！<?php echo $data["User"]["username"]; ?>さん</p>
	<img src="<?php echo $data["User"]["image"]; ?>">
<?php } ?>
