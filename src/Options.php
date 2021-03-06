<?php

namespace SUC;

use InvalidArgumentException;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class Options {

	/**
	 * @var array
	 */
	private $options = array();

	/**
	 * @since 1.0
	 *
	 * @param array $options
	 */
	public function __construct( array $options = array() ) {
		$this->options = $options;
	}

	/**
	 * @since 1.0
	 *
	 * @return self
	 */
	public static function newFromGlobals() {
		$GLOBALS['sucgCachePrefix'] = $GLOBALS['wgCachePrefix'] === false ? wfWikiID() : $GLOBALS['wgCachePrefix'];

		$configuration = array(
			'tooltipRequestCacheTTL'       => $GLOBALS['sucgTooltipRequestCacheLifetime'],
			'cachePrefix'                  => $GLOBALS['sucgCachePrefix'],
			'enabledNamespaceWithTemplate' => $GLOBALS['sucgEnabledNamespaceWithTemplate'],
			'enabledForAnonUsers'          => $GLOBALS['sucgEnabledForAnonUser'],
			'backendParserCacheLifetime'   => $GLOBALS['sucgBackendParserCacheLifetime'],
			'backendParserCacheType'       => $GLOBALS['sucgBackendParserCacheType']
		);

		return new self( $configuration );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key, $value ) {
		$this->options[$key] = $value;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has( $key ) {
		return isset( $this->options[$key] ) || array_key_exists( $key, $this->options );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $key
	 *
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function get( $key ) {

		if ( $this->has( $key ) ) {
			return $this->options[$key];
		}

		throw new InvalidArgumentException( "{$key} is an unregistered option" );
	}

}
