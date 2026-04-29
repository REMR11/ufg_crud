<?php

namespace Tests\Feature;

use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class AlumnosCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_rutas_principales_del_crud_alumno_responden_ok(): void
    {
        $carrera = $this->crearCarrera();
        $alumno = Alumno::create([
            'nombre' => 'Raul',
            'apellido' => 'Lopez',
            'email' => 'raul@example.com',
            'telefono' => '71234567',
            'codigo' => 'ALU001',
            'codigo_carrera' => (string) $carrera->id,
        ]);

        $this->get(route('alumnos.index'))->assertOk();
        $this->get(route('alumnos.create'))->assertOk();
        $this->get(route('alumnos.show', $alumno))->assertOk();
        $this->get(route('alumnos.edit', $alumno))->assertOk();
    }

    public function test_crea_alumno_con_datos_validos(): void
    {
        $carrera = $this->crearCarrera();

        $response = $this->post(route('alumnos.store'), [
            'nombre' => 'Carla',
            'apellido' => 'Mendez',
            'email' => 'carla@example.com',
            'telefono' => '72345678',
            'codigo' => 'ALU100',
            'codigo_carrera' => $carrera->id,
        ]);

        $response->assertRedirect(route('alumnos.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('alumnos', [
            'email' => 'carla@example.com',
            'codigo' => 'ALU100',
            'codigo_carrera' => (string) $carrera->id,
        ]);
    }

    public function test_rechaza_validaciones_clave_en_store(): void
    {
        $carrera = $this->crearCarrera();
        Alumno::create([
            'nombre' => 'Base',
            'apellido' => 'Alumno',
            'email' => 'base@example.com',
            'telefono' => '71230000',
            'codigo' => 'ALU200',
            'codigo_carrera' => (string) $carrera->id,
        ]);

        $response = $this->from(route('alumnos.create'))->post(route('alumnos.store'), [
            'nombre' => 'A',
            'apellido' => 'B',
            'email' => 'base@example.com',
            'telefono' => '12345',
            'codigo' => 'ALU200',
            'codigo_carrera' => 99999,
        ]);

        $response->assertRedirect(route('alumnos.create'));
        $response->assertSessionHasErrors([
            'nombre',
            'apellido',
            'email',
            'telefono',
            'codigo',
            'codigo_carrera',
        ]);
    }

    public function test_actualiza_alumno_ignorando_su_propia_unicidad(): void
    {
        $carrera = $this->crearCarrera();
        $alumno = Alumno::create([
            'nombre' => 'Mario',
            'apellido' => 'Suarez',
            'email' => 'mario@example.com',
            'telefono' => '70000001',
            'codigo' => 'ALU300',
            'codigo_carrera' => (string) $carrera->id,
        ]);

        $response = $this->put(route('alumnos.update', $alumno), [
            'nombre' => 'Mario Editado',
            'apellido' => 'Suarez',
            'email' => 'mario@example.com',
            'telefono' => '70000002',
            'codigo' => 'ALU300',
            'codigo_carrera' => $carrera->id,
        ]);

        $response->assertRedirect(route('alumnos.index'));
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('alumnos', [
            'id' => $alumno->id,
            'nombre' => 'Mario Editado',
            'telefono' => '70000002',
        ]);
    }

    public function test_elimina_alumno(): void
    {
        $carrera = $this->crearCarrera();
        $alumno = Alumno::create([
            'nombre' => 'Luisa',
            'apellido' => 'Rivera',
            'email' => 'luisa@example.com',
            'telefono' => '71112222',
            'codigo' => 'ALU400',
            'codigo_carrera' => (string) $carrera->id,
        ]);

        $response = $this->delete(route('alumnos.destroy', $alumno));

        $response->assertRedirect(route('alumnos.index'));
        $this->assertDatabaseMissing('alumnos', ['id' => $alumno->id]);
    }

    public function test_index_usa_paginacion_y_conserva_filtro_busqueda(): void
    {
        $carrera = $this->crearCarrera();
        for ($i = 1; $i <= 12; $i++) {
            Alumno::create([
                'nombre' => 'Alumno',
                'apellido' => 'Test'.$i,
                'email' => "alumno{$i}@example.com",
                'telefono' => null,
                'codigo' => 'COD'.$i,
                'codigo_carrera' => (string) $carrera->id,
            ]);
        }

        $response = $this->get(route('alumnos.index', ['search' => 'Alumno']));

        $response->assertOk();
        $paginator = $response->viewData('alumnos');
        $this->assertInstanceOf(LengthAwarePaginator::class, $paginator);
        $this->assertSame(10, $paginator->perPage());
        $response->assertSee('search=Alumno', false);
    }

    private function crearCarrera(): Carrera
    {
        return Carrera::create([
            'codigo_carrera' => 'INF',
            'nombre_carrera' => 'Ingenieria Informatica',
        ]);
    }
}
