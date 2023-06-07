<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\Office;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Approval>
 */
class ApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $office = Office::select('offices.*')
        ->join('roles', 'roles.id', 'offices.role_id')->where('roles.role_type', '=', Role::MUNICIPALITY)->skip(12)->limit(10)->get();
        return [
            'borrowee' => $office->pluck('id')->random(),
            'status' => 'pending'
        ];
    }
}
