<?php

namespace Database\Seeders;

use App\Models\MultiTenant;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        $tenant = MultiTenant::create(['tenant_username' => 'admin']);
        User::create([
            'first_name' => 'Harsh',
            'last_name' => 'Vishwakarma',
            'email' => 'harshprogrammer782@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('com.aeonian.rishteyy@Daddy'),
            'tenant_id' => $tenant->id,
        ]);

        $plan = Plan::whereIsDefault(true)->first();

        Subscription::create([
            'plan_id' => $plan->id,
            'plan_amount' => $plan->price,
            'plan_frequency' => Plan::MONTHLY,
            'starts_at' => Carbon::now(),
            'ends_at' => Carbon::now()->addDays($plan->trial_days),
            'trial_ends_at' => Carbon::now()->addDays($plan->trial_days),
            'status' => Subscription::ACTIVE,
            'tenant_id' => $tenant->id,
            'no_of_vcards' => $plan->no_of_vcards,
        ]);

        //super admin
        $tenant = MultiTenant::create(['tenant_username' => 'super_admin']);
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'daddy@connectup.in',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('DaddyIsTheRealDaddy@Daddy'),
            'tenant_id' => $tenant->id,
        ]);
    }
}
