<?php

namespace Bka\AllowSymlinks\Plugin\Magento\Framework\Filesystem\Drive;

/**
 * Class: File
 */
class File
{
    /**
     * Read directory
     *
     * read directory does not account for symlinks, for dev reasons this might be useful
     *
     * @param string $path
     * @return string[]
     * @throws FileSystemException
     */
    public function aroundReadDirectory($path)
    {
        try {
            // added FOLLOW_SYMLINKS flag
            $flags = \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS | \FilesystemIterator::FOLLOW_SYMLINKS;
            $iterator = new \FilesystemIterator($path, $flags);
            $result = [];
            /** @var \FilesystemIterator $file */
            foreach ($iterator as $file) {
                $result[] = $file->getPathname();
            }
            sort($result);
            return $result;
        } catch (\Exception $e) {
            throw new FileSystemException(new \Magento\Framework\Phrase($e->getMessage()), $e);
        }
    }
}
