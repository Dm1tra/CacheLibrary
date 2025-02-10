<?php

namespace CacheLibrary;

class Cache
{
    private $backend;

    public function __construct(string $backendType, array $options = [])
    {
        switch ($backendType) {
            case 'file':
                $this->backend = new Backends\FileBackend($options);
                break;
            case 'redis':
                $this->backend = new Backends\RedisBackend($options);
                break;
            case 'memcached':
                $this->backend = new Backends\MemcachedBackend($options);
                break;
            default:
                throw new \InvalidArgumentException("Unsupported backend type: $backendType");
        }
    }

    /**
     * Set a value in the cache.
     *
     * @param string $key The key of the item to store.
     * @param mixed $value The value to store.
     * @param int $ttl The time-to-live in seconds.
     * @return bool True on success, false on failure.
     */
    public function set(string $key, $value, int $ttl = 3600): bool
    {
        return $this->backend->set($key, $value, $ttl);
    }

    /**
     * Get a value from the cache.
     *
     * @param string $key The key of the item to retrieve.
     * @return mixed The value of the item or null if not found.
     */
    public function get(string $key)
    {
        return $this->backend->get($key);
    }

    /**
     * Check if an item exists in the cache.
     *
     * @param string $key The key of the item to check.
     * @return bool True if the item exists, false otherwise.
     */
    public function has(string $key): bool
    {
        return $this->backend->has($key);
    }

    /**
     * Delete an item from the cache.
     *
     * @param string $key The key of the item to delete.
     * @return bool True on success, false on failure.
     */
    public function delete(string $key): bool
    {
        return $this->backend->delete($key);
    }

    /**
     * Clear all items from the cache.
     *
     * @return bool True on success, false on failure.
     */
    public function clear(): bool
    {
        return $this->backend->clear();
    }
}