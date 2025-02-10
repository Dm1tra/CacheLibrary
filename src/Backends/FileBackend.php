<?php

namespace CacheLibrary\Backends;

class FileBackend extends AbstractBackend
{
    private $cacheDir;

    public function __construct(array $options = [])
    {
        $this->cacheDir = $options['cache_dir'] ?? sys_get_temp_dir();
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function set(string $key, $value, int $ttl): bool
    {
        $filePath = $this->getFilePath($key);
        $data = ['value' => $value, 'expire' => time() + $ttl];
        return file_put_contents($filePath, serialize($data)) !== false;
    }

    public function get(string $key)
    {
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            $data = unserialize(file_get_contents($filePath));
            if (time() < $data['expire']) {
                return $data['value'];
            }
            unlink($filePath);
        }
        return null;
    }

    public function has(string $key): bool
    {
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            $data = unserialize(file_get_contents($filePath));
            if (time() < $data['expire']) {
                return true;
            }
            unlink($filePath);
        }
        return false;
    }

    public function delete(string $key): bool
    {
        $filePath = $this->getFilePath($key);
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return true;
    }

    public function clear(): bool
    {
        $files = glob($this->cacheDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        return true;
    }

    private function getFilePath(string $key): string
    {
        return $this->cacheDir . '/' . md5($key);
    }
}