<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Categoria::query()->count() === 0) {
            $this->call(CategoriaSeeder::class);
        }

        if (Producto::query()->count() === 0) {
            $this->call(ProductoSeeder::class);
        }

        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if ($email && $password && User::query()->where('email', $email)->doesntExist()) {
            $admin = new User();
            $admin->name = env('ADMIN_NAME', 'Administrador');
            $admin->email = $email;
            $admin->password = $password;
            $admin->admin = 1;
            $admin->save();
        }
    }
}
