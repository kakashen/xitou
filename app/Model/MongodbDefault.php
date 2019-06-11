<?php
/**
 * Created by PhpStorm.
 * User: xpwu
 * Date: 2017/12/30
 * Time: 下午3:04
 */

namespace App\Model;


class MongodbDefault extends MongoDB {
  function __construct($collection) {
    parent::__construct($collection
      , 'xitou'
      , 'mongodb://127.0.0.1:27017'
      , 'admin'
      , 'admin');
  }
}
