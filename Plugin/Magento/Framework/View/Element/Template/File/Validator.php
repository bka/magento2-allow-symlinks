<?php

namespace Bka\AllowSymlinks\Plugin\Magento\Framework\View\Element\Template\File;

/**
 * Class: Validator
 */
class Validator
{
    /**
     * aroundIsValid
     *
     * If you try to link external modules in a different folder, loading of
     * templates will fail because isValid checks if template file is within
     * the project root directory with:
     *
     *   > $this->getRootDirectory()->isFile($this->getRootDirectory()->getRelativePath($filename));
     *
     * But for development purpose it is useful
     * to develop modules out of your project directory to reduce coupling.
     * That is why we skip validation in dev mode with this plugin, our only
     * constraint is, that this does not happen in production mode.
     *
     * @param \Magento\Framework\View\Element\Template\File\Validator $subject
     * @param callable $proceed
     */
    public function aroundIsValid(
        \Magento\Framework\View\Element\Template\File\Validator $subject,
        callable $proceed
    ) {
        if (array_key_exists('mage_mode', $_ENV)) {
            return ($_ENV['mage_mode'] !== 'production');
        }
        return true;
    }
}
