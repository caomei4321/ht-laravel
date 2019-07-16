<?php

use Illuminate\Database\Seeder;
use App\Models\UserRecord;

class UserRecordsTableSeeder extends Seeder
{
    public function run()
    {
        $job_numbers = ['a0002', 'a0003', 'a0004', 'a0005', 'a0006', 'a0007', 'a0008'];

        $date = '2019-06-16 08:57:11';

        for ($i = 0; $i<= 29; $i++) {
            $date = $time = date('Y-m-d H:i:s', strtotime($date)+$i*24*60*60);

            foreach ($job_numbers as $job_number) {
                $this->createRecord($job_number,$date);
            }
        }



    }

    protected function createRecord($job_number,  $date)
    {
        $userRecord = new UserRecord(['job_number' => $job_number,'license' => '71538e5e07d12eba', 'time' => $date]);

        $userRecord->save();
    }
}