<?php
const key = 'PRODUCT';
const productCount = 'PRODUCT_COUNT';
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

if ($redis->get(productCount) <= 0){
    file_put_contents('/tmp/test.log', 'FAIL' . PHP_EOL, FILE_APPEND);
    die(1);
}

if ($redis->setNx(key, '1')){
    $redis->expire(key, 3);
    //TODO:Deal with bussiness.
    file_put_contents('/tmp/test.log','SUCCESS' . PHP_EOL, FILE_APPEND);
    $redis->decr(productCount);
    $redis->del(key); 

}else{
    file_put_contents('/tmp/test.log', 'FAIL' . PHP_EOL, FILE_APPEND);
}
