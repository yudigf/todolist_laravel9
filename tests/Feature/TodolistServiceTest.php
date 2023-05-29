<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodolistService::class);
    }

    public function testTodoLostNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo("1", "Sakata");

        $todolist = Session::get("todolist");
        foreach ($todolist as $value){
            self::assertEquals("1", $value['id']);
            self::assertEquals("Sakata", $value['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Sakata"
            ],
            [
                "id" => "2",
                "todo" => "Gintoki"
            ]
        ];

        $this->todoListService->saveTodo("1", "Sakata");
        $this->todoListService->saveTodo("2", "Gintoki");

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }

    public function testremoveTodo()
    {
        $this->todoListService->saveTodo("1", "Sakata");
        $this->todoListService->saveTodo("2", "Gintoki");

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo("3");

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo("1");

        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));
        
        $this->todoListService->removeTodo("2");

        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }

}
