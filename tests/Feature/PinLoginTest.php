<?php

namespace Tests\Feature;

use App\Models\Lansia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PinLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_lansia_bisa_login_dengan_pin_yang_benar(): void
    {
        $lansia = Lansia::create([
            'nama' => 'Ibu Siti',
            'pin_hash' => Hash::make('1234'),
        ]);

        $response = $this->post('/masuk-lansia', [
            'lansia_id' => $lansia->id,
            'pin' => '1234',
        ]);

        $response->assertRedirect(route('lansia.dashboard'));
        $this->assertAuthenticatedAs($lansia, 'lansia');
    }

    public function test_lansia_tidak_bisa_login_dengan_pin_salah(): void
    {
        $lansia = Lansia::create([
            'nama' => 'Ibu Siti',
            'pin_hash' => Hash::make('1234'),
        ]);

        $response = $this->post('/masuk-lansia', [
            'lansia_id' => $lansia->id,
            'pin' => '9999',
        ]);

        $response->assertSessionHasErrors('pin');
        $this->assertGuest('lansia');
    }
}
