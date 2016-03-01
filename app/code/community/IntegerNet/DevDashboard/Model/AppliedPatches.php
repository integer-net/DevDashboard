<?php
/**
 * Philwinkle_AppliedPatches Extension
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  Magento
 * @package   Philwinkle_AppliedPatches
 * @author    Phillip Jackson <philwinkle@gmail.com>
 * @copyright Copyright (c) 2015 Philwinkle LLC
 */

/**
 * AppliedPatches model
 *
 * This is a modified version of the Patches model in Philwinkle_AppliedPatches
 */
class IntegerNet_DevDashboard_Model_AppliedPatches
{

    /**
     * Use to store applied patches.
     *
     * @var array
     */
    private $appliedPatches = array();

    /**
     * Use to hold location reference to  `applied.patches.list` file.
     *
     * @var string
     */
    private $patchFile;

    /**
     * Constructor
     *
     * Use to load the applied patches array.
     *
     */
    public function __construct()
    {
        $this->patchFile = Mage::getBaseDir('etc') . DS . 'applied.patches.list';
        $this->_loadPatchFile();
    }

    /**
     * Use to get patches.
     *
     * @return string
     */
    public function getPatches()
    {
        return $this->appliedPatches;
    }

    /**
     * Use to load the patches array with applied patches.
     *
     * @return void
     */
    protected function _loadPatchFile()
    {
        $ioAdapter = new Varien_Io_File();

        if (!$ioAdapter->fileExists($this->patchFile)) {
            return;
        }

        $ioAdapter->open(array('path' => dirname($this->patchFile)));
        $ioAdapter->streamOpen($this->patchFile, 'r');

        while ($buffer = $ioAdapter->streamRead()) {
            if(stristr($buffer,'|')){
                list($date, $patch, $magentoVersion, $patchVersion) = array_map('trim', explode('|', $buffer));
                $this->appliedPatches[] = preg_replace('{^([A-Z]+-[0-9]+).*$}', '$1', $patch);
            }
        }
        $ioAdapter->streamClose();
    }
}
