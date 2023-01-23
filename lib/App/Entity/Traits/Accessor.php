<?php
namespace Kcpck\App\Entity\Traits;

trait Accessor
{
    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return $this->record[$name] ?? null;
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->record[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->record[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        if(isset($this->record[$name])) {
            $this->record[$name] = null;
        }
    }
}
