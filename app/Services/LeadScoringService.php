<?php

namespace App\Services;

use App\Models\User;
use App\Models\LeadScoreHistory;
use Illuminate\Support\Facades\Log;

class LeadScoringService
{
    const SCORING_WEIGHTS = [
        'demographic_fit' => 25,      // Demografik uyum (ülke, yaş vb.)
        'engagement_level' => 30,     // Etkileşim seviyesi
        'contact_frequency' => 20,    // İletişim sıklığı
        'estimated_value' => 15,      // Potansiyel değer
        'referral_quality' => 10      // Referans kalitesi
    ];

    /**
     * Calculate comprehensive lead score
     */
    public function calculateLeadScore(User $lead): array
    {
        $scores = [
            'demographic_score' => $this->calculateDemographicScore($lead),
            'engagement_score' => $this->calculateEngagementScore($lead),
            'contact_score' => $this->calculateContactScore($lead),
            'value_score' => $this->calculateValueScore($lead),
            'referral_score' => $this->calculateReferralScore($lead)
        ];

        $totalScore =
            ($scores['demographic_score'] * self::SCORING_WEIGHTS['demographic_fit'] / 100) +
            ($scores['engagement_score'] * self::SCORING_WEIGHTS['engagement_level'] / 100) +
            ($scores['contact_score'] * self::SCORING_WEIGHTS['contact_frequency'] / 100) +
            ($scores['value_score'] * self::SCORING_WEIGHTS['estimated_value'] / 100) +
            ($scores['referral_score'] * self::SCORING_WEIGHTS['referral_quality'] / 100);

        return [
            'total_score' => min(100, round($totalScore)),
            'breakdown' => $scores,
            'level' => $this->getScoreLevel($totalScore),
            'recommendations' => $this->getScoreRecommendations($totalScore, $scores)
        ];
    }

    /**
     * Demografik uyum skoru (0-100)
     */
    private function calculateDemographicScore(User $lead): int
    {
        $score = 0;

        // Hedef ülke kontrolü
        $targetCountries = ['Turkey', 'Germany', 'UK', 'USA', 'Canada', 'Australia'];
        if (in_array($lead->country, $targetCountries)) {
            $score += 40;
        }

        // Telefon numarası varlığı
        if ($lead->phone) {
            $score += 25;
        }

        // E-posta doğrulaması
        if ($lead->email_verified_at) {
            $score += 20;
        }

        // Dil uyumu (eğer mevcut ise)
        if ($lead->language && in_array($lead->language, ['en', 'tr', 'de'])) {
            $score += 15;
        }

        return min(100, $score);
    }

    /**
     * Etkileşim seviyesi skoru (0-100)
     */
    private function calculateEngagementScore(User $lead): int
    {
        $score = 0;
        $contactHistory = $lead->contact_history ?? [];

        // İletişim geçmişi varlığı
        $contactCount = count($contactHistory);
        $score += min(30, $contactCount * 5);

        // Son iletişim tarihi
        if ($lead->last_contact_date) {
            $daysSinceContact = $lead->last_contact_date->diffInDays();
            if ($daysSinceContact <= 7) {
                $score += 25;
            } elseif ($daysSinceContact <= 14) {
                $score += 15;
            } elseif ($daysSinceContact <= 30) {
                $score += 10;
            }
        }

        // Platform kullanım aktivitesi
        if ($lead->last_login_at && $lead->last_login_at->diffInDays() <= 7) {
            $score += 25;
        }

        return min(100, $score);
    }

