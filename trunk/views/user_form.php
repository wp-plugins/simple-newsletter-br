<div class="simplenewsletter" data-showon='<?php echo get_option('simplenewsletter_showon'); ?>'>
	<form method='POST' id='submit_simplenewsletter'>
		<?php 
		if(get_option('simplenewsletter_showname') == 1)
		{
			?>
			<fieldset class='simplenewsleter-field simplenewsleter-field-name'>
				<input name='simplenewsletter[name]' type='text' placeholder='Nome'/>
			</fieldset>
			<?php 
		} ?>
		<fieldset class='simplenewsleter-field simplenewsleter-field-email'>
			<input name='simplenewsletter[email]' type='email' placeholder='Email' />
		</fieldset>
		<input type="submit" value="Enviar" class='simplenewsleter-field-submit' />
	</form>
</div>