<?php
/**
 * Item image template.
 *
 * @var $args
 *
 * @package visual-portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! isset( $args['image'] ) || ! $args['image'] ) {
    return;
}

// phpcs:ignore
echo $args['image'];
