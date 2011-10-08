<?=$this->functions->form_declaration(array(
	'action' => act_url(RE_SHORT_NAME, 'post_login', $_GET)
))?>

<p>
	<input type="text" name="username" />
</p>

<p>
	<input type="password" name="password" />
</p>

<p>
	<input type="submit" value="Login" />
</p>

</form>