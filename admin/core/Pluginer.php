<?php

namespace AdminNeo;

/**
 * Admin/Editor customization allowing usage of plugins.
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class Pluginer
{
	/** @var true[] Map of methods that plugins cannot customize. */
	private const InternalMethods = [
		"inject" => true,
		"getConfig" => true,
	];

	/** @var true[] Map of methods that expect the value to be appended to the result. */
	private const AppendMethods = [
		"getErrors" => true,
		"getFieldFunctions" => true,
		"getDumpOutputs" => true,
		"getDumpFormats" => true,
		"getSettingsRows" => true,
	];

	/** @var Plugin[] */
	private $plugins;

	/** @var Plugin[][] List of plugins for each method. */
	private $hooks = [];

	/**
	 * @param Origin $admin Admin or Editor instance.
	 * @param Plugin[] $plugins List of plugin instances.
	 */
	public function __construct(Origin $admin, array $plugins)
	{
		$this->plugins = $plugins;

		// Find plugins for all public methods.
		foreach (get_class_methods(Origin::class) as $method) {
			$this->hooks[$method] = [];

			if (!(self::InternalMethods[$method] ?? false)) {
				foreach ($plugins as $plugin) {
					if (method_exists($plugin, $method)) {
						$this->hooks[$method][] = $plugin;
					}
				}
			}

			if (self::AppendMethods[$method] ?? false) {
				array_unshift($this->hooks[$method], $admin);
			} else {
				$this->hooks[$method][] = $admin;
			}
		}
	}

	/**
	 * @return Plugin[]
	 */
	public function getPlugins(): array
	{
		return $this->plugins;
	}

	/**
	 * @return mixed
	 */
	public function __call(string $name, array $params)
	{
		$append = self::AppendMethods[$name] ?? false;
		$result = $append ? [] : null;

		assert(isset($this->hooks[$name]), "Calling unknown plugin method: $name");

		foreach ($this->hooks[$name] as $plugin) {
			$value = call_user_func_array([$plugin, $name], $params);

			if ($value !== null) {
				if ($append) {
					$result += $value;
				} else {
					// Non-null value from a non-appending method short-circuits the other plugins.
					return $value;
				}
			}
		}

		return $result;
	}

	public function updateCspHeader(array &$csp): void
	{
		$this->__call(__FUNCTION__, [&$csp]);
	}

	public function detectJson(string $fieldType, &$value, ?bool $pretty = null): bool
	{
		return $this->__call(__FUNCTION__, [$fieldType, &$value, $pretty]);
	}
}
