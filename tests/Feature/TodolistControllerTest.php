<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "Sakata",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Tada"
                ],
                [
                    "id" => "2",
                    "todo" => "Banri"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("Tada")
            ->assertSeeText("2")
            ->assertSeeText("Banri");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "Sakata" 
        ])->post("/todolist", [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "Sakata" 
        ])->post("/todolist", [
            "todo" => "Tada"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "Sakata",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Tada"
                ],
                [
                    "id" => "2",
                    "todo" => "Banri"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }


}
