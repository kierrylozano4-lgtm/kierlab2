<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class MarketplaceServiceSeeder extends Seeder
{
    /**
     * @var list<array{title: string, category: string, description: string, price: float|null, price_negotiable: bool, price_note: string|null}>
     */
    private const SERVICES = [
        ['title' => 'Calculus tutoring', 'category' => 'Academic', 'description' => 'One-on-one help with derivatives, integrals, and problem-solving strategies.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Essay proofreading', 'category' => 'Academic', 'description' => 'Grammar, clarity, and structure feedback for academic essays.', 'price' => 150.00, 'price_negotiable' => true, 'price_note' => 'Based on document length'],
        ['title' => 'Chemistry study session', 'category' => 'Academic', 'description' => 'Review chemistry concepts and work through practice questions together.', 'price' => 200.00, 'price_negotiable' => false, 'price_note' => 'Per session'],
        ['title' => 'Physics problem-solving', 'category' => 'Academic', 'description' => 'Guided practice for mechanics, electricity, and introductory physics.', 'price' => 220.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Filipino language tutoring', 'category' => 'Academic', 'description' => 'Conversation practice, grammar review, and help with Filipino assignments.', 'price' => 180.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'English conversation practice', 'category' => 'Academic', 'description' => 'Friendly speaking practice to build confidence and fluency in English.', 'price' => 150.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Research outline coaching', 'category' => 'Academic', 'description' => 'Organize your research question, objectives, and chapter outline.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Consultation rate'],
        ['title' => 'Statistics homework help', 'category' => 'Academic', 'description' => 'Understand descriptive statistics, probability, and hypothesis testing.', 'price' => 220.00, 'price_negotiable' => false, 'price_note' => 'Per hour'],
        ['title' => 'Basic accounting review', 'category' => 'Academic', 'description' => 'Practice journal entries, financial statements, and accounting fundamentals.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Biology exam preparation', 'category' => 'Academic', 'description' => 'Create a focused review plan and work through biology practice questions.', 'price' => 180.00, 'price_negotiable' => true, 'price_note' => 'Per session'],
        ['title' => 'Programming fundamentals tutoring', 'category' => 'Academic', 'description' => 'Get help with variables, loops, functions, and introductory programming tasks.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Thesis presentation practice', 'category' => 'Academic', 'description' => 'Practice your presentation delivery and improve slide flow and timing.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Per practice session'],
        ['title' => 'Study notes and flashcards', 'category' => 'Academic', 'description' => 'Custom study notes and flashcards made from your class materials.', 'price' => 120.00, 'price_negotiable' => false, 'price_note' => 'Starting rate'],
        ['title' => 'Reading comprehension coaching', 'category' => 'Academic', 'description' => 'Build practical strategies for understanding and summarizing readings.', 'price' => 160.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Economics concept review', 'category' => 'Academic', 'description' => 'Review microeconomics and macroeconomics concepts with worked examples.', 'price' => 210.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Spanish beginner conversation', 'category' => 'Academic', 'description' => 'Practice beginner Spanish vocabulary and everyday conversations.', 'price' => 180.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Resume and CV review', 'category' => 'Personal', 'description' => 'Get clear feedback on your resume layout, wording, and student experience.', 'price' => 180.00, 'price_negotiable' => true, 'price_note' => 'One revision included'],
        ['title' => 'Interview practice session', 'category' => 'Personal', 'description' => 'Prepare for internships with mock interview questions and constructive feedback.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Per session'],
        ['title' => 'Portrait photography', 'category' => 'Personal', 'description' => 'Casual campus portraits with basic color correction and selected edits.', 'price' => 500.00, 'price_negotiable' => true, 'price_note' => 'Session package'],
        ['title' => 'Event photography', 'category' => 'Personal', 'description' => 'Photo coverage for small student events and organization activities.', 'price' => 800.00, 'price_negotiable' => true, 'price_note' => 'Rate depends on event length'],
        ['title' => 'Custom digital illustration', 'category' => 'Personal', 'description' => 'Original digital artwork for gifts, student projects, or profile images.', 'price' => 350.00, 'price_negotiable' => true, 'price_note' => 'Price depends on detail'],
        ['title' => 'Poster and invitation design', 'category' => 'Personal', 'description' => 'Design a polished digital poster or invitation for your campus activity.', 'price' => 300.00, 'price_negotiable' => true, 'price_note' => 'One design with revisions'],
        ['title' => 'Handmade greeting cards', 'category' => 'Personal', 'description' => 'Personalized handmade cards for birthdays, celebrations, and thank-you notes.', 'price' => 100.00, 'price_negotiable' => false, 'price_note' => 'Materials included'],
        ['title' => 'Basic haircut appointment', 'category' => 'Personal', 'description' => 'Simple, neat haircut by appointment near campus.', 'price' => 120.00, 'price_negotiable' => false, 'price_note' => 'Bring your preferred style reference'],
        ['title' => 'Dorm room organization', 'category' => 'Personal', 'description' => 'Practical help organizing a small dorm room and planning storage.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Laundry pickup and fold', 'category' => 'Personal', 'description' => 'Convenient laundry pickup, folding, and return within the campus area.', 'price' => 100.00, 'price_negotiable' => true, 'price_note' => 'Rate depends on load size'],
        ['title' => 'Plant care while away', 'category' => 'Personal', 'description' => 'Water and check on your dorm plants while you are away for a short trip.', 'price' => 80.00, 'price_negotiable' => true, 'price_note' => 'Per visit'],
        ['title' => 'Meal prep for busy students', 'category' => 'Personal', 'description' => 'Simple, budget-conscious meal preparation planned around your schedule.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Ingredients charged separately'],
        ['title' => 'Campus errands assistance', 'category' => 'Personal', 'description' => 'Help with small errands around campus when your class schedule is packed.', 'price' => 80.00, 'price_negotiable' => true, 'price_note' => 'Per errand'],
        ['title' => 'Pet sitting near campus', 'category' => 'Personal', 'description' => 'Responsible short-term pet care for students living near campus.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Per visit'],
        ['title' => 'Beginner guitar lessons', 'category' => 'Personal', 'description' => 'Learn basic chords, strumming patterns, and a few songs at your pace.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Beginner fitness accountability', 'category' => 'Personal', 'description' => 'Plan simple workouts and stay consistent with a friendly accountability partner.', 'price' => 120.00, 'price_negotiable' => true, 'price_note' => 'Per session'],
        ['title' => 'Secondhand textbook exchange', 'category' => 'Personal', 'description' => 'Affordable pre-loved textbooks; message to check available titles and condition.', 'price' => 0.00, 'price_negotiable' => true, 'price_note' => 'Price varies by book'],
        ['title' => 'Laptop troubleshooting', 'category' => 'Tech', 'description' => 'Diagnose common laptop issues, software problems, and slow performance.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Diagnostics; parts not included'],
        ['title' => 'Phone setup and data transfer', 'category' => 'Tech', 'description' => 'Set up a new phone and help transfer contacts, photos, and basic settings.', 'price' => 200.00, 'price_negotiable' => false, 'price_note' => 'Per device'],
        ['title' => 'Wi-Fi and printer setup', 'category' => 'Tech', 'description' => 'Connect your laptop, phone, or printer to a home or dorm network.', 'price' => 150.00, 'price_negotiable' => true, 'price_note' => 'Per setup'],
        ['title' => 'Website portfolio setup', 'category' => 'Tech', 'description' => 'Build a simple student portfolio page to showcase projects and contact details.', 'price' => 900.00, 'price_negotiable' => true, 'price_note' => 'Scope discussed before work'],
        ['title' => 'Basic website bug fixing', 'category' => 'Tech', 'description' => 'Get help investigating layout issues, broken links, or small front-end bugs.', 'price' => 300.00, 'price_negotiable' => true, 'price_note' => 'Rate depends on issue'],
        ['title' => 'Spreadsheet formulas and cleanup', 'category' => 'Tech', 'description' => 'Organize a spreadsheet and add useful formulas, sorting, or validation.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Presentation slide design', 'category' => 'Tech', 'description' => 'Improve your presentation slides with consistent layout and readable visuals.', 'price' => 300.00, 'price_negotiable' => true, 'price_note' => 'Rate depends on slide count'],
        ['title' => 'Photo editing and retouching', 'category' => 'Tech', 'description' => 'Basic photo color correction, cropping, and cleanup for your selected images.', 'price' => 150.00, 'price_negotiable' => true, 'price_note' => 'Per image set'],
        ['title' => 'Short video editing', 'category' => 'Tech', 'description' => 'Edit a short student project or social video with simple cuts and titles.', 'price' => 400.00, 'price_negotiable' => true, 'price_note' => 'Rate depends on footage length'],
        ['title' => 'Computer software installation', 'category' => 'Tech', 'description' => 'Install and configure commonly used software on your personal computer.', 'price' => 150.00, 'price_negotiable' => false, 'price_note' => 'Software licenses not included'],
        ['title' => 'Data backup planning', 'category' => 'Tech', 'description' => 'Set up a straightforward backup plan for important school files and photos.', 'price' => 180.00, 'price_negotiable' => true, 'price_note' => 'Storage device not included'],
        ['title' => 'Intro to coding with Python', 'category' => 'Tech', 'description' => 'A beginner-friendly introduction to Python syntax and small programs.', 'price' => 250.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Git and GitHub basics', 'category' => 'Tech', 'description' => 'Learn essential Git commands and how to share a project through GitHub.', 'price' => 220.00, 'price_negotiable' => true, 'price_note' => 'Per session'],
        ['title' => 'Custom PC cleaning and setup', 'category' => 'Tech', 'description' => 'Basic desktop cleanup and setup guidance; hardware parts are not included.', 'price' => 300.00, 'price_negotiable' => true, 'price_note' => 'Hardware condition checked first'],
        ['title' => 'Canva design coaching', 'category' => 'Tech', 'description' => 'Learn practical Canva tools to create clean posters and social graphics.', 'price' => 180.00, 'price_negotiable' => true, 'price_note' => 'Per hour'],
        ['title' => 'Digital file organization', 'category' => 'Tech', 'description' => 'Sort course files into a clear folder structure and set up a naming system.', 'price' => 120.00, 'price_negotiable' => false, 'price_note' => 'Per device'],
        ['title' => 'Basic cybersecurity checkup', 'category' => 'Tech', 'description' => 'Review account security basics, device updates, and safer password practices.', 'price' => 200.00, 'price_negotiable' => true, 'price_note' => 'Educational guidance only'],
    ];

    public function run(): void
    {
        $provider = User::query()
            ->where('email', 'test@example.com')
            ->firstOrFail();

        foreach (self::SERVICES as $service) {
            Service::query()->firstOrCreate(
                [
                    'user_id' => $provider->id,
                    'title' => $service['title'],
                ],
                [
                    ...$service,
                    'status' => 'Active',
                    'visible_in_dashboard' => true,
                ],
            );
        }
    }
}
