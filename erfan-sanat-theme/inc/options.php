<?php
/**
 * Theme Options Storage, Caching, Sanitization, and Helper API
 *
 * Implements single-row serialized option storage (`erfan_sanat_options`)
 * with static per-request caching and the `es_opt()` helper.
 *
 * @package ErfanSanat
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default values for all schema fields.
 *
 * @return array<string, mixed>
 */
function erfan_sanat_get_default_options(): array {
	static $defaults = null;
	if ( null !== $defaults ) {
		return $defaults;
	}

	$defaults = array(
		'_schema_version' => ES_THEME_VERSION,
	);
	$schema   = erfan_sanat_get_options_schema();
	foreach ( $schema as $key => $field ) {
		$defaults[ $key ] = $field['default'] ?? '';
	}

	return $defaults;
}

/**
 * Manages static per-request cache for theme options.
 *
 * @param array<string, mixed>|null $new_cache Optional new cache state or false to flush.
 * @param bool                      $flush     Whether to clear the static cache.
 * @return array<string, mixed>
 */
function erfan_sanat_options_cache( ?array $new_cache = null, bool $flush = false ): array {
	static $cached_options = null;

	if ( $flush ) {
		$cached_options = null;
	}

	if ( null !== $new_cache ) {
		$cached_options = $new_cache;
		return $cached_options;
	}

	if ( null === $cached_options ) {
		$defaults = erfan_sanat_get_default_options();
		$stored   = get_option( ES_OPTION_KEY, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		$cached_options = wp_parse_args( $stored, $defaults );
	}

	return $cached_options;
}

/**
 * Global helper to retrieve a theme option or all options from static cache.
 *
 * @param string $key     Option key. Empty string returns full options array.
 * @param mixed  $default Optional fallback value if key is not defined.
 * @return mixed
 */
function es_opt( string $key = '', $default = null ) {
	$options = erfan_sanat_options_cache();

	if ( '' === $key ) {
		return $options;
	}

	if ( array_key_exists( $key, $options ) ) {
		return $options[ $key ];
	}

	$defaults = erfan_sanat_get_default_options();
	if ( array_key_exists( $key, $defaults ) ) {
		return $defaults[ $key ];
	}

	return $default;
}

/**
 * Alias for es_opt() with prefixed naming convention.
 *
 * @param string $key     Option key.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function erfan_sanat_get_option( string $key = '', $default = null ) {
	return es_opt( $key, $default );
}

/**
 * Sanitizes boolean/toggle field values.
 *
 * @param mixed $value Raw input value.
 * @return bool
 */
function erfan_sanat_sanitize_bool( $value ): bool {
	if ( is_bool( $value ) ) {
		return $value;
	}
	if ( is_string( $value ) ) {
		$lower = strtolower( trim( $value ) );
		return in_array( $lower, array( '1', 'true', 'yes', 'on' ), true );
	}
	return ! empty( $value );
}

/**
 * Sanitizes multiselect array values against allowed options.
 *
 * @param mixed                $value Raw input.
 * @param array<string, mixed> $field Field schema definition.
 * @return array<int, string>
 */
function erfan_sanat_sanitize_multiselect( $value, array $field = array() ): array {
	if ( ! is_array( $value ) ) {
		return array();
	}
	$allowed = isset( $field['options'] ) && is_array( $field['options'] ) ? array_keys( $field['options'] ) : array();
	$clean   = array();
	foreach ( $value as $item ) {
		$key = sanitize_key( (string) $item );
		if ( '' !== $key && ( empty( $allowed ) || in_array( $key, $allowed, true ) ) ) {
			$clean[] = $key;
		}
	}
	return array_values( array_unique( $clean ) );
}

/**
 * Sanitizes gallery attachment IDs or image URLs.
 *
 * @param mixed $value Raw gallery input (array or comma-separated string).
 * @return array<int, int|string>
 */
function erfan_sanat_sanitize_gallery( $value ): array {
	if ( is_string( $value ) ) {
		$value = array_filter( array_map( 'trim', explode( ',', $value ) ) );
	}
	if ( ! is_array( $value ) ) {
		return array();
	}
	$clean = array();
	foreach ( $value as $item ) {
		if ( is_numeric( $item ) ) {
			$id = absint( $item );
			if ( $id > 0 ) {
				$clean[] = $id;
			}
		} elseif ( is_string( $item ) && '' !== trim( $item ) ) {
			$url = esc_url_raw( $item );
			if ( '' !== $url ) {
				$clean[] = $url;
			}
		}
	}
	return $clean;
}

/**
 * Sanitizes repeater field rows based on sub-field definitions.
 *
 * @param mixed                $value Raw repeater array.
 * @param array<string, mixed> $field Field schema definition.
 * @return array<int, array<string, string>>
 */
function erfan_sanat_sanitize_repeater( $value, array $field = array() ): array {
	if ( ! is_array( $value ) ) {
		return array();
	}
	$subfields = isset( $field['fields'] ) && is_array( $field['fields'] ) ? $field['fields'] : array();
	$clean     = array();

	foreach ( $value as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}
		$clean_row = array();
		$has_data  = false;

		if ( ! empty( $subfields ) ) {
			foreach ( $subfields as $sub_key => $sub_cfg ) {
				$raw_val = isset( $row[ $sub_key ] ) ? (string) $row[ $sub_key ] : '';
				$sub_type = $sub_cfg['type'] ?? 'text';
				if ( 'textarea' === $sub_type ) {
					$sanitized = sanitize_textarea_field( $raw_val );
				} elseif ( 'url' === $sub_type ) {
					$sanitized = esc_url_raw( $raw_val );
				} else {
					$sanitized = sanitize_text_field( $raw_val );
				}
				$clean_row[ $sub_key ] = $sanitized;
				if ( '' !== $sanitized ) {
					$has_data = true;
				}
			}
		} else {
			foreach ( $row as $k => $v ) {
				$clean_k               = sanitize_key( (string) $k );
				$clean_v               = sanitize_text_field( (string) $v );
				$clean_row[ $clean_k ] = $clean_v;
				if ( '' !== $clean_v ) {
					$has_data = true;
				}
			}
		}

		if ( $has_data ) {
			$clean[] = $clean_row;
		}
	}

	return $clean;
}

