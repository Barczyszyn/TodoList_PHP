<?php
namespace FernandoMarangon\TodoList;

use JsonSerializable;

class TodoList implements JsonSerializable {
    private array $todoList = [];

    public function add(TodoItem $item): void {
        $this->todoList[] = $item;
    }

    public function get(int $index): ?TodoItem {
        if (isset($this->todoList[$index])) {
            return $this->todoList[$index];
        }
        return null;
    }
    
    public function find($callable): array {
        return array_filter($this->todoList,$callable);
    }

    public function remove(int $index): bool {
        if (isset($this->todoList[$index])) {
            array_splice($this->todoList, $index, 1);
            return true;
        }
        return false;
    }

    public function jsonSerialize(): mixed {
        return $this->todoList;
    }
}
?>