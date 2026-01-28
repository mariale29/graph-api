<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Node;
use NumberFormatter;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        // Parent null
        for ($i = 1; $i <= 3; $i++) {
            $root = Node::create([
                'parent_id' => null,
                'title'     => $f->format($i),
                'created_at' => now()->subDays(2),
            ]);

            // Nivel 1 
            for ($j = 1; $j <= 2; $j++) {
                $child = Node::create([
                    'parent_id' => $root->id,
                    'title'     => $f->format($i * 10 + $j),
                    'created_at' => now()->subDays(1),
                ]);

                // Nivel 2
                Node::create([
                    'parent_id' => $child->id,
                    'title'     => $f->format($i * 100 + $j),
                    'created_at' => now(),
                ]);
            }
        }
    }
}
