<?php


namespace App\Actions;


use League\Flysystem\AdapterInterface;

class FileSystem extends Action
{
	/**
	 * Get a filesystem handle using the given adapter
	 * @param string $adapterClass
	 * @return \League\Flysystem\Filesystem
	 * @throws \DI\DependencyException
	 * @throws \DI\NotFoundException
	 */
	public function for(string $adapterClass): \League\Flysystem\Filesystem
	{
		/**
		 * @var AdapterInterface $adapter
		 */
		$adapter = $this->container->get($adapterClass);
		return new \League\Flysystem\Filesystem($adapter);
	}
}
