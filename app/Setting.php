<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public function cola()
    {
    	$data = $this->first();
    	return $data->cola;
    }

    public function getcola($id)
    {
    	$data = $this->first();
    	return $data->cola;
    }

    public function minimum_wage()
    {
    	$data = $this->first();
    	return $data->minimum_wage;
    }
}
