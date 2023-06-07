<?php

namespace App\Exports;

use App\Models\Equipment;
use App\Models\EquipmentDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart as ChartChart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Worksheet\Chart;

class InventorySummary implements WithCharts, FromCollection
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      return EquipmentDetail::all();
    }


    public function charts()
    {
        $label      = [new DataSeriesValues('String', 'Worksheet!$A$2', null, 1)];
        $categories = [new DataSeriesValues('String', 'Worksheet!$A$2:$D$2', null, 4)];
        $values     = [new DataSeriesValues('Number', 'Worksheet!$C$2:$C$60 ', null, 4)];

        $series = new DataSeries(
            DataSeries::TYPE_PIECHART,
            DataSeries::GROUPING_STANDARD,
            range(0, \count($values) - 1),
            $label,
            $categories,
            $values
        );
        $plot   = new PlotArea(null, [$series]);

        $legend = new Legend();
        $chart  = new ChartChart('chart name', new Title('chart title'), $legend, $plot);
        $chart->setTopLeftPosition('F12');
        $chart->setBottomRightPosition('M20');

        return $chart;
    }
    public static function beforeWriting(BeforeWriting $event)
    {
        $event->writer->setIncludeCharts(true);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $chart = $this->charts();
                $event->sheet->getDelegate()->addChart($chart);
            },
        ];
    }
}
