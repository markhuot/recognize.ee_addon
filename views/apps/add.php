<?=form_open(re_cp_url('post_app', FALSE), array())?>

<p>
<label>App Name</label>
<div class="instruction_text"><p><strong>Instructions: </strong>&nbsp;Displayed to users as they log in.</p></div>
<input type="text" name="app_name" value="" id="app_name" dir="ltr" maxlength="100" />
</p>

<ul id="publish_submit_buttons">
<li><input type="submit" class="submit" id="submit_button" value="Add Application" /></li>
</ul>

</form>