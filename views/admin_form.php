<div class="wrap">
	<form method="post">
		<div id="icon-options-general" class="icon32"></div>
		<h2>Simple Newsletter</h2>
		<?php settings_errors(); ?>

		<div id="poststuff">

			<div id="post-body" class="metabox-holder columns-2">

				<!-- main content -->
				<div id="post-body-content">

					<div class="meta-box-sortables ui-sortable">

						<div class="postbox">
							<h3><span><?php echo __("Implementação", 'simple-newsletter-br'); ?></span></h3>
							<div class="inside">
								<p><?php echo __("Utilize o Shortcode abaixo onde você quer que apareça o formulário da Newsletter", 'simple-newsletter-br'); ?></p>
								<code>[simplenewsletter]</code>
								<p><?php echo __("O restante, configure no formulário aqui embaixo.", 'simple-newsletter-br'); ?></p>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

						<div class="postbox">
							<h3><span><?php echo __("Configurações", 'simple-newsletter-br'); ?></span></h3>
							<div class="inside">
								<p></p>
								<table class="form-table" id="configure">
									<tbody>
										<tr valign="top">
											<th scope="row"><?php echo __('Double Opt-in (Confirmação)', 'simple-newsletter-br') ?></th>
											<td>
												<select name="simplenewsletter_dbloptin" class="large-text">
													<option value='1' <?php selected( get_option("simplenewsletter_dbloptin"), 1, true); ?>><?php echo __("Ativado", 'simple-newsletter-br'); ?></option>
													<option value='0' <?php selected( get_option("simplenewsletter_dbloptin"), 0, true); ?>><?php echo __("Desativado", 'simple-newsletter-br'); ?></option>
												</select>
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Logo ( URL Completa )', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_logo" id="" type="text" value="<?php echo get_option("simplenewsletter_logo"); ?>" class="large-text" />
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Exibir Campo Nome', 'simple-newsletter-br') ?></th>
											<td>
												<select name="simplenewsletter_showname" class="large-text">
													<option value='1' <?php selected( get_option("simplenewsletter_showname"), 1, true); ?>><?php echo __('Sim', 'simple-newsletter-br') ?></option>
													<option value='0' <?php selected( get_option("simplenewsletter_showname"), 0, true); ?>><?php echo __('Não', 'simple-newsletter-br') ?></option>
												</select>
											</td>
										</tr>
										
										<tr valign="top">
											<th scope="row"><?php echo __('Mensagem de Sucesso', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_successmessage" id="" type="text" value="<?php echo get_option("simplenewsletter_successmessage"); ?>" class="large-text" />
											</td>
										</tr>
										<tr valign="top">
											<th scope="row"><?php echo __('Mensagem exibida após confirmação', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_confirmedmessage" id="" type="text" value="<?php echo get_option("simplenewsletter_confirmedmessage"); ?>" class="large-text" />
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Texto do Email', 'simple-newsletter-br') ?></th>
											<td>
												<input name="simplenewsletter_confirmationemail" id="" type="text" value="<?php echo get_option("simplenewsletter_confirmationemail"); ?>" class="large-text" />
											</td>
										</tr>

										<tr valign="top">
											<th scope="row"><?php echo __('Exibir mensagem', 'simple-newsletter-br') ?></th>
											<td>
												<select name="simplenewsletter_showon" class="large-text">
													<option value='prepend' <?php selected( get_option("simplenewsletter_showon"), 'prepend', true); ?>><?php echo __('Acima do formulário', 'simple-newsletter-br') ?></option>
													<option value='append' <?php selected( get_option("simplenewsletter_showon"), 'append', true); ?>><?php echo __('Abaixo do Formulário', 'simple-newsletter-br') ?></option>
													<option value='substitute' <?php selected( get_option("simplenewsletter_showon"), 'substitute', true); ?>><?php echo __('Substituir Formulário', 'simple-newsletter-br') ?></option>
												</select>
											</td>
										</tr>
									</tbody>
								</table>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

						<div class="postbox">
							<h3><span><?php echo __("Fazendo seu próprio template", 'simple-newsletter-br'); ?></span></h3>
							<div class="inside">
								<p><?php echo __("Você pode fazer o seu próprio template html para o email, e colocar o arquivo HTML com o nome 'email_template.html' na raiz do seu tema.", 'simple-newsletter-br'); ?></p>
								<p><?php echo __("Utilize as seguintes marcações para exibir os dados:", 'simple-newsletter-br'); ?></p>
								<ol>
									<li><?php echo __('Logotipo:', 'simple-newsletter-br') ?> <code>{logo}</code></li>
									<li><?php echo __('Nome preenchido no formulário:', 'simple-newsletter-br') ?> <code>{name}</code></li>
									<li><?php echo __('Texto do email (Configurado no formulário acima):', 'simple-newsletter-br') ?> <code>{text_confirmation}</code></li>
									<li><?php echo __('Link de confirmação:', 'simple-newsletter-br') ?> <code>{button}</code></li>
									<li><?php echo __('Link do site:', 'simple-newsletter-br') ?> <code>{sitelink}</code></li>
									<li><?php echo __('Nome do Site:', 'simple-newsletter-br') ?> <code>{sitename}</code></li>
								</ol>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

					</div> <!-- .meta-box-sortables .ui-sortable -->

				</div> <!-- post-body-content -->

				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">

					<div class="meta-box-sortables">

						<div class="postbox">

							<div class="inside">
								<?php submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) ?>
							</div> <!-- .inside -->

						</div> <!-- .postbox -->

					</div> <!-- .meta-box-sortables -->

				</div> <!-- #postbox-container-1 .postbox-container -->

			</div> <!-- #post-body .metabox-holder .columns-2 -->

			<br class="clear">
		</div> <!-- #poststuff -->
	</form>	
</div> <!-- .wrap -->