    /**
     * İletişim sıklığı skoru (0-100)
     */
    private function calculateContactScore(User $lead): int
    {
        $score = 0;
        $contactHistory = $lead->contact_history ?? [];

        if (empty($contactHistory)) return 0;

        // Son 30 gün içindeki iletişim sayısı
        $recentContacts = collect($contactHistory)->filter(function($contact) {
            $contactDate = \Carbon\Carbon::parse($contact['created_at']);
            return $contactDate->diffInDays() <= 30;
        });

        $recentContactCount = $recentContacts->count();

        // İdeal iletişim sıklığı: 1-2 haftalık aralıklar
        if ($recentContactCount >= 2 && $recentContactCount <= 4) {
            $score += 40; // İdeal sıklık
        } elseif ($recentContactCount === 1) {
            $score += 25; // Az ama kabul edilebilir
        } elseif ($recentContactCount > 4) {
            $score += 20; // Çok sık (spam riski)
        }

        // İletişim çeşitliliği
        $contactTypes = $recentContacts->pluck('type')->unique();
        $score += min(30, $contactTypes->count() * 10);

        // Yanıt oranı (eğer tracking mevcut ise)
        $responsiveContacts = $recentContacts->where('response_received', true);
        if ($recentContactCount > 0) {
            $responseRate = ($responsiveContacts->count() / $recentContactCount) * 100;
            $score += min(30, $responseRate * 0.3);
        }

        return min(100, $score);
    }

    /**
     * Potansiyel değer skoru (0-100)
     */
    private function calculateValueScore(User $lead): int
    {
        $score = 0;

        // Tahmini değer
        if ($lead->estimated_value > 0) {
            if ($lead->estimated_value >= 10000) {
                $score += 50;
            } elseif ($lead->estimated_value >= 5000) {
                $score += 35;
            } elseif ($lead->estimated_value >= 1000) {
                $score += 20;
            } else {
                $score += 10;
            }
        }

        // Mevcut hesap bakiyesi (eğer demo hesap varsa)
        if ($lead->demo_balance > 0) {
            $score += min(20, $lead->demo_balance / 100);
        }

        // Trading deneyimi (eğer profil bilgisi mevcut ise)
        if (isset($lead->trading_experience)) {
            switch ($lead->trading_experience) {
                case 'expert':
                    $score += 30;
                    break;
                case 'intermediate':
                    $score += 20;
                    break;
                case 'beginner':
                    $score += 10;
                    break;
            }
        }

        return min(100, $score);
    }

    /**
     * Referans kalitesi skoru (0-100)
     */
    private function calculateReferralScore(User $lead): int
    {
        $score = 50; // Baseline score

        // Referans kaynağı kalitesi
        $highQualitySources = ['google_ads', 'facebook_ads', 'referral', 'webinar'];
        $mediumQualitySources = ['organic_search', 'social_media', 'content_marketing'];
        $lowQualitySources = ['unknown', 'spam', 'bot'];

        if (in_array($lead->lead_source, $highQualitySources)) {
            $score += 30;
        } elseif (in_array($lead->lead_source, $mediumQualitySources)) {
            $score += 15;
        } elseif (in_array($lead->lead_source, $lowQualitySources)) {
            $score -= 20;
        }

        // Referans eden kişi (eğer referral ise)
        if ($lead->ref_by && $lead->ref_by > 0) {
            $referrer = User::find($lead->ref_by);
            if ($referrer && $referrer->lead_status === 'converted') {
                $score += 20; // Aktif müşteriden (converted lead) referans
            }
        }

        return max(0, min(100, $score));
    }

    /**
     * Score seviyesi belirleme
     */
    private function getScoreLevel(float $score): array
    {
        if ($score >= 80) {
            return [
                'level' => 'hot',
                'label' => 'Sıcak Lead',
                'color' => 'red',
                'priority' => 1
            ];
        } elseif ($score >= 60) {
            return [
                'level' => 'warm',
                'label' => 'Ilık Lead',
                'color' => 'orange',
                'priority' => 2
            ];
        } elseif ($score >= 40) {
            return [
                'level' => 'cool',
                'label' => 'Soğuk Lead',
                'color' => 'blue',
                'priority' => 3
            ];
        } else {
            return [
                'level' => 'cold',
                'label' => 'Çok Soğuk Lead',
                'color' => 'gray',
                'priority' => 4
            ];
        }
    }

