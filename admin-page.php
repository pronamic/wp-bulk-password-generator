<h3><?php _e('Bulk Password Generator', 'bulk-password-generator'); ?></h3>

<form method="post" action="tools.php?page=bulk-password-generator">
	<table>
		<tr>
			<td><?php _e('Select a role', 'bulk-password-generator')?></td>
			<td>
				<select name="user-role">
					<option value="-1"> - <?php _e('None Selected', 'bulk-password-generator'); ?> - </option>
					<?php foreach( $roles as $key => $role): ?>
						<option value="<?php echo $key; ?>"><?php echo $role['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td><i><?php _e('Select the role for which you want users to have newly generated passwords', 'bulk-password-generator')?></i></td>
		</tr>
	</table>
	<?php submit_button( __('Generate Passwords', 'bulk-password-generator') ); ?>
</form>

<?php if( isset( $_POST['submit'] ) ): ?>
	<h3><?php _e('Results', 'bulk-password-generator'); ?>:</h3>

	<?php if( ! isset( $adapted_users ) || count( $adapted_users ) <= 0 ): ?>
		<p><?php _e('No users were found to generate passwords for.', 'bulk-password-generator')?></p>
	<?php else: ?>
		<style type="text/css">
			.bulk-password-generator-results td {
				padding: 0 20px;
			}
		</style>
		<table class="bulk-password-generator-results">
			<tr>
				<th><?php _e('ID', 'bulk-password-generator'); ?></th>
				<th><?php _e('Login', 'bulk-password-generator'); ?></th>
				<th><?php _e('Email', 'bulk-password-generator'); ?></th>
				<th><?php _e('Password', 'bulk-password-generator'); ?></th>
			</tr>
			<?php foreach( $adapted_users as $adapted_user ): ?>
				<tr>
					<td><?php echo $adapted_user['id']; ?></td>
					<td><?php echo $adapted_user['login']; ?></td>
					<td><?php echo $adapted_user['mail']; ?></td>
					<td><?php echo $adapted_user['pass']; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif;
endif;
?>