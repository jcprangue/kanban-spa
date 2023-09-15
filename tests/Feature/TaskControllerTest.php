<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase; // This ensures your database is in a known state for testing


    public function setUp(): void
    {
        parent::setUp();
        $faker = Factory::create();
        $user = User::create([
            "name" => $faker->name(),
            "email" => $faker->email(),
            "password" => bcrypt($faker->password())
        ]);
        $this->actingAs($user);
    }

    protected function createRandomTask($method = '')
    {
        $faker = Factory::create();
        // Get a random date
        $startDate = '-1 year';
        $endDate = 'now';
        $randomDate = $faker->dateTimeBetween($startDate, $endDate);

        // Set group and status arrays
        $group = ["Design", "Feature Request", "Backend", "QA"];
        $status = ["Todo", "In Progress", "Done"];
        $_status = $status[$faker->numberBetween(0, 2)];
        if ($method) {
            $_status = $faker->numberBetween(0, 2);
        }
        // Create the task data
        $taskData = [
            'title' => $faker->sentence(),
            'description' => $faker->sentence(),
            'due_date' => $randomDate->format('Y-m-d H:i:s'),
            'status' => $_status,
            'task_group' => $group[$faker->numberBetween(0, 3)],
        ];

        return $taskData;
    }

    public function testIndex()
    {
        $this->withoutExceptionHandling();
        $this->getJson(route('api.tasks.index'))->assertStatus(200);
    }

    public function testStore()
    {
        $this->withoutExceptionHandling();
        $taskData = $this->createRandomTask();
        // do the test
        $this->post(route('api.tasks.store'), $taskData)->assertStatus(200);
    }

    public function testShow()
    {
        $taskData = $this->createRandomTask('manual');
        $createdTask = Task::create($taskData);
        $taskId = $createdTask->id;
        $this->getJson(route('api.tasks.show', $taskId))->assertStatus(200);
    }

    public function testUpdate()
    {
        $taskData = $this->createRandomTask('manual');
        $createdTask = Task::create($taskData);
        $taskId = $createdTask->id;


        //alter the current data
        $faker = Factory::create();

        $status = ["Todo", "In Progress", "Done"];
        $taskData['title'] = $faker->sentence();
        $taskData['status'] = $status[$faker->numberBetween(0, 2)];

        $this->put(route('api.tasks.update', $taskId), $taskData)->assertStatus(200);
    }

    public function testDelete()
    {
        $taskData = $this->createRandomTask('manual');
        $createdTask = Task::create($taskData);
        $taskId = $createdTask->id;
        $this->delete(route('api.tasks.destroy', $taskId))->assertStatus(200);
    }
}