    /**
     * Score bazlı öneriler
     */
    private function getScoreRecommendations(float $totalScore, array $breakdown): array
    {
        $recommendations = [];

        // Demografik öneriler
        if ($breakdown['demographic_score'] < 50) {
            $recommendations[] = [
                'type' => 'demographic',
                'priority' => 'medium',
                'action' => 'Demografik bilgileri doğrula ve eksik alanları tamamla'
            ];
        }

        // Etkileşim önerileri
        if ($breakdown['engagement_score'] < 40) {
            $recommendations[] = [
                'type' => 'engagement',
                'priority' => 'high',
                'action' => 'Lead ile daha sık iletişim kur, e-posta engagement artır'
            ];
        }

        // İletişim önerileri
        if ($breakdown['contact_score'] < 30) {
            $recommendations[] = [
                'type' => 'contact',
                'priority' => 'high',
                'action' => 'Düzenli takip programı oluştur, çeşitli iletişim kanalları kullan'
            ];
        }

        // Değer önerileri
        if ($breakdown['value_score'] < 25) {
            $recommendations[] = [
                'type' => 'value',
                'priority' => 'medium',
                'action' => 'Lead ile potansiyel yatırım kapasitesi hakkında konuş'
            ];
        }

        return $recommendations;
    }

    /**
     * Update lead score and save history
     */
    public function updateLeadScore(User $lead, ?Admin $admin = null, string $reason = null): array
    {
        $oldScore = $lead->lead_score ?? 0;

        // Calculate new score
        $scoreData = $this->calculateLeadScore($lead);
        $newScore = $scoreData['total_score'];

        // Update lead
        $lead->lead_score = $newScore;
        $lead->save();

        // Save score history
        LeadScoreHistory::create([
            'user_id' => $lead->id,
            'admin_id' => $admin?->id,
            'old_score' => $oldScore,
            'new_score' => $newScore,
            'score_change' => $newScore - $oldScore,
            'score_breakdown' => $scoreData['breakdown'],
            'change_reason' => $reason,
            'change_description' => $this->generateChangeDescription($oldScore, $newScore),
            'demographic_score' => $scoreData['breakdown']['demographic_score'],
            'engagement_score' => $scoreData['breakdown']['engagement_score'],
            'contact_score' => $scoreData['breakdown']['contact_score'],
            'value_score' => $scoreData['breakdown']['value_score'],
            'referral_score' => $scoreData['breakdown']['referral_score'],
        ]);

        Log::info('Lead score updated', [
            'lead_id' => $lead->id,
            'old_score' => $oldScore,
            'new_score' => $newScore,
            'change_reason' => $reason,
            'admin_id' => $admin?->id
        ]);

        return $scoreData;
    }

    /**
     * Generate change description
     */
    private function generateChangeDescription(int $oldScore, int $newScore): string
    {
        $change = $newScore - $oldScore;

        if ($change > 0) {
            return "Lead skoru {$change} puan arttı ({$oldScore} → {$newScore})";
        } elseif ($change < 0) {
            return "Lead skoru " . abs($change) . " puan düştü ({$oldScore} → {$newScore})";
        } else {
            return "Lead skoru değişmedi ({$newScore})";
        }
    }

    /**
     * Get lead score trend over time
     */
    public function getScoreTrend(User $lead, int $days = 30): array
    {
        $startDate = now()->subDays($days);

        $scores = LeadScoreHistory::where('user_id', $lead->id)
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get(['new_score', 'created_at']);

        return $scores->map(function ($score) {
            return [
                'date' => $score->created_at->format('Y-m-d'),
                'score' => $score->new_score,
                'formatted_date' => $score->created_at->format('d.m.Y')
            ];
        })->toArray();
    }

    /**
     * Batch update scores for multiple leads
     */
    public function batchUpdateScores(array $leadIds, ?Admin $admin = null): array
    {
        $results = [];

        foreach ($leadIds as $leadId) {
            $lead = User::find($leadId);
            if ($lead) {
                try {
                    $result = $this->updateLeadScore($lead, $admin, 'Batch score update');
                    $results[] = [
                        'lead_id' => $leadId,
                        'success' => true,
                        'old_score' => $result['old_score'] ?? null,
                        'new_score' => $result['total_score'],
                        'level' => $result['level']['label']
                    ];
                } catch (\Exception $e) {
                    $results[] = [
                        'lead_id' => $leadId,
                        'success' => false,
                        'error' => $e->getMessage()
                    ];
                }
            }
        }

        return $results;
    }
}