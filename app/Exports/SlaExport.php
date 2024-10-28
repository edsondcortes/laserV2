<?php

namespace App\Exports;

use App\Services\Facades\Adderi;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SlaExport implements WithColumnFormatting, FromCollection, WithHeadings, WithMapping
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
            'Tipo de Entrega',
            'Forma de Produção',
            'Data de cadastro',
            'Tempo para Corte',
            'Corte',
            'Tempo para Edição',
            'Edição',
            'Tempo para Layout',
            'Layout',
            'Tempo para Gravação',
            'Gravação',
            'Tempo para Entrega',
            'Entrega'
        ];
    }

    public function map($budgets): array
    {
        return[
            Adderi::reduceNumber($budgets->adderi_budget),
            $budgets->item_code,
            $budgets->description,
            $budgets->delivery_type,
            $budgets->production_form,
            Date::dateTimeToExcel($budgets->created_at),
            $budgets->differenceCut,
            $budgets->cut,
            $budgets->differenceEdition,
            $budgets->edition,
            $budgets->differenceLayout,
            $budgets->layout,
            $budgets->differenceEngraving,
            $budgets->engraving,
            $budgets->differenceEngraving,
            $budgets->product_delivery
        ];
    }

    public function columnFormats(): array
    {
        return[
            'F' => 'dd/mm/yyyy h:mm',
        ];
    }
}
