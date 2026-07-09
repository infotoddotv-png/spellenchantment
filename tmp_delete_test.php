<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\Product;

$p = Product::create([
    'name' => 'Debug Spell',
    'slug' => 'debug-spell-' . uniqid(),
    'description' => 'A debug test product',
    'price' => 1.99,
    'type' => 'physical',
    'in_stock' => true,
]);

$id = $p->id;
$p->delete();
$result = Product::find($id) ? 'exists' : 'deleted';
echo $result;