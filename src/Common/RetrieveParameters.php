<?php
namespace Omnipay\Acapture\Common;

trait RetrieveParameters
{
    protected $data;

    /**
     * Returns the parameter if found, or defaultValue if none was found.
     *
     * @param string $name
     * @param mixed $defaultValue
     *
     * @return string|null
     */
    protected function getParameter($name, $defaultValue = null)
    {
        $dimensions = explode('.', $name);
        $element = $this->data;

        foreach ($dimensions as $dimension) {
            if (!isset($element[$dimension])) {
                return $defaultValue;
            }

            $element = $element[$dimension];
        }

        return $element;
    }
}