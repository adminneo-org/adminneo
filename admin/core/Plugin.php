<?php

namespace AdminNeo;

/**
 * Plugin parent class.
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
abstract class Plugin
{
	/** @var Origin|Pluginer */
	protected $admin;

	/** @var Config */
	protected $config;

	/** @var Settings */
	protected $settings;

	/** @var Locale */
	protected $locale;

	/**
	 * @param Origin|Pluginer $admin
	 */
	public function inject($admin, Config $config, Settings $settings, Locale $locale): void
	{
		$this->admin = $admin;
		$this->config = $config;
		$this->settings = $settings;
		$this->locale = $locale;
	}
}
