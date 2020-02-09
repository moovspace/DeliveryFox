<?php
namespace MyApp\App\Hooks;
use \Exception;

class Hooks
{
	/**
	 * Default priority
	 *
	 * @const int
	 */
	const PRIORITY_NEUTRAL = 50;

	/**
	 * Filters - holds list of hooks
	 *
	 * @var array
	 */
	protected $filters = [];

	/**
	 * Actions
	 *
	 * @var array
	 */
	protected $actions = [];

	/**
	 * This class is not allowed to call from outside: private!
	 */
	protected function __construct()
	{ }

	/**
	 * Prevent the object from being cloned.
	 */
	protected function __clone()
	{ }

	/**
	 * Avoid serialization.
	 */
	public function __wakeup()
	{ }

	/**
	 * Returns a Singleton instance of this class.
	 *
	 * @return Hooks
	 */
	public static function GetInstance(): self
	{
		static $instance;

		if (null === $instance) {
			$instance = new self();
		}

		return $instance;
	}

	public function AddAction(string $tag, string $function, int $priority = self::PRIORITY_NEUTRAL, string $include_path = null): bool {
		return $this->AddFilter($tag, $function, $priority, $include_path);
	}

	public function AddFilter(string $tag, string $function, int $priority = self::PRIORITY_NEUTRAL, string $include_path = null): bool
	{
		$idx = $this->Uid($function);

		$this->filters[$tag][$priority][$idx] = [
			'function'     => $function,
			'include_path' => is_string($include_path) ? $include_path : null,
		];

		unset($this->merged_filters[$tag]);

		return true;
	}

	public function RemoveFilter(string $tag, string $function, int $priority = self::PRIORITY_NEUTRAL): bool
	{
		$uid = $this->Uid($function);

		if (empty($this->filters[$tag][$priority][$uid])) {
			return false;
		}

		unset($this->filters[$tag][$priority][$uid]);
		if (empty($this->filters[$tag][$priority])) {
			unset($this->filters[$tag][$priority]);
		}

		// unset($this->merged_filters[$tag]);

		return true;
	}

	public function DoAction(string $tag, $arg = ''): bool
	{
		$this->actions = [];

		foreach ($this->filters[$tag] as $k => $priority)
		{
			// echo "Priority: " . $k;

			foreach ($this->filters[$tag][$k] as $idx => $class)
			{
				if($this->IsStatic($class['function']))
				{
					// echo "Filter static hash: " . $idx . " class: " . $class['function'];

					if(empty($arg))
					{
						// Call class
						call_user_func($class['function']);
					}
					else
					{
						// Call class
						call_user_func($class['function'], $arg);
					}
				}
				else
				{
					throw new Exception("Error class name: ".$class['function']." ! Only static methods: Name\Space\Dir\ClassName::MethodName", 0);
				}
			}
		}

		return true;
	}

	function IsStatic(string $class){
		if(strpos($class,"::") > 0){
			return true;
		}
		return false;
	}

	/**
     * Creat unique id
     *
     * @return string
     */
    function Uid(string $function)
    {
		// Convert to 32 char hash
		return md5($function);
    }

}
?>