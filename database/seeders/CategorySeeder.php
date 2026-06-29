<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Cria as categorias globais do sistema (user_id nulo),
     * visíveis para todos os usuários.
     */
    public function run(): void
    {
        $incomeCategories = [
            'Salário',
            'Freelance',
            'Investimentos',
            'Vendas',
            'Outros',
        ];

        foreach ($incomeCategories as $name) {
            IncomeCategory::firstOrCreate(['name' => $name, 'user_id' => null]);
        }

        $expenseCategories = [
            'Moradia',
            'Alimentação',
            'Transporte',
            'Saúde',
            'Lazer',
            'Educação',
            'Contas',
            'Outros',
        ];

        foreach ($expenseCategories as $name) {
            ExpenseCategory::firstOrCreate(['name' => $name, 'user_id' => null]);
        }
    }
}
