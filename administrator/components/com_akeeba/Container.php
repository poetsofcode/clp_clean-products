<?php
/**
 * @package   akeebabackup
 * @copyright Copyright (c)2006-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\Backup\Admin;

defined('_JEXEC') or die;

use Akeeba\Backup\Admin\Helper\JsBundler;
use FOF30\Container\Container as FOFContainer;

/**
 * Akeeba Backup backend component Container
 *
 * @property-read  JsBundler  $jsBundler  JavaScript bundling and inclusion service
 *
 * @since  7.1.0
 */
class Container extends FOFContainer
{
	/** @inheritDoc */
	public function __construct(array $values = [])
	{
		parent::__construct($values);

		// Component toolbar provider
		if (!isset($this['jsBundler']))
		{
			$this['jsBundler'] = function (FOFContainer $c)
			{
				return new JsBundler($c);
			};
		}
	}
}