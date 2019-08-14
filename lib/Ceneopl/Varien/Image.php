<?php
/**
 * @copyright Copyright (c) 2016 Orba Sp. z o.o. (http://orba.co)
 */

class Ceneopl_Varien_Image extends Varien_Image
{
    /**
     * Loads new image using current adapter.
     * This prevents memory leaks when loading a lot of images in one run using standard Varien_Image.
     * @param string $fileName
     * @throws Exception
     */
    public function reload($fileName = null)
    {
        if (isset($this->_imageHandler)) {
            @imagedestroy($this->_imageHandler);
        }
        $this->_fileName = $fileName;
        if (isset($fileName) ) {
            $this->open();
        }
    }
}
