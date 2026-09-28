<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Identity;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Seeds some example content so the public page isn't empty
     * on first run. Feel free to edit/delete via the admin panel afterwards.
     *
     * Run with: php artisan db:seed --class=PortfolioSeeder
     */
    public function run(): void
    {
        Identity::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Jane Doe',
                'headline' => 'Full-Stack Web Developer',
                'bio' => 'I build clean, reliable web applications with Laravel, Vue, and Tailwind CSS. Passionate about performance, UX, and clean code.',
                'email' => 'jane@example.com',
                'phone' => '+62 812-0000-0000',
                'address' => 'Jakarta, Indonesia',
                'linkedin_url' => 'https://linkedin.com/in/janedoe',
                'github_url' => 'https://github.com/janedoe',
                'twitter_url' => null,
                'website_url' => null,
            ]
        );

        Education::updateOrCreate(
            ['id' => 1],
            [
                'degree' => 'B.Sc. in Computer Science',
                'institution' => 'University of Example',
                'start_date' => '2016-08-01',
                'end_date' => '2020-06-01',
                'description' => 'Focused on software engineering and web development. Graduated with honors.',
            ]
        );

        Experience::updateOrCreate(
            ['id' => 1],
            [
                'job_title' => 'Full-Stack Developer',
                'company' => 'Acme Tech',
                'location' => 'Jakarta, Indonesia',
                'start_date' => '2021-02-01',
                'end_date' => null,
                'is_current' => true,
                'responsibilities' => "Built and maintained internal tools using Laravel and Vue.\nCollaborated with design and product teams to ship new features.",
                'achievements' => 'Reduced page load time by 40% through query optimization and caching.',
            ]
        );

        $skills = [
            ['name' => 'HTML/CSS', 'category' => 'Frontend', 'proficiency' => 95, 'icon' => '🎨', 'sort_order' => 1],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'proficiency' => 85, 'icon' => '⚡', 'sort_order' => 2],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'proficiency' => 80, 'icon' => '🖖', 'sort_order' => 3],
            ['name' => 'PHP', 'category' => 'Backend', 'proficiency' => 90, 'icon' => '🐘', 'sort_order' => 1],
            ['name' => 'Laravel', 'category' => 'Backend', 'proficiency' => 90, 'icon' => '🔺', 'sort_order' => 2],
            ['name' => 'MySQL', 'category' => 'Database', 'proficiency' => 85, 'icon' => '🗄️', 'sort_order' => 1],
            ['name' => 'Git', 'category' => 'Tools', 'proficiency' => 90, 'icon' => '🔧', 'sort_order' => 1],
            ['name' => 'Docker', 'category' => 'Tools', 'proficiency' => 70, 'icon' => '🐳', 'sort_order' => 2],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name'], 'category' => $skill['category']],
                $skill
            );
        }
    }
}
