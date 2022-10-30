<?php

namespace Hmos9c\PhpMvc\App {

    function header(string $value){
        echo $value;
    }

}

namespace Hmos9c\PhpMvc\Service {

    function setcookie(string $name, string $value){
        echo "$name: $value";
    }

}