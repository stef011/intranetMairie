<?php 

namespace App\Core;

use ArrayObject;
use InvalidArgumentException;

class Collection extends ArrayObject
{
   
    /**
     * Orders items in a Collection object
     * @param array An array of columns and sorts directions('asc or 'desc') ['col' => 'dir']
     * @return void
     */
    public function orderBy($cols)
    {

        // if (! in_array($order, ['asc', 'desc'], true)) {
        //     throw new InvalidArgumentException('Order direction must be "asc" or "desc".');
        // }
        if(!is_array($cols)){
            $cols = array($cols);
        }

        $tri = function ($a, $b) use ($cols)
        {

            foreach ($cols as $col=>$dir) {
                $dir = strtolower($dir);
                if($dir == 'asc'){
                    if (strcmp($a->$col, $b->$col)!=0) {
                    return strcmp($a->$col, $b->$col);
                    dd($a, $b);
                    }
                }elseif($dir == 'desc'){
                    if (strcmp($b->$col, $a->$col)!=0) {
                    return strcmp($b->$col, $a->$col);
                    }
                }else {
                    throw new InvalidArgumentException('Order direction must be "asc" or "desc".');
                }
            }

        };

        // $asc = function($a,$b) use($cols){
        //     foreach ($cols as $col) {
        //         if (strcmp($a->$col, $b->$col)!=0) {
        //             return strcmp($a->$col, $b->$col);
        //         }
        //     }
        // };
        
        // $desc = function ($a, $b) use ($cols)
        // {
        //     foreach ($cols as $col) {
        //         if (strcmp($b->$col, $a->$col)!=0) {
        //             return strcmp($b->$col, $a->$col);
        //         }
        //     }
        // };

        // $order = strtolower($order);


        $this->uasort( $tri );

    }

    public function filter($options = [])
    {
        $callback = function($item) use ($options){
            foreach ($options as $key => $value) {
                if($item->$key != $value){
                    return false;
                };
            }
            return true;
        };
        $this->exchangeArray(array_filter($this->getArrayCopy(), $callback));

        return $this;
    }
}
