<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsConfigsSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            '#F0A202' => 'First Discussion',
            '#FFD700' => 'Solution Research',
            '#17BEBB' => 'Brief In Progress',
            '#FF7F50' => 'Estimate Sent',
            '#FF6347' => 'Proposal Sent',
            '#008000' => 'Estimate Accepted',
            '#006400' => 'Contract Signed',
            '#FF0000' => 'Estimate Rejected',
            '#B22222' => 'Feedback Rejected',
            '#1E90FF' => 'Ongoing',
            '#FFD700' => 'Prospect',
            '#800000' => 'Client Withdrawn',
            '#32CD32' => 'Finalized',
            '#808080' => 'Postponed',
            '#A9A9A9' => 'Client Not Answering'
        ];
        foreach($statuses as $color => $status){
            DB::table('projects_statuses')->insert([
                'color' => $color,
                'name' => $status,
                'is_ongoing' => $status == 'Ongoing' ? 1 : 0
            ]);
        }

        $priorities = [
            '#32CD32' => 'Low',
            '#FFD700' => 'Medium',
            '#FF0000' => 'High'
        ];
        foreach($priorities as $color => $priority){
            DB::table('projects_priorities')->insert([
                'color' => $color,
                'name' => $priority
            ]);
        }

        $contracts_types = [
            '#008000' => 'Fixed',
            '#D46A6A' => 'Percentage',
            '#7E9A64' => 'Investment',
            '#8A9DB0' => 'Sponsorship',
            '#CA8C66' => 'Equity',
            '#6D83BA' => 'Equity And Fixed',
            '#A05A5A' => 'Barter'
        ];
        foreach($contracts_types as $color => $contractType){
            DB::table('projects_contracts_types')->insert([
                'color' => $color,
                'name' => $contractType
            ]);
        }

        $sources = [
            'Florian Buca Soft Tehnica',
            'Campanie Apollo',
            'Maria Destiny Park',
            'Stelian Mustea',
            'Commons Accel',
            'MisterSpread',
            'Valentin SuperVictor',
            'Cristian Cucoana',
            'Valentin Maior',
            'Nicu Tararache',
            'Cristi Ixfi',
            'Upwork',
            'Alex Carbunariu',
            'Mircea Branzei',
            'Stefan Stoean',
            'Mihnea Zamfirescu',
            'Dragos Tripeo',
            'Antonio Enache',
            'Gabi Victor',
            'Endi Nft Bucharest',
            'Cristian Orasanu',
            'Mihai BidHouse',
            'Alex Numeris',
            'Patru MocapArt',
            'Ionel Anton',
            'Italianul de la Ionel Anton',
            'Andreas Erschen',
            'Zaroschi Ana Maria',
            'Torok karoly Spqc',
            'Alexander Ledig'
        ];
        foreach($sources as $source){
            DB::table('projects_sources')->insert([
                'name' => $source
            ]);
        }
    }
}
