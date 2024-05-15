<?php 
namespace FernandoMarangon\TodoList;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TodoController {
    private TodoRepository $repository;

    public function __construct() {
        $this->repository = new TodoRepository();
    }

    public function about(Request $request, Response $response): Response {
        $content = [
            'author' => 'Fernando Barczyszyn Marangon',
            'project' => 'To do List in PHP'
        ];
        
        $response->getBody()->write(json_encode($content));
        return $response;
    }

    public function addItem(Request $request, Response $response): Response {
        $todoList = $this->repository->getInstance();
        $payload = json_decode($request->getBody());
        $todoList->add(new TodoItem($payload->description));
        $response->getBody()->write('Adicionado com sucesso!');
        return $response->withStatus(200);
    }

    public function findAll(Request $request, Response $response): Response {
        $todoList = $this->repository->getInstance();
        $response->getBody()->write(json_encode($todoList));
        return $response->withStatus(200);
    }
    
    public function editItem(Request $request, Response $response, array $args): Response {
        $index = $args['index'];
        $payload = json_decode($request->getBody());
        $todoList = $this->repository->getInstance();
        
        $todoItem = $todoList->get($index); 
        
        if ($todoItem !== null) {
            $description = $payload->description;
            $todoItem->setDescription($description);
            $response->getBody()->write('Editado com sucesso!');
            return $response->withStatus(200);
        } else {
            $response->getBody()->write('Índice não encontrado.');
            return $response->withStatus(404);
        }
    }

    public function checkItem(Request $request, Response $response, array $args): Response {
        $todoList = $this->repository->getInstance();
        $index = $args['index'];
        
        $todoItem = $todoList->get($index); 
        
        if ($todoItem !== null) { 
            $todoItem->setStatus(TodoStatus::CHECKED); 
            $response->getBody()->write('Marcado com sucesso!');
            return $response->withStatus(200);
        } else {
            $response->getBody()->write('Índice não encontrado.');
            return $response->withStatus(404);
        }
    }

    public function uncheckItem(Request $request, Response $response, array $args): Response {
        $todoList = $this->repository->getInstance();
        $index = $args['index'];
        
        $todoItem = $todoList->get($index); 
        
        if ($todoItem !== null) { 
            $todoItem->setStatus(TodoStatus::UNCHECKED); 
            $response->getBody()->write('Desmarcado com sucesso!');
            return $response->withStatus(200);
        } else {
            $response->getBody()->write('Índice não encontrado.');
            return $response->withStatus(404);
        }
    }

    public function deleteItem(Request $request, Response $response, array $args): Response {
        $index = $args['index'];
        $todoList = $this->repository->getInstance();
        
        if ($todoList->remove($index)) {
            $response->getBody()->write('Excluído com sucesso!');
            return $response->withStatus(200);
        } else {
            $response->getBody()->write('Índice não encontrado.');
            return $response->withStatus(404);
        }
    }
}
?>