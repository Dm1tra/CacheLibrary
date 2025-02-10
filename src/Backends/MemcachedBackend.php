<?php

namespace CacheLibrary\Backends;

class MemcachedBackend extends AbstractBackend
{
    private $memcached;

    public function __construct(array $options = [])
    {
        $host = $options['host'] ?? '127.0.0.1';
        $port = $options['port'] ?? 11211;
        $this->memcached = new \Memcached();
        if (!$this->memcached->addServer($host, $port)) {
            throw new \RuntimeException("Failed to connect to Memcached server at $host:$port");
        }
    }

    public function set(string $key, $value, int $ttl): bool
    {
        return $this->memcached->set($key, serialize($value), $ttl);
    }

    public function get(string $key)
    {
        $value = $this->memcached->get($key);
        return $value ? unserialize($value) : null;
    }

    public function has(string $key): bool
    {
        return $this->memcached->get($key) !== false;
    }

    public function delete(string $key): bool
    {
        return $this->memcached->delete($key);
    }

    public function clear(): bool
    {
        return $this->memcached->flush();
    }
}