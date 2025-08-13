<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('tasks')->delete();
        $data = json_decode(file_get_contents(database_path() . '/data/tasks.json'), true);

        foreach ($data['tasks'] as $task) {
            Task::create($task);
        }
    }
}
