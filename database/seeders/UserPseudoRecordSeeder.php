<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserPseudoRecord;
use App\Models\Admin;

class UserPseudoRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lookup the admin by email
        $admin = Admin::where('email', 'moiz@saviours.co')->first();


        UserPseudoRecord::create([
            'morph_id'        => $admin?->id,
            'morph_type'      => $admin ? Admin::class : null,
            'pseudo_name'     => 'Hasnat Developer',
            'pseudo_email'    => 'hasnat.developer@pivotbookwriting.com',
            'pseudo_phone'    => null,
            'server_host'     => 'mail.pivotbookwriting.com',
            'server_port'     => '993',
            'server_encryption' => 'ssl',
            'server_username' => 'hasnat.developer@pivotbookwriting.com',
            'server_password' => 'ATko513Wqyabs', // ⚠️ consider encrypting
            'imap_type'       => 'imap',
            'creator_id'      => $admin?->id,
            'creator_type'    => $admin ? Admin::class : null,
            'is_verified'     => 1,
            'status'          => 1,
        ]);

        UserPseudoRecord::create([
            'morph_id'        => $admin?->id,
            'morph_type'      => $admin ? Admin::class : null,
            'pseudo_name'     => 'Developer',
            'pseudo_email'    => 'developer@pivotbookwriting.com',
            'pseudo_phone'    => null,
            'server_host'     => 'mail.pivotbookwriting.com',
            'server_port'     => '993',
            'server_encryption' => 'ssl',
            'server_username' => 'developer@pivotbookwriting.com',
            'server_password' => 'GZtk67HD2qepH',
            'imap_type'       => 'imap',
            'creator_id'      => $admin?->id,
            'creator_type'    => $admin ? Admin::class : null,
            'is_verified'     => 1,
            'status'          => 1,
        ]);
    }
}
