<?php

namespace App\Exports;

use App\Models\User;
use App\Models\LeadStatus;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class LeadsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = User::with(['leadStatus', 'assignedAdmin'])
                    ->where(function($q) {
                        $q->whereNull('cstatus')
                          ->orWhere('cstatus', '!=', 'Customer');
                    });

        // Apply filters
        if (!empty($this->filters['status'])) {
            $query->where('lead_status_id', $this->filters['status']);
        }

        if (!empty($this->filters['assigned'])) {
            if ($this->filters['assigned'] === 'unassigned') {
                $query->whereNull('assign_to');
            } else {
                $query->where('assign_to', $this->filters['assigned']);
            }
        }

        if (!empty($this->filters['source'])) {
            $query->where('lead_source', $this->filters['source']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Ad Soyad',
            'E-posta',
            'Telefon',
            'Ülke',
            'Lead Status',
            'Atanan Admin',
            'Lead Skoru',
            'Kayıt Tarihi',
            'Son İletişim',
            'Sonraki Takip',
            'Tahmini Değer',
            'İletişim Tercihi',
            'Kaynak',
            'Notlar',
            'Etiketler',
            'Durum'
        ];
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone,
            $user->country,
            $user->leadStatus ? $user->leadStatus->display_name : 'Belirlenmemiş',
            $user->assignedAdmin ? ($user->assignedAdmin->firstName . ' ' . $user->assignedAdmin->lastName) : 'Atanmamış',
            $user->lead_score,
            $user->created_at ? $user->created_at->format('d.m.Y H:i') : '',
            $user->last_contact_date ? $user->last_contact_date->format('d.m.Y H:i') : 'Hiçbir zaman',
            $user->next_follow_up_date ? $user->next_follow_up_date->format('d.m.Y') : '',
            $user->estimated_value ? number_format($user->estimated_value, 2) . ' ₺' : '',
            $this->getContactMethodText($user->preferred_contact_method),
            $this->getSourceText($user->lead_source),
            $user->lead_notes,
            $user->lead_tags ? implode(', ', $user->lead_tags) : '',
            $user->status === 'active' ? 'Aktif' : 'Pasif'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true]
            ],
        ];
    }

    /**
     * Get contact method display text
     */
    private function getContactMethodText($method)
    {
        $methods = [
            'phone' => 'Telefon',
            'email' => 'E-posta',
            'whatsapp' => 'WhatsApp',
            'sms' => 'SMS'
        ];

        return $methods[$method] ?? '';
    }

    /**
     * Get source display text
     */
    private function getSourceText($source)
    {
        $sources = [
            'import' => 'Excel İçe Aktarım',
            'manual' => 'Manuel Ekleme',
            'web_form' => 'Web Formu',
            'api' => 'API',
            'referral' => 'Referans'
        ];

        return $sources[$source] ?? $source;
    }
}