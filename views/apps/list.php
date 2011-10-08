<table class="mainTable" border="0" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th>App Name</th>
<th>App Id</th>
<th>App Secret</th>
<th></th>
<th></th>
</tr>

<?php foreach ($apps as $app): ?>
<tr>
	<td>
		<?=$app->app_name?>
	</td>
	<td>
		<?=$app->app_id?>
	</td>
	<td>
		<?=$app->app_secret?>
	</td>
	<td>
		<a href="<?=re_cp_url('delete_app'.AMP.'app_id='.$app->id)?>">
			Delete
		</a>
	</td>
	<td>
		<a href="<?php echo $this->functions->create_url('api/recognize/authorize'); ?>?response_type=code&client_id=<?=$app->app_id?>&scope=all&state=testing">
			Test
		</a>
	</td>
</tr>
<?php endforeach; ?>

</table>