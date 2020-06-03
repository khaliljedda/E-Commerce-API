<?php

namespace App\Exceptions;

use Exception;

class ProductNoteBelongsToUser extends Exception
{
    public function render(){
        return ['errors' => 'Product Not belong to user'];
    }
}
