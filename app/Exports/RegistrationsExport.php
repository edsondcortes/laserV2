<?php

namespace App\Exports;

use App\Services\Facades\Adderi;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class RegistrationsExport implements WithColumnFormatting, FromCollection, WithHeadings, WithMapping
{
    protected $budgets;

    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($budgets)
    {
        $this->budgets = $budgets;
    }

    public function collection()
    {
        return collect($this->budgets);
    }

    public function headings(): array
    {

        return [
            'Número do Orçamento',
            'Código do Item',
            'Descrição',
            'Poosição',
            'Tipo',
            'Observação',
            'Data de cadastro'
        ];
    }

    public function map($budgets): array
    {
        return[
            Adderi::reduceNumber($budgets->adderi_budget),
            $budgets->item_code,
            $budgets->description,
            $budgets->position,
            $budgets->type,
            $budgets->note,
            Date::dateTimeToExcel($budgets->created_at),
        ];
    }

    public function columnFormats(): array
    {
        return[
            'G' => 'dd/mm/yyyy h:mm',
        ];
    }
}
