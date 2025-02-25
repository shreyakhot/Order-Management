<?php

namespace App\Http\Filters;

use EloquentFilter\ModelFilter;
class SettingFilter extends ModelFilter
{

    public function id($id)
    {
        return $this->where('id', $id);
    }

    public function key($key)
    {
        return $this->where('key', $key);
    }

    public function value($value)
    {
        return $this->where('value', $value);
    }

    public function type($type)
    {
        return $this->where('type', $type);
    }

    public function enable($enable)
    {
        return $this->where('enable', 1);
    }

}
