<?php

namespace Wiki\MainBundle\Model;

use Wiki\MainBundle\Model\om\BaseWiki;

class Wiki extends BaseWiki
{
    protected $task;

    public function getTask()
    {
        return $this->task;
    }
    public function setTask($task)
    {
        $this->task = $task;
    }


}
