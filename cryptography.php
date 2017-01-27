<?php
function get_hash_for($data){
    $hash = password_hash($data, CRYPT_BLOWFISH);
    return $hash;
}
