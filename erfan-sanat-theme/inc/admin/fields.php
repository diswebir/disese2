<?php
/**
 * Generic Schema-Driven Admin Field Renderer
 *
 * Renders all 16 required field types dynamically from `inc/options-schema.php`:
 * text, textarea, number, url, email, color, toggle, select,
 * multiselect, image, gallery, repeater, editor, icon, font, range.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders a single option field row using its schema definition.
 *
 * @param string               $key   Option key.
 * @param array<string, mixed> $field Field schema configuration.
 * @param mixed                $value Current stored or default value.
 */
function erfan_sanat_render_schema_field( string $key, array $field, $value ): void {
	$type       = $field['type'] ?? 'text';
	$label      = $field['label'] ?? $key;
	$desc       = $field['desc'] ?? '';
	$field_id   = 'es_field_' . esc_attr( $key );
	$field_name = ES_OPTION_KEY . '[' . esc_attr( $key ) . ']';
	?>
	<div class="es-admin-field-row es-field-type-<?php echo esc_attr( $type ); ?>" data-field-key="<?php echo esc_attr( $key ); ?>">
		<div class="es-admin-field-label">
			<label for="<?php echo esc_attr( $field_id ); ?>">
				<?php echo esc_html( $label ); ?>
			</label>
			<?php if ( '' !== $desc ) : ?>
				<p class="es-field-description"><?php echo esc_html( $desc ); ?></p>
			<?php endif; ?>
		</div>
		<div class="es-admin-field-control">
			<?php
			switch ( $type ) :
				case 'text':
				case 'url':
				case 'email':
					$input_type = in_array( $type, array( 'url', 'email' ), true ) ? $type : 'text';
					$dir        = in_array( $type, array( 'url', 'email' ), true ) ? 'ltr' : 'rtl';
					?>
					<input
						type="<?php echo esc_attr( $input_type ); ?>"
						id="<?php echo esc_attr( $field_id ); ?>"
						name="<?php echo esc_attr( $field_name ); ?>"
						value="<?php echo esc_attr( (string) $value ); ?>"
						class="es-input es-input-<?php echo esc_attr( $type ); ?>"
						dir="<?php echo esc_attr( $dir ); ?>"
					/>
					<?php
					break;

				case 'number':
					$min  = isset( $field['min'] ) ? 'min="' . (int) $field['min'] . '"' : '';
					$max  = isset( $field['max'] ) ? 'max="' . (int) $field['max'] . '"' : '';
					$step = isset( $field['step'] ) ? 'step="' . (int) $field['step'] . '"' : 'step="1"';
					?>
					<input
						type="number"
						id="<?php echo esc_attr( $field_id ); ?>"
						name="<?php echo esc_attr( $field_name ); ?>"
						value="<?php echo esc_attr( (string) $value ); ?>"
						class="es-input es-input-number"
						<?php echo $min . ' ' . $max . ' ' . $step; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					/>
					<?php
					break;

				case 'range':
					$min  = isset( $field['min'] ) ? (int) $field['min'] : 0;
					$max  = isset( $field['max'] ) ? (int) $field['max'] : 100;
					$step = isset( $field['step'] ) ? (int) $field['step'] : 1;
					?>
					<div class="es-range-wrapper">
						<input
							type="range"
							id="<?php echo esc_attr( $field_id ); ?>"
							name="<?php echo esc_attr( $field_name ); ?>"
							value="<?php echo esc_attr( (string) $value ); ?>"
							min="<?php echo esc_attr( (string) $min ); ?>"
							max="<?php echo esc_attr( (string) $max ); ?>"
							step="<?php echo esc_attr( (string) $step ); ?>"
							class="es-range-input"
							data-range-output="<?php echo esc_attr( $field_id . '_val' ); ?>"
						/>
						<output id="<?php echo esc_attr( $field_id . '_val' ); ?>" class="es-range-badge">
							<?php echo esc_html( (string) $value ); ?>px
						</output>
					</div>
					<?php
					break;

				case 'textarea':
					?>
					<textarea
						id="<?php echo esc_attr( $field_id ); ?>"
						name="<?php echo esc_attr( $field_name ); ?>"
						rows="4"
						class="es-textarea"
					><?php echo esc_textarea( (string) $value ); ?></textarea>
					<?php
					break;

				case 'editor':
					wp_editor(
						(string) $value,
						$field_id,
						array(
							'textarea_name' => $field_name,
							'textarea_rows' => 5,
							'media_buttons' => false,
							'teeny'         => true,
						)
					);
					break;

				case 'color':
					$hex_val = sanitize_hex_color( (string) $value ) ?: (string) ( $field['default'] ?? '#f59e0b' );
					?>
					<div class="es-color-picker-group">
						<input
							type="color"
							id="<?php echo esc_attr( $field_id ); ?>"
							value="<?php echo esc_attr( $hex_val ); ?>"
							class="es-color-swatch"
							data-target-input="<?php echo esc_attr( $field_id . '_hex' ); ?>"
						/>
						<input
							type="text"
							id="<?php echo esc_attr( $field_id . '_hex' ); ?>"
							name="<?php echo esc_attr( $field_name ); ?>"
							value="<?php echo esc_attr( $hex_val ); ?>"
							class="es-input es-color-hex-input"
							dir="ltr"
							maxlength="7"
						/>
						<span class="es-color-live-preview" style="background-color: <?php echo esc_attr( $hex_val ); ?>;"></span>
					</div>
					<?php
					break;

				case 'toggle':
					$checked = ! empty( $value );
					?>
					<label class="es-switch" for="<?php echo esc_attr( $field_id ); ?>">
						<input
							type="checkbox"
							id="<?php echo esc_attr( $field_id ); ?>"
							name="<?php echo esc_attr( $field_name ); ?>"
							value="1"
							<?php checked( $checked ); ?>
						/>
						<span class="es-switch-slider"></span>
						<span class="es-switch-status"><?php echo $checked ? esc_html__( 'فعال', 'erfan-sanat' ) : esc_html__( 'غیرفعال', 'erfan-sanat' ); ?></span>
					</label>
					<?php
					break;

				case 'select':
				case 'font':
				case 'icon':
					$options = isset( $field['options'] ) && is_array( $field['options'] ) ? $field['options'] : array();
					?>
					<div class="es-select-wrap">
						<select id="<?php echo esc_attr( $field_id ); ?>" name="<?php echo esc_attr( $field_name ); ?>" class="es-select">
							<?php foreach ( $options as $opt_key => $opt_label ) : ?>
								<option value="<?php echo esc_attr( (string) $opt_key ); ?>" <?php selected( (string) $value, (string) $opt_key ); ?>>
									<?php echo esc_html( (string) $opt_label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<?php if ( 'icon' === $type ) : ?>
							<span class="es-icon-preview-box">
								<?php echo erfan_sanat_icon( (string) $value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						<?php endif; ?>
					</div>
					<?php
					break;

				case 'multiselect':
					$options  = isset( $field['options'] ) && is_array( $field['options'] ) ? $field['options'] : array();
					$selected = is_array( $value ) ? $value : array();
					?>
					<div class="es-multiselect-group" id="<?php echo esc_attr( $field_id ); ?>">
						<?php foreach ( $options as $opt_key => $opt_label ) : ?>
							<label class="es-checkbox-pill">
								<input
									type="checkbox"
									name="<?php echo esc_attr( $field_name ); ?>[]"
									value="<?php echo esc_attr( (string) $opt_key ); ?>"
									<?php checked( in_array( (string) $opt_key, $selected, true ) ); ?>
								/>
								<span><?php echo esc_html( (string) $opt_label ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
					<?php
					break;

				case 'image':
					$img_url = (string) $value;
					?>
					<div class="es-media-field-wrapper">
						<div class="es-media-input-row">
							<input
								type="text"
								id="<?php echo esc_attr( $field_id ); ?>"
								name="<?php echo esc_attr( $field_name ); ?>"
								value="<?php echo esc_attr( $img_url ); ?>"
								class="es-input es-media-url-input"
								dir="ltr"
							/>
							<button type="button" class="button es-media-upload-btn" data-target="#<?php echo esc_attr( $field_id ); ?>">
								<?php esc_html_e( 'انتخاب تصویر', 'erfan-sanat' ); ?>
							</button>
						</div>
						<?php if ( '' !== $img_url ) : ?>
							<div class="es-media-preview">
								<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $label ); ?>" />
							</div>
						<?php endif; ?>
					</div>
					<?php
					break;

				case 'gallery':
					$gallery_items = is_array( $value ) ? implode( ',', $value ) : (string) $value;
					?>
					<div class="es-gallery-field-wrapper">
						<input
							type="text"
							id="<?php echo esc_attr( $field_id ); ?>"
							name="<?php echo esc_attr( $field_name ); ?>"
							value="<?php echo esc_attr( $gallery_items ); ?>"
							class="es-input es-gallery-input"
							dir="ltr"
							placeholder="ID1, ID2, ..."
						/>
						<button type="button" class="button es-gallery-upload-btn" data-target="#<?php echo esc_attr( $field_id ); ?>">
							<?php esc_html_e( 'مدیریت گالری تصاویر', 'erfan-sanat' ); ?>
						</button>
					</div>
					<?php
					break;

				case 'repeater':
					$rows      = is_array( $value ) ? array_values( $value ) : array();
					$subfields = isset( $field['fields'] ) && is_array( $field['fields'] ) ? $field['fields'] : array();
					?>
					<div class="es-repeater-container" data-field-name="<?php echo esc_attr( $field_name ); ?>">
						<div class="es-repeater-rows">
							<?php foreach ( $rows as $row_index => $row_data ) : ?>
								<div class="es-repeater-row">
									<?php foreach ( $subfields as $sub_key => $sub_cfg ) : ?>
										<div class="es-repeater-col">
											<label><?php echo esc_html( $sub_cfg['label'] ?? $sub_key ); ?></label>
											<input
												type="text"
												name="<?php echo esc_attr( $field_name . '[' . (int) $row_index . '][' . $sub_key . ']' ); ?>"
												value="<?php echo esc_attr( (string) ( $row_data[ $sub_key ] ?? '' ) ); ?>"
												class="es-input"
											/>
										</div>
									<?php endforeach; ?>
									<button type="button" class="button-link-delete es-repeater-remove-row">
										<?php esc_html_e( 'حذف', 'erfan-sanat' ); ?>
									</button>
								</div>
							<?php endforeach; ?>
						</div>
						<template class="es-repeater-template">
							<div class="es-repeater-row">
								<?php foreach ( $subfields as $sub_key => $sub_cfg ) : ?>
									<div class="es-repeater-col">
										<label><?php echo esc_html( $sub_cfg['label'] ?? $sub_key ); ?></label>
										<input
											type="text"
											name="<?php echo esc_attr( $field_name . '[__INDEX__][' . $sub_key . ']' ); ?>"
											value=""
											class="es-input"
										/>
									</div>
								<?php endforeach; ?>
								<button type="button" class="button-link-delete es-repeater-remove-row">
									<?php esc_html_e( 'حذف', 'erfan-sanat' ); ?>
								</button>
							</div>
						</template>
						<button type="button" class="button es-repeater-add-row">
							+ <?php esc_html_e( 'افزودن ردیف جدید', 'erfan-sanat' ); ?>
						</button>
					</div>
					<?php
					break;
			endswitch;
			?>
		</div>
	</div>
	<?php
}
