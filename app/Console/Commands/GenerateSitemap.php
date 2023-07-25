<?php

namespace App\Console\Commands;

use App\Models\Front\BlogArticle;
use App\Models\Page;
use App\Models\Space;
use App\Models\SpaceGroup;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add('/')
            ->add('/qui-sommes-nous')
            ->add('/notre-equipe')
            ->add('/vos-temoignages')
            ->add('/login')
            ->add('/register')
            ->add('/jobs')
            ->add('/mentions-legales')
            ->add('/cgv')
            ->add('/contactez-nous')
            ->add('/services-restauration')
            ->add('/services-technique')
            ->add('/articles')
            ->add('/plan-du-site')
            ->add('/pages/faq')
            ->add('/location-salle-paris')
            ->add(BlogArticle::where('status', '=', 'online')->get())
            ->add(Space::all())
            ->add(SpaceGroup::where('status', '=', 'online')->get())
            ->add(Page::all())
        ;

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
