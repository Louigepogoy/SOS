<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Event;
use App\Models\Membership;
use App\Models\Organization;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        SystemSetting::set('site_name', 'Student Organization System');
        SystemSetting::set('site_tagline', 'Manage organizations, memberships, events, and announcements.');
        SystemSetting::set('contact_email', 'admin@sos.edu');
        SystemSetting::set('registration_enabled', '1');

        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@sos.edu',
            'password' => Hash::make('password'),
            'role' => User::ROLE_SUPER_ADMIN,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $officer = User::create([
            'name' => 'Jane Officer',
            'email' => 'officer@sos.edu',
            'password' => Hash::make('password'),
            'role' => User::ROLE_OFFICER,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $student = User::create([
            'name' => 'John Student',
            'email' => 'student@sos.edu',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STUDENT,
            'student_id' => '2024-0001',
            'course' => 'BS Computer Science',
            'year_level' => '3rd Year',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        $org = Organization::create([
            'name' => 'Computer Science Society',
            'slug' => 'css-' . Str::random(4),
            'description' => 'Official organization for Computer Science students.',
            'status' => Organization::STATUS_APPROVED,
            'officer_id' => $officer->id,
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        Organization::create([
            'name' => 'Engineering Club',
            'slug' => 'eng-' . Str::random(4),
            'description' => 'Community for engineering students.',
            'status' => Organization::STATUS_APPROVED,
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        Membership::create([
            'user_id' => $student->id,
            'organization_id' => $org->id,
            'status' => Membership::STATUS_APPROVED,
            'joined_at' => now(),
            'reviewed_by' => $officer->id,
            'reviewed_at' => now(),
        ]);

        $pendingStudent = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@sos.edu',
            'password' => Hash::make('password'),
            'role' => User::ROLE_STUDENT,
            'student_id' => '2024-0042',
            'course' => 'BS Information Technology',
            'year_level' => '2nd Year',
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        Membership::create([
            'user_id' => $pendingStudent->id,
            'organization_id' => $org->id,
            'status' => Membership::STATUS_PENDING,
            'message' => 'I would like to join CSS to participate in programming workshops.',
        ]);

        Event::create([
            'organization_id' => $org->id,
            'title' => 'General Assembly',
            'description' => 'Monthly meeting for all members.',
            'location' => 'Main Hall',
            'starts_at' => now()->addDays(7),
            'ends_at' => now()->addDays(7)->addHours(2),
            'created_by' => $officer->id,
        ]);

        Announcement::create([
            'organization_id' => $org->id,
            'title' => 'Welcome New Members',
            'content' => 'Welcome to CSS! Check the events page for upcoming activities.',
            'created_by' => $officer->id,
        ]);
    }
}
