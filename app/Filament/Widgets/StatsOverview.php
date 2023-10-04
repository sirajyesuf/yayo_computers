<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total_products = Product::count();
        $total_contacts = Contact::count();

        return [
                Stat::make('Total Products',$total_products),
                Stat::make('Total Contacts',$total_contacts),
                Stat::make('Average time on page', '3:12'),
        ];
    }
}
