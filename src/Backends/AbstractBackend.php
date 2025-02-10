<?php

namespace CacheLibrary\Backends;

abstract class AbstractBackend
{
    /**
     * Set a value in the cache.
     *
     * @param string $key The key of the item to store.
     * @param mixed $value The value to store.
     * @param int $ttl The time-to-live in seconds.
     * @return bool True on success, false on failure.
     */
    abstract public function set(string $key, $value, int $ttl): bool;

    /**
     * Get a value from the cache.
     *
     * @param string $key The key of the item to retrieve.
     * @return mixed The value of the item or null if not found.
     */
    abstract public function get(string $key);

    /**
     * Check if an item exists in the cache.
     *
     * @param string $key The key of the item to check.
     * @return bool True if the item exists, false otherwise.
     */
    abstract public function has(string $key): bool;

    /**
     * Delete an item from the cache.
     *
     * @param string $key The key of the item to delete.
     * @return bool True on success, false on failure.
     */
    abstract public function delete(string $key): bool;

    /**
     * Clear all items from the cache.
     *
     * @return bool True on success, false on failure.
     */
    abstract public function clear(): bool;
}