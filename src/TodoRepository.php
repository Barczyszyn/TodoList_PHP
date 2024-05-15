<?php
namespace FernandoMarangon\TodoList;

class TodoRepository {
    public function __construct() {
        session_start();
        if(!isset($_SESSION[__CLASS__])) $this->create();
    }
    
    public function create(): void {
        $_SESSION[__CLASS__] = new TodoList();
    }

    public function getInstance(): TodoList {
        return $_SESSION[__CLASS__];
    }
   
    public function destroy(): void {
        session_destroy();
    }
}
?>