<?php
/**
 * Takes care of cacheing for lazyloading libraries/objects.
 *
 * @package default
 * @author Johnny Karhinen
 **/
interface Cacheable {
	/**
	 * Injects the cached data into the object.
	 *
	 * @return bool
	 * @author Johnny Karhinen
	 **/
	public function injectCacheData(Array $cachedData);
	
	/**
	 * Returns the data to be cached as an array.
	 *
	 * @return array
	 * @author Johnny Karhinen
	 **/
	public function retrieveCacheData();
}