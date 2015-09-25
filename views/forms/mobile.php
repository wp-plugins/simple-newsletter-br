<div class="simplenewsletter" data-showon='<?php echo get_option('simplenewsletter_showon'); ?>'>
	<?php $formID = uniqid('form_simplenewsletter-'); ?>
	<form method='POST' id='submit_simplenewsletter' class='<?php echo $formID ?>'>
		<?php
		$showName = (isset($attr['name']) && $attr['name'] == 'false')?false:(get_option('simplenewsletter_showname') == 1)?true:false;
		$showOptions = (isset($attr['channels']) && $attr['channels'] === 'true')?true:false;
		$setChannel = (isset($attr['channel']))?get_term_by('slug', $attr['channel'], 'sn_channels'):false;

		if(!empty($setChannel)){
			echo "<input name='simplenewsletter[channel]' type='hidden' value='{$setChannel->term_id}'/>";
		}

		if( $showOptions && !$setChannel ){
			$terms = get_terms('sn_channels', array(
			 	'orderby'    => 'name',
			 	'hide_empty' => 0,
			 ));
			?>
			<fieldset class='simplenewsleter-field simplenewsleter-field-option'>
				<select name='simplenewsletter[channel]'>
						<?php
						foreach( $terms as $key => $term ){
							echo "<option value='{$term->term_id}'>{$term->name}</option>";
						}
						?>
				</select>
			</fieldset>
			<?php
		}

		if( $showName ){
			?>
			<fieldset class='simplenewsleter-field simplenewsleter-field-name'>
				<input name='simplenewsletter[name]' type='text' placeholder='<?php echo __("Name", 'simple-newsletter-br') ?>'/>
			</fieldset>
			<?php 
		} ?>
		<fieldset class='simplenewsleter-field simplenewsleter-field-cellphone'>
			<input name='simplenewsletter[cellphone]' data-inputmask="'mask': '<?php echo get_option('simplenewsletter_mobilemask')  ?>'" type='text' placeholder='<?php echo __("Cellphone", 'simple-newsletter-br') ?>' />
		</fieldset>
		<input type="submit" value="<?php echo __("Send", 'simple-newsletter-br') ?>" class='simplenewsleter-field-submit' />
	</form>
	<div class="simplenewsletter_spinner" style="display:none;">
		<img src="<?php echo SN_PATH_URL.'/images/loading_spinner.gif' ?>" style="margin-left:45%;">
	</div>
</div>
<script>
initSimpleNewsletter('.<?php echo $formID; ?>');
</script>