/**
 * Sanitizes a single option value according to its schema definition.
 *
 * @param string $key   Option key.
 * @param mixed  $value Raw input value.
 * @return mixed
 */
function erfan_sanat_sanitize_option_field( string $key, $value ) {
	$schema = erfan_sanat_get_options_schema();
	if ( ! isset( $schema[ $key ] ) ) {
		return null;
	}

	$field    = $schema[ $key ];
	$type     = $field['type'] ?? 'text';
	$default  = $field['default'] ?? '';
	$Required = $field['capability'] ?? 'manage_options';

	if ( is_user_logged_in() && ! current_user_can( $Required ) ) {
		return es_opt( $key, $default );
	}

	switch ( $type ) {
		case 'toggle':
			return erfan_sanat_sanitize_bool( $value );

		case 'number':
		case 'range':
			$num = is_numeric( $value ) ? (int) $value : (int) $default;
			if ( isset( $field['min'] ) && $num < (int) $field['min'] ) {
				$num = (int) $field['min'];
			}
			if ( isset( $field['max'] ) && $num > (int) $field['max'] ) {
				$num = (int) $field['max'];
			}
			return $num;

		case 'color':
			$hex = sanitize_hex_color( (string) $value );
			return $hex ? $hex : (string) $default;

		case 'email':
			$email = sanitize_email( (string) $value );
			return '' !== $email ? $email : (string) $default;

		case 'url':
		case 'image':
			$str = trim( (string) $value );
			if ( '' === $str ) {
				return '';
			}
			if ( str_starts_with( $str, '#' ) || str_starts_with( $str, '/' ) ) {
				return sanitize_text_field( $str );
			}
			return esc_url_raw( $str );

		case 'textarea':
			return sanitize_textarea_field( (string) $value );

		case 'editor':
			return wp_kses_post( (string) $value );

		case 'select':
		case 'icon':
		case 'font':
			$val     = sanitize_text_field( (string) $value );
			$allowed = isset( $field['options'] ) && is_array( $field['options'] ) ? array_keys( $field['options'] ) : array();
			if ( ! empty( $allowed ) && ! in_array( $val, $allowed, true ) ) {
				return (string) $default;
			}
			return $val;

		case 'multiselect':
			return erfan_sanat_sanitize_multiselect( $value, $field );

		case 'gallery':
			return erfan_sanat_sanitize_gallery( $value );

		case 'repeater':
			return erfan_sanat_sanitize_repeater( $value, $field );

		case 'text':
		default:
			return sanitize_text_field( (string) $value );
	}
}

