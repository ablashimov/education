#!/usr/bin/env php
<?php

use App\Models\User;
use App\Models\Group;
use App\Models\Exam;
use App\Events\NewGroupAvailable;
use App\Events\GroupRequestApproved;
use App\Events\NewExamAvailable;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Notification Test Script\n";
echo "========================\n\n";

// Get first user
$user = User::where('id',3)->first();
if (!$user) {
    echo "No users found in database.\n";
    exit(1);
}

echo "Testing notifications for user: {$user->name} (ID: {$user->id})\n\n";

// Test 1: New Group Available
echo "1. Testing NewGroupAvailable event...\n";
$group = Group::where('id',3)->first();
if ($group) {
    $user->notify(new NewGroupAvailable($group, $user->id));

//    event(new NewGroupAvailable($group, $user->id));
    echo "   ✓ Sent event for group: {$group->name}\n";
} else {
    echo "   ✗ No groups found\n";
}

// Test 2: Group Request Approved
echo "\n2. Testing GroupRequestApproved event...\n";
if ($group) {
    event(new GroupRequestApproved($group, $user->id));
    echo "   ✓ Sent event for group approval: {$group->name}\n";
} else {
    echo "   ✗ No groups found\n";
}

// Test 3: New Exam Available
echo "\n3. Testing NewExamAvailable event...\n";
$exam = Exam::first();
if ($exam) {
    event(new NewExamAvailable($exam, $user->id));
    echo "   ✓ Sent event for exam: {$exam->title}\n";
} else {
    echo "   ✗ No exams found\n";
}

echo "\n========================\n";
echo "Test completed!\n";
echo "Check the frontend for real-time notifications.\n";
