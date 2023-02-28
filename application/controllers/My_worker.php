<?php
use yidas\queue\worker\Controller as WorkerController;

class My_worker extends WorkerController
{
    public function demo()
    {
      echo "hi";
    }
    // Initializer
    protected function init() {
      echo "hi";
   }

    // Worker
    protected function handleWork() {}

    // Listener
    protected function handleListen() {}
}










































 ?>
