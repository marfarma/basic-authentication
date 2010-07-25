<?php 
	/**
	 * WordPress contest which ask authentication to the users before showing the site
	 * 
	 * @copyright 	Klaas Cuvelier
	 * @author 		Klaas Cuvelier, cuvelierklaas@gmail.com (http://www.cuvedev.net)
	 * @version		1.0
	 * @license		GPL v2.0
	 * 
	 */
?>
<div class="wrap">
	<h2>Basic Authentication: Options</h2>
	
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		
		<table class="form-table widefat">
			<tr>
				<th scope="row"><label for="basic_authentication_enabled">Authentication enabled</label></th>
				<td><input type="checkbox" name="basic_authentication_enabled" id="basic_authentication_enabled" <?php if (get_option('basic_authentication_enabled', '') === 'on') { ?>checked="checked"<?php } ?> /></td>
			</tr>
			<tr>
				<th scope="row"><label for="basic_authentication_method_wp">Authentication method</label></th>
				<td>
					<input type="radio" name="basic_authentication_method" value="wp-login" id="basic_authentication_method_wp-login" style="width: 20px;" <?php if (get_option('basic_authentication_method', 'wp-login') === 'wp-login') { ?>checked="checked"<?php } ?> />
					<label for="basic_authentication_method_wp-login">Use Wordpress login</label>
					<br />
					<input type="radio" name="basic_authentication_method" value="predefined" id="basic_authentication_method_predefined" style="width: 20px;" <?php if (get_option('basic_authentication_method', 'wp-login') === 'predefined') { ?>checked="checked"<?php } ?> />
					<label for="basic_authentication_method_predefined">Use a predefined password:</label>
					<br />
					<input type="text" name="basic_authentication_password" style="margin-left: 20px;" value="<?php echo get_option('basic_authentication_password', ''); ?>" />
				</td>
			</tr>			
		</table>
		
		<input type="hidden" name="page_options" value="basic_authentication_enabled,basic_authentication_method,basic_authentication_password" />
		<input type="hidden" name="action" value="update" />
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>