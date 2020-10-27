<?php

use Illuminate\Database\Seeder;
use App\Bank;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Bank::count() <= 0){

            $bank = new Bank;
            $bank->name = "ABN AMRO";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Atlas - Citibank";
            $bank->save();

            $bank = new Bank;
            $bank->name = "BancaFacil";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Bice";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Central de Chile";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco de Chile";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco de Crédito e Inversiones";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco de Crédito e Inversiones";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Edwards";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Falabella";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Internacional";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Nova";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Penta";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Santander Santiago";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Banco Security";
            $bank->save();

            $bank = new Bank;
            $bank->name = "BancoEstado";
            $bank->save();

            $bank = new Bank;
            $bank->name = "BBVA";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Citibank N.A. Chile";
            $bank->save();
            
            $bank = new Bank;
            $bank->name = "Corpbanca";
            $bank->save();
        
            $bank = new Bank;
            $bank->name = "Credichile";
            $bank->save();
            
            $bank = new Bank;
            $bank->name = "Credit Suisse Consultas y Asesorias Limitada";
            $bank->save();
            
            $bank = new Bank;
            $bank->name = "Deutsche Bank";
            $bank->save();
            
            $bank = new Bank;
            $bank->name = "ING Bank N.V.";
            $bank->save();
            
            $bank = new Bank;
            $bank->name = "Redbanc";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Santander Banefe";
            $bank->save();

            $bank = new Bank;
            $bank->name = "Scotiabank Sud Americano";
            $bank->save();

            $bank = new Bank;
            $bank->name = "UBS AG in Santiago de Chile";
            $bank->save();
            

        }
    }
}
