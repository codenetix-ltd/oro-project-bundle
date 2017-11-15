<?php

namespace Codenetix\Oro\Bundle\ProjectBundle;

use Codenetix\Oro\Bundle\ProjectBundle\DependencyInjection\CodenetixOroProjectBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Egor Zyuskin <ezyuskin@codenetix.com>
 */
class CodenetixOroProjectBundle extends Bundle
{
    /**
     * @return CodenetixOroProjectBundleExtension
     */
    public function getContainerExtension()
    {
        if (!$this->extension) {
            $this->extension = new CodenetixOroProjectBundleExtension();
        }

        return $this->extension;
    }
}