/**
 * Sanitizes a full or partial array of theme options and merges with existing stored options.
 *
 * @param mixed       $input      Incoming options array.
 * @param string|null $active_tab Optional active tab slug so unchecked toggles on that tab are set to false.
 * @return array<string, mixed>
 */
function erfan_sanat_sanitize_options_array( $input, ?string $active_tab = null ): array {
	$current = erfan_sanat_options_cache();
	if ( ! is_array( $input ) ) {
		return $current;
	}

	$schema  = erfan_sanat_get_options_schema();
	$updated = $current;

	foreach ( $schema as $key => $field ) {
		$field_tab = $field['tab'] ?? 'general';
		$type      = $field['type'] ?? 'text';

		if ( array_key_exists( $key, $input ) ) {
			$updated[ $key ] = erfan_sanat_sanitize_option_field( $key, $input[ $key ] );
		} elseif ( null !== $active_tab && $active_tab === $field_tab ) {
			if ( 'toggle' === $type ) {
				$updated[ $key ] = false;
			} elseif ( 'multiselect' === $type || 'gallery' === $type || 'repeater' === $type ) {
				$updated[ $key ] = array();
			}
		}
	}

	$updated['_schema_version'] = ES_THEME_VERSION;
	return $updated;
}

/**
 * Saves sanitized options to the single database row and updates the static cache.
 *
 * @param array<string, mixed> $new_options Options to persist.
 * @param string|null          $active_tab  Optional tab scope.
 * @return bool
 */
function erfan_sanat_save_options( array $new_options, ?string $active_tab = null ): bool {
	$sanitized = erfan_sanat_sanitize_options_array( $new_options, $active_tab );
	update_option( ES_OPTION_KEY, $sanitized, true );
	erfan_sanat_options_cache( $sanitized );
	return true;
}

/**
 * Resets either a single tab's options or all theme options to defaults.
 *
 * @param string|null $tab Tab key to reset, or null/empty to reset all.
 * @return array<string, mixed>
 */
function erfan_sanat_reset_options( ?string $tab = null ): array {
	$defaults = erfan_sanat_get_default_options();

	if ( null === $tab || '' === $tab || 'all' === $tab ) {
		update_option( ES_OPTION_KEY, $defaults, true );
		return erfan_sanat_options_cache( $defaults );
	}

	$current = erfan_sanat_options_cache();
	$schema  = erfan_sanat_get_options_schema();
	foreach ( $schema as $key => $field ) {
		if ( ( $field['tab'] ?? '' ) === $tab ) {
			$current[ $key ] = $defaults[ $key ];
		}
	}
	update_option( ES_OPTION_KEY, $current, true );
	return erfan_sanat_options_cache( $current );
}

/**
 * Initializes the single theme option row on theme activation / migration if needed.
 */
function erfan_sanat_maybe_migrate_options(): void {
	$stored = get_option( ES_OPTION_KEY, false );
	if ( false === $stored || ! is_array( $stored ) ) {
		$defaults = erfan_sanat_get_default_options();
		update_option( ES_OPTION_KEY, $defaults, true );
		erfan_sanat_options_cache( $defaults );
		return;
	}

	$stored_version = $stored['_schema_version'] ?? '0.0.0';
	if ( version_compare( (string) $stored_version, ES_THEME_VERSION, '<' ) ) {
		$merged                    = wp_parse_args( $stored, erfan_sanat_get_default_options() );
		$merged['_schema_version'] = ES_THEME_VERSION;
		update_option( ES_OPTION_KEY, $merged, true );
		erfan_sanat_options_cache( $merged );
	}
}
add_action( 'after_switch_theme', 'erfan_sanat_maybe_migrate_options' );
add_action( 'admin_init', 'erfan_sanat_maybe_migrate_options' );
