<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoTrade extends Model
{
    protected $fillable = [
        'plan',
        'user',
        'amount',
        'activate',
        'inv_duration',
        'expire_date',
        'activated_at',
        'last_growth',
        'active',
        'assets',
        'symbol',
        'leverage',
        'type',
        'profit_earned',
        'entry_price',
        'current_price',
        'result_type'
    ];

    protected $casts = [
        'amount' => 'decimal:8',
        'profit_earned' => 'decimal:8',
        'entry_price' => 'decimal:8',
        'current_price' => 'decimal:8',
        'expire_date' => 'datetime',
        'activated_at' => 'datetime',
        'last_growth' => 'datetime',
    ];

    /**
     * Get the user that owns the demo trade
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    /**
     * Calculate current P&L for this demo trade
     */
    public function calculatePnL()
    {
        if (!$this->entry_price || !$this->current_price) {
            return 0;
        }

        $priceChange = ($this->current_price - $this->entry_price) / $this->entry_price;

        // Apply trade direction
        if ($this->type === 'Sell') {
            $priceChange = -$priceChange;
        }

        // Apply leverage
        $leverage = floatval($this->leverage ?? 1);
        $leveragedChange = $priceChange * $leverage;

        return floatval($this->amount) * $leveragedChange;
    }

    /**
     * Get current value of the trade
     */
    public function getCurrentValue()
    {
        return floatval($this->amount) + $this->calculatePnL();
    }

    /**
     * Check if trade is profitable
     */
    public function isProfitable()
    {
        return $this->calculatePnL() > 0;
    }

    /**
     * Get return percentage
     */
    public function getReturnPercentage()
    {
        if (floatval($this->amount) == 0) {
            return 0;
        }

        return ($this->calculatePnL() / floatval($this->amount)) * 100;
    }
}
