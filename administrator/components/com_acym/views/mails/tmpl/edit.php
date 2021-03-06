<?php
defined('_JEXEC') or die('Restricted access');
?><div id="acym__editor__content" class="grid-x acym__content acym__editor__area">
	<div class="cell grid-x grid-margin-x margin-left-0 margin-right-0 align-right">
		<input type="hidden" id="acym__mail__edit__editor" value="<?php echo acym_escape($data['mail']->editor); ?>">
		<input type="hidden" class="acym__wysid__hidden__save__thumbnail" id="editor_thumbnail" name="editor_thumbnail" value="<?php echo acym_escape($data['mail']->thumbnail); ?>" />
		<input type="hidden" id="acym__mail__edit__editor__social__icons" value="<?php echo empty($data['social_icons']) ? '{}' : acym_escape($data['social_icons']); ?>">
		<input type="hidden" id="acym__mail__type" name="mail[type]" value="<?php echo empty($data['mail']->type) ? 'standard' : $data['mail']->type; ?>">
        <?php
        $cancelUrl = empty($data['return']) ? '' : $data['return'];
        echo acym_cancelButton('ACYM_CANCEL', $cancelUrl);

        if ($data['mail']->editor != 'acyEditor') {
            ?>
			<button type="submit" data-task="test" class="cell large-shrink button-secondary medium-6 button acy_button_submit acym__template__save acy_button_submit">
                <?php echo acym_translation('ACYM_SEND_TEST'); ?>
			</button>
            <?php
        }
        echo acym_modal_include(
            '<button type="button" id="acym__template__start-from" class="cell button-secondary button">'.acym_translation('ACYM_START_FROM').'</button>',
            dirname(__FILE__).DS.'choose_template_ajax.php',
            'acym__template__choose__modal',
            $data,
            '',
            '',
            'class="cell large-shrink medium-6"'
        );

        ?>
		<button id="apply" type="button" data-task="apply" class="cell large-shrink button-secondary medium-6 button acym__template__save acy_button_submit">
            <?php echo acym_translation('ACYM_SAVE'); ?>
		</button>
		<button style="display: none;" data-task="apply" class="acy_button_submit" id="data_apply"></button>
		<button id="save" type="button" data-task="save" class="cell large-shrink medium-6 button acy_button_submit">
            <?php echo acym_translation('ACYM_SAVE_EXIT'); ?>
		</button>
		<button style="display: none;" data-task="save" class="acy_button_submit" id="data_save"></button>
	</div>
	<div class="cell grid-x grid-padding-x acym__editor__content__options">
        <?php
        echo !empty($data['return']) ? '<input type="hidden" name="return" value="'.acym_escape($data['return']).'"/>' : '';
        echo !empty($data['fromId']) ? '<input type="hidden" name="fromId" value="'.acym_escape($data['fromId']).'"/>' : '';
        $mainSize = 'xlarge-3 medium-6';
        if ($data['mail']->type == 'notification') {
            echo '<input type="hidden" name="notification" value="'.acym_escape($data['mail']->name).'"/>';
            $mainSize = '';
            $sizes = '';
        } else {
            if ($data['mail']->type == 'automation') {
                $mainSize = 'medium-6';
            }
            $sizes = 'xlarge-3 medium-6';
            ?>
			<div class="cell <?php echo $mainSize; ?>">
				<label>
                    <?php echo acym_translation($data['mail']->type == 'automation' ? 'ACYM_NAME' : 'ACYM_TEMPLATE_NAME'); ?>
					<input name="mail[name]" type="text" class="acy_required_field" value="<?php echo acym_escape($data['mail']->name); ?>" required>
				</label>
			</div>
            <?php
        }
        ?>

		<div class="cell <?php echo $mainSize; ?>">
			<label>
                <?php echo acym_translation('ACYM_EMAIL_SUBJECT'); ?>
				<input name="mail[subject]" type="text" value="<?php echo acym_escape($data['mail']->subject); ?>" <?php echo in_array($data['mail']->type, ['welcome', 'unsubscribe', 'automation']) ? 'required' : ''; ?>>
			</label>
		</div>

        <?php
        if ($data['mail']->type == 'automation') {
            ?>
			<div class="cell"></div>
			<div class="cell <?php echo $sizes; ?>">
				<label>
                    <?php echo acym_translation('ACYM_FROM_NAME'); ?>
					<input name="mail[from_name]" type="text" value="<?php echo acym_escape(empty($data['mail']->from_name) ? $this->config->get('from_name') : $data['mail']->from_name); ?>">
				</label>
			</div>
			<div class="cell <?php echo $sizes; ?>">
				<label>
                    <?php echo acym_translation('ACYM_FROM_EMAIL'); ?>
					<input name="mail[from_email]" type="text" value="<?php echo acym_escape(empty($data['mail']->from_email) ? $this->config->get('from_email') : $data['mail']->from_email); ?>">
				</label>
			</div>
			<div class="cell <?php echo $sizes; ?>">
				<label>
                    <?php echo acym_translation('ACYM_REPLYTO_NAME'); ?>
					<input name="mail[reply_to_name]" type="text" value="<?php echo acym_escape(empty($data['mail']->reply_to_name) ? $this->config->get('replyto_name') : $data['mail']->reply_to_name); ?>">
				</label>
			</div>
			<div class="cell <?php echo $sizes; ?>">
				<label>
                    <?php echo acym_translation('ACYM_REPLYTO_EMAIL'); ?>
					<input name="mail[reply_to_email]" type="text" value="<?php echo acym_escape(empty($data['mail']->reply_to_email) ? $this->config->get('replyto_email') : $data['mail']->reply_to_email); ?>">
				</label>
			</div>
            <?php
        } elseif ($data['mail']->type != 'notification') {
            ?>
			<div class="cell <?php echo $sizes; ?>">
				<label>
                    <?php echo acym_translation('ACYM_TAGS'); ?>
                    <?php echo acym_selectMultiple(
                        $data['allTags'],
                        "template_tags",
                        $data['mail']->tags,
                        ['id' => 'acym__tags__field', 'placeholder' => acym_translation('ACYM_ADD_TAGS')],
                        "name",
                        "name"
                    ); ?>
				</label>
			</div>
			<div class="cell grid-x acym__toggle__arrow">
				<p class="cell medium-shrink acym__toggle__arrow__trigger"><?php echo acym_translation('ACYM_ADVANCED_OPTIONS'); ?> <i class="acymicon-keyboard_arrow_down"></i></p>
				<div class="cell acym__toggle__arrow__contain">
					<div class="grid-x grid-padding-x">
						<div class="cell grid-x medium-6" id="acym__mail__edit__html__stylesheet__container">
							<div class="cell medium-shrink">
								<label for="acym__mail__edit__html__stylesheet">
                                    <?php
                                    echo acym_tooltip(
                                        acym_translation('ACYM_CUSTOM_ADD_STYLESHEET'),
                                        acym_translation('ACYM_STYLESHEET_HTML_DESC')
                                    );
                                    $stylesheet = empty($data['mail']->stylesheet) ? '' : $data['mail']->stylesheet;
                                    ?>
								</label>
							</div>
							<textarea name="editor_stylesheet" id="acym__mail__edit__html__stylesheet" cols="30" rows="15" type="text"><?php echo $stylesheet; ?></textarea>
						</div>
						<div class="cell medium-auto">
							<label for="acym__mail__edit__custom__header"><?php echo acym_translation('ACYM_CUSTOM_HEADERS'); ?></label>
							<textarea id="acym__mail__edit__custom__header" name="editor_headers" cols="30" rows="15" type="text"><?php echo acym_escape($data['mail']->headers); ?></textarea>
						</div>

						<div class="cell grid-x">
							<div class="cell medium-shrink">
								<label for="acym__mail__edit__preheader">
                                    <?php
                                    echo acym_tooltip(
                                        acym_translation('ACYM_EMAIL_PREHEADER'),
                                        acym_translation('ACYM_EMAIL_PREHEADER_DESC')
                                    ); ?>
								</label>
							</div>
							<input id="acym__mail__edit__preheader" name="mail[preheader]" type="text" value="<?php echo acym_escape($data['mail']->preheader); ?>">
						</div>
					</div>
				</div>
			</div>
            <?php
        }
        ?>
	</div>
</div>
<input type="hidden" name="mail[id]" value="<?php echo acym_escape($data['mail']->id); ?>" />
<input type="hidden" name="id" value="<?php echo acym_escape($data['mail']->id); ?>" />
<input type="hidden" name="thumbnail" value="<?php echo empty($data['mail']->thumbnail) ? '' : acym_escape($data['mail']->thumbnail); ?>" />
<?php
acym_formOptions();

$editor = acym_get('helper.editor');
$editor->content = $data['mail']->body;
$editor->autoSave = !empty($data['mail']->autosave) ? $data['mail']->autosave : '';
if (!empty($data['mail']->editor)) $editor->editor = $data['mail']->editor;
if (!empty($data['mail']->id)) $editor->mailId = $data['mail']->id;
if (!empty($data['mail']->type)) $editor->automation = $data['isAutomationAdmin'];
if (!empty($data['mail']->settings)) $editor->settings = $data['mail']->settings;
if (!empty($data['mail']->stylesheet)) $editor->stylesheet = $data['mail']->stylesheet;
echo $editor->display();

