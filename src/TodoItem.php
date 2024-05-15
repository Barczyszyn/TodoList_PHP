<?php
namespace FernandoMarangon\TodoList;

use JsonSerializable;

class TodoItem implements JsonSerializable {
    private string $description;
    private TodoStatus $status;

    public function __construct(string $description) {
        $this->description = $description;
        $this->status = TodoStatus::UNCHECKED;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }
    
    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(TodoStatus $status): void {
        $this->status = $status;
    }

    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }
}
?>