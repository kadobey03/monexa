#!/bin/bash

# Script to update all dashboard pages to use consistent layout
# Changes @extends('layouts.dasht') to @extends('layouts.master', ['layoutType' => 'dashboard'])

echo "Updating dashboard page layouts..."

# List of files to update (remaining files that haven't been updated yet)
files=(
    "resources/views/user/verification.blade.php"
    "resources/views/user/referuser.blade.php"
    "resources/views/user/connect-wallet.blade.php"
    "resources/views/user/msignals.blade.php"
    "resources/views/user/copy/dashboard.blade.php"
    "resources/views/user/copy/experts.blade.php"
    "resources/views/user/signal.blade.php"
    "resources/views/user/plan/invest.blade.php"
    "resources/views/user/plan/show.blade.php"
    "resources/views/user/plan/my-plans.blade.php"
    "resources/views/user/plan/plan-details.blade.php"
    "resources/views/user/demo/trade.blade.php"
    "resources/views/user/demo/history.blade.php"
    "resources/views/user/demo/dashboard.blade.php"
    "resources/views/user/transfer.blade.php"
    "resources/views/user/loan.blade.php"
    "resources/views/user/trade/single.blade.php"
    "resources/views/user/trade/trade.blade.php"
    "resources/views/user/trade/monitor.blade.php"
    "resources/views/user/plandetails.blade.php"
    "resources/views/user/mcopytradings.blade.php"
    "resources/views/user/notifications/index.blade.php"
    "resources/views/user/notifications/show.blade.php"
    "resources/views/user/signals/subscribe.blade.php"
    "resources/views/user/verify.blade.php"
    "resources/views/user/bot/history.blade.php"
    "resources/views/user/bot/index.blade.php"
)

# Counter for tracking updates
updated=0

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo "Updating $file..."
        
        # Update the extends line
        sed -i "s/@extends('layouts\.dasht')/@extends('layouts.master', ['layoutType' => 'dashboard'])/g" "$file"
        
        ((updated++))
    else
        echo "Warning: $file not found"
    fi
done

echo "Updated $updated dashboard pages to use consistent layout"
echo "All dashboard pages now use layouts.master with dashboard layoutType"