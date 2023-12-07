<?php
namespace AmiCrud\Packages;

class Formable
{
    protected $attributes = [];

    public function type($type)
    {
        $this->attributes['type'] = $type;
        return $this;
    }

    public function name($name)
    {
        $this->attributes['name'] = $name;
        return $this;
    }


    public static function text($name)
    {
        return (new static())->type('text')->name($name);
    }

    public function fillable($fillable = null)
    {
        $this->attributes['fillable'] = $fillable;
        return $this;
    }

    public function col($col)
    {
        $this->attributes['col'] = $col;
        return $this;
    }

    public function select_items($items = [])
    {
        $this->attributes['select_items'] = $items;
        return $this;
    }




}