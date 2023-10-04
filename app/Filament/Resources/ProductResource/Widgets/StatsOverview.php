<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;
 
class StatsOverview extends BaseWidget
{

    public ?Model $record = null;

    protected function getStats(): array
    {

        $total_purchases = $this->record->purchases()->sum("quantity");
        $total_sales = $this->record->sales()->sum("quantity");
        $total_lends = $this->record->lends()->sum("quantity");

        return [
            Stat::make('Total Purchase',$total_purchases." pcs"),
            Stat::make('Total Sales',$total_sales." pcs"),
            Stat::make('Total Lends', $total_lends." pcs"),
            Stat::make('Stock', ($total_purchases - $total_sales - $total_lends) ." pcs")

        ];
    }
}
