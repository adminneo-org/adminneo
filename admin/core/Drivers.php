<?php

namespace AdminNeo;

class Drivers
{
	/** @var array */
	private static $drivers = [];

	/**
	 * Adds a driver.
	 */
	public static function add(string $id, string $name): void
	{
		self::$drivers[$id] = $name;
	}

	/**
	 * Returns driver name.
	 */
	public static function get(string $id): ?string
	{
		return self::$drivers[$id] ?? null;
	}

	/**
	 * Returns the list of available drivers.
	 *
	 * @return string[]
	 */
	public static function getList(): array
	{
		return self::$drivers;
	}
}

/**
 * @deprecated
 */
function get_drivers(): array
{
	return Drivers::getList();
}

/**
 * @deprecated
 */
function get_driver_name(string $id): ?string
{
	return Drivers::get($id);
}
