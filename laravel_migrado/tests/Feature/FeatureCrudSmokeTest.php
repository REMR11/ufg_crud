<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureCrudSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    public function test_protected_routes_require_authentication(): void
    {
        $response = $this->get(route('alumnos.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_open_main_crud_indexes(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('home'))->assertOk();
        $this->actingAs($user)->get(route('alumnos.index'))->assertOk();
        $this->actingAs($user)->get(route('docentes.index'))->assertOk();
        $this->actingAs($user)->get(route('carreras.index'))->assertOk();
        $this->actingAs($user)->get(route('horarios.index'))->assertOk();
        $this->actingAs($user)->get(route('inscripciones.index'))->assertOk();
        $this->actingAs($user)->get(route('alumno_carrera.index'))->assertOk();
        $this->actingAs($user)->get(route('materias.index'))->assertOk();
    }
}
