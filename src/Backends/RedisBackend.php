<?php

namespace CacheLibrary\Backends;

class RedisBackend extends AbstractBackend
{
    private $redis;

    public function __construct(array $options = [])
    {
        $host = $options['host'] ?? '127.0.0.1';
        $port = $options['port'] ?? 6379;
        $this->redis = new \Redis();
        if (!$this->redis->connect($host, $port)) {
            throw new \RuntimeException("Failed to connect to Redis server at $host:$port");
        }
    }

    public function set(string $key, $value, int $ttl): bool
    {
        return $this->redis->setex($key, $ttl, serialize($value));
    }

    public function get(string $key)
    {
        $value = $this->redis->get($key);
        return $value ? unserialize($value) : null;
    }

    public function has(string $key): bool
    {
        return $this->redis->exists($key) > 0;
    }

    public function delete(string $key): bool
    {
        return $this->redis->del($key) > 0;
    }

    public function clear(): bool
    {
        return $this->redis->flushDB();
    }
}