<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(InvestmentSeeder::class);
        $this->call(FlagSeeder::class);
        $this->call(ComputationSeeder::class);

        $this->call(PageSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(NewWSCSeeder::class);
        $this->call(CategorySeeder::class);

        $this->call(TaxSeeder::class);
        $this->call(WealthScoreCommentSeeder::class);
        $this->call(RetirementScoreCommentSeeder::class);
        $this->call(SymbolFlagSeeder::class);
        $this->call(ValuesSeeder::class);
        $this->call(LifeExpectancySeeder::class);
        $this->call(TickerSeeder::class);
    }
}