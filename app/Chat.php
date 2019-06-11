<?php

namespace App;

use App\Model\MongodbDefault;
use Illuminate\Support\Facades\Log;
use MongoDB\Driver\BulkWrite;

class Chat extends MongodbDefault
{
    public function __construct()
    {
        parent::__construct('Chat');
    }

    public function insert(array $data): int
    {
        $bulk = new BulkWrite();
        $bulk->insert($data);

        try {
            $this->getManager()->executeBulkWrite($this->getNs(), $bulk);
            return 1;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return 0;
        }
    }
}
