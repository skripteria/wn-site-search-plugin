<?php

namespace Winter\SiteSearch\Components;
use Cms\Classes\ComponentBase as WinterBaseComponent;


abstract class BaseComponent extends WinterBaseComponent
{
    /**
     * Sets a var as a property on this class
     * and as a key in $this->page.
     *
     * If no value is specified the component property
     * named $var is set as value.
     *
     * @param      $var
     * @param null $value
     */
    protected function setVar($var, $value = null)
    {
        if ($value === null) {
            $value = $this->property($var);
        }
        $this->{$var} = $this->page[$var] = $value;
    }

}
