<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        if(Category::count() <= 0){

            $category = new Category;
            $category->name = "Amasandería y panadería";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Banqueterìa";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "BBQ y Parrilladas";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Chocolatería y dulcería";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Cocteleria";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Colaciones y menús";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Comida rápida";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Comida típica chilena";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Comidas internacionales";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Degustaciones";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Empanadas";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Heladerías";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Platos únicos";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Tablas y snack";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Abarrotes y despensa";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Agua purificada";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Bebestibles";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Carnes, pescados y mariscos";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Congelados";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Frutas y verduras";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Fiambrería";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Hielo";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Huevos y miel";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Quesos, leche y derivados";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Legumbres y frutos secos";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Celiacos o sin gluten";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Mascotas";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Regalos y sorpresas";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Veganos";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Vegetarianos";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Maquinarias e implementos";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Insumos y accesorios";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

            $category = new Category;
            $category->name = "Distribuidores de gas";
            $category->description = "test";
            $category->color = "#ffffff";
            $category->save();

        
        }

    }
}
