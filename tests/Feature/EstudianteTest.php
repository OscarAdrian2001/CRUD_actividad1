<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Estudiante;
use Tests\TestCase;

class EstudianteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_listar_estudiantes()
    {
        Estudiante::create([
            'nombre' => 'Juan',
            'email' => 'juan@test.com'
        ]);

        $response = $this->getJson('/api/estudiantes');

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'nombre' => 'Juan'
                 ]);
    }

    /** @test */
    public function puede_crear_un_estudiante()
    {
        $response = $this->postJson('/api/estudiantes', [
            'nombre' => 'Ana',
            'email' => 'ana@test.com'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('estudiantes', [
            'email' => 'ana@test.com'
        ]);
    }

    /** @test */
    public function puede_eliminar_un_estudiante()
    {
        $estudiante = Estudiante::create([
            'nombre' => 'Pedro',
            'email' => 'pedro@test.com'
        ]);

        $response = $this->deleteJson('/api/estudiantes/' . $estudiante->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('estudiantes', [
            'id' => $estudiante->id
        ]);
    }
}
