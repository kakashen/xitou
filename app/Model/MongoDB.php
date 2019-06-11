<?php
/**
 * Created by PhpStorm.
 * User: xpwu
 * Date: 2017/12/30
 * Time: 上午12:34
 */

namespace App\Model;

use MongoDB\Driver\Command;
use MongoDB\Driver\Manager;

class MongoDB {
    function __construct(string $collection
        , string $dbName
        , string $addr
        , string $user
        , string $passwd) {

        $this->col_ = $collection;
        $this->addr_ = $addr;
        $this->manager_ = null;
        $this->dbName_ = $dbName;
        $this->user_ = $user;
        $this->passwd_ = $passwd;
    }

    protected function getNs():string {
        return $this->dbName_.".".$this->col_;
    }

    /**
     * 获取表名
     * @return string
     */
    protected function getCol():string {
        return $this->col_;
    }

    /**
     * 获取数据库名称
     * @return string
     */
    protected function getDB():string {
        return $this->dbName_;
    }

    /**
     * 获取连接对象
     * @return Manager
     */
    protected function getManager():Manager {

        if ($this->manager_ === null) {
            $this->manager_ = new \MongoDB\Driver\Manager($this->addr_
                , ['password'=>$this->passwd_, 'username'=>$this->user_]);
        }
        return $this->manager_;
    }

    public function count(array $filter = []): int {
        $cmd = [];
        $cmd['count'] = $this->getCol();
        $cmd['query'] = $filter;

        $manager = $this->getManager();
        try {
            $results = $manager->executeCommand($this->getDB(), new Command($cmd))->toArray();
            if (count($results)) return $results[0]->n;
        } catch (\Exception $e) {
            Log::error("count error!", $e);
        }

        return 0;
    }

    public function aggregate(array $pipeline, array $options = []): array {
        $cmd = [];
        $cmd['aggregate'] = $this->getCol();
        $cmd['pipeline'] = $pipeline;


        $manager = $this->getManager();
        try {
            $results = $manager->executeCommand($this->getDB(), new Command($cmd))->toArray();
            return $results[0]->result;
        } catch (\Exception $e) {
            Log::error("aggregate error!", $e);
        }

        return [];
    }

    private $manager_;
    private $dbName_;
    private $col_;
    private $addr_;
    private $user_;
    private $passwd_;
}
