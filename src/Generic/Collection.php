<?php

namespace Foamycastle\Collection\Generic;

use Foamycastle\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function __construct($data = [])
    {
        parent::__construct();
        $this->setCollectionType('GenericCollection');

        if(is_array($data)){
            $this->appendArray($data);
        }
    }

}