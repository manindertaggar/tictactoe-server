<?php
function getHashFor($data){
    $hash = password_hash($data, CRYPT_BLOWFISH);
    return $hash;
}
