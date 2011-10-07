<?=$this->functions->form_declaration(array(
	'action' => act_url(RE_SHORT_NAME, 'post_login', array(
		'client_id' => $this->input->get('client_id'),
		'client_secret' => $this->input->get('client_secret')
	))
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