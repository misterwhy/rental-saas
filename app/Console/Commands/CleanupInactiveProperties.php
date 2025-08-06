<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class CleanupInactiveProperties extends Command
{
    protected $signature = 'properties:cleanup {--days=30 : Number of days to consider for cleanup}';
    protected $description = 'Clean up properties that have been inactive for specified number of days';

    public function handle()
    {
        $days = $this->option('days');
        
        $this->info("Looking for properties inactive for more than {$days} days...");
        
        $inactiveProperties = Property::where('is_active', false)
            ->where('updated_at', '<', now()->subDays($days))
            ->get();
            
        if ($inactiveProperties->isEmpty()) {
            $this->info('No inactive properties found to clean up.');
            return 0;
        }
        
        $this->table(
            ['ID', 'Title', 'City', 'Last Updated'],
            $inactiveProperties->map(function ($property) {
                return [
                    $property->id,
                    $property->title,
                    $property->city,
                    $property->updated_at->format('Y-m-d H:i:s')
                ];
            })
        );
        
        if ($this->confirm("Do you want to delete these {$inactiveProperties->count()} properties?")) {
            $count = $inactiveProperties->count();
            
            foreach ($inactiveProperties as $property) {
                // Delete related images
                $property->images()->delete();
                // Delete the property
                $property->delete();
            }
            
            $this->info("Successfully deleted {$count} inactive properties.");
        } else {
            $this->info('Operation cancelled.');
        }
        
        return 0;
    }
}
