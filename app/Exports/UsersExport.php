<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersExport implements FromQuery,WithHeadings, WithChunkReading
{
   
    public function query()
    {
        return User::query()
                   ->select(
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'join_date',
                    'active',
                    'albums',
                    'tracks',
                    'country',
                    'phone_number'
                );
    }

    public function headings(): array
    {
        return [
            "Firstname",
            "Lastname",
            "Email",
            "Joindate",
            "Active",
            "Albums",
            "Tracks",
            "Language",
            "Country",
            "Phone Number"
        ];
    }

    public function chunkSize(): int
    {
        return 1000; 
    }
}
