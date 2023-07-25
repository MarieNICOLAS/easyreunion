@extends('layouts.app-front')

@section('title', 'Découvrez les membres de la Team Easy')
@section('meta-description', "Les membres de l’équipe d’Easy Réunion, des passionnés de l’évènements, spécialistes dans leur domaine. Une équipe conviviale, en quête d’excellence.")
@section('canonical', Request::url() )

@section('content')
<main class="flex flex-col">
    <div class="headinSet bgImg-team">
            <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">DÉCOUVEZ LA TEAM EASY</h1>
    </div>
    <h2 class="text-center m-10">Qui se cache derrière vos évènements ?</h2>
    <section class="bodyPages">
    <p class="mt-10">
        Notre équipe est composée de professionnels passionnés et expérimentés, qui sont déterminés à fournir des services de qualité supérieure à nos clients. 
        Nous sommes fiers de travailler ensemble pour atteindre nos objectifs communs.
    </p>
   
        <div class="team_Body">
             <ul class="grid_Gallery">
                <li class="profile-card">
                    <img src="{{ asset('images/equipe/come_jeannin-naltet-min.jpg') }}" alt="Côme photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/c%C3%B4me-jeannin-naltet-3179a342/" target="_blank" title="Côme Jeannin-Naltet profil Linkedin">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/c%C3%B4me-jeannin-naltet-3179a342/" target="_blank" title="Côme Jeannin-Naltet profil Linkedin">
                            <p class="profile-name">Côme Jeannin-Naltet</p>
                        </a>                        
                        <p class="profile-work">Directeur</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Jean-Baptiste_MICHEL-min.jpg') }}" alt="Jean-Baptiste photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/jean-baptiste-michel-0a172769/" title="Jean-Baptiste MICHEL profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/jean-baptiste-michel-0a172769/" title="Jean-Baptiste MICHEL profil Linkedin" target="_blank">
                            <p class="profile-name">Jean-Baptiste MICHEL</p>
                        </a>
                        <p class="profile-work">Responsable développement commercial</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Guillemette_LABOUREIX-min.jpg') }}" alt="Guillemette LABOUREIX photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/guillemette-laboureix-9a2bb340/" title="Guillemette LABOUREIX profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/guillemette-laboureix-9a2bb340/" title="Guillemette LABOUREIX profil Linkedin" target="_blank">
                            <p class="profile-name">Guillemette LABOUREIX</p>
                        </a>
                        <p class="profile-work">Responsable administratif et financier</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Guillaume_de_Kermadec-min.jpg') }}" alt="Guillaume de Kermadec photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/guillaume-de-kermadec-663b50a/" title="Guillaume de Kermadec profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/guillaume-de-kermadec-663b50a/" title="Guillaume de Kermadec profil Linkedin" target="_blank">
                            <p class="profile-name">Guillaume de Kermadec</p>
                        </a>
                        <p class="profile-work">Expert Métier formation</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Chloe_Briere-min.jpg') }}" alt="Chloé Briere photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/chlo%C3%A9-briere-687a7020b/" title="Chloé Briere profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/chlo%C3%A9-briere-687a7020b/" title="Chloé Briere profil Linkedin" target="_blank">                            
                            <p class="profile-name">Chloé Briere</p>
                        </a>
                        <p class="profile-work">Responsable Commerciale</p>
                    </div>
                </li>
                
            </ul>
            <p>
                Chacun de nos membres est choisi pour ses compétences, son expertise et sa personnalité unique. Nous sommes convaincus que cette combinaison est essentielle pour fournir des services de qualité supérieure à nos clients.
                Nous sommes constamment en train de nous former et de nous améliorer pour mieux répondre à vos besoins.
            </p>
            <ul class="grid_Gallery">
                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Nathalie-Tene-Walengo-min.jpg') }}" alt="Nathalie Tene Walengo photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/nathalie-tene-walengo-00306a221/" title="Nathalie Tene Walengo profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/nathalie-tene-walengo-00306a221/" title="Nathalie Tene Walengo profil Linkedin" target="_blank">
                            <p class="profile-name">Nathalie Tene Walengo</p>
                        </a>
                        <p class="profile-work">Assistante administrative</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Margaux_Charliac-min.jpg') }}" alt="Margaux Charliac photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/margaux-charliac-161354212/" title="Margaux Charliac profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/margaux-charliac-161354212/" title="Margaux Charliac profil Linkedin" target="_blank">
                            <p class="profile-name">Margaux Charliac</p>
                        </a>                        
                        <p class="profile-work">Assistante administrative</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Alyssa_Rodrigues-min.jpg') }}" alt="Alyssa Rodrigues photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/alyssa-kodabucas-rodrigues-202227akr/" title="Alyssa Rodrigues profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/alyssa-kodabucas-rodrigues-202227akr/" title="Alyssa Rodrigues profil Linkedin" target="_blank">
                            <p class="profile-name">Alyssa Rodrigues</p>
                        </a>
                        <p class="profile-work">Commerciale</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/maelle-min.jpg') }}" alt="Maëlle Demaret photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/ma%C3%ABlle-demaret-10/" title="Maëlle Demaret profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/ma%C3%ABlle-demaret-10/" title="Maëlle Demaret profil Linkedin" target="_blank">
                            <p class="profile-name">Maëlle Demaret</p>
                        </a>                        
                        <p class="profile-work">Chargée de marketing</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Juliette_Mille-min.jpg') }}" alt="Juliette Mille photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/juliette-mille-9658b5224/" title="Juliette Mille profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/juliette-mille-9658b5224/" title="Juliette Mille profil Linkedin" target="_blank">
                            <p class="profile-name">Juliette Mille</p>
                        </a>                        
                        <p class="profile-work">Chargée de communication</p>
                    </div>
                </li>

                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Raquel_Silva-min.jpg') }}" alt="Raquel Silva photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/raquel-oliveira-silva/" title="Raquel Silva" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/raquel-oliveira-silva/" title="Raquel Silva" target="_blank">
                            <p class="profile-name">Raquel Silva</p>
                        </a>                        
                        <p class="profile-work">Chargée de communication</p>
                    </div>
                </li>
                
                <li class="profile-card">
                    <img src="{{ asset('images/equipe/Antonio_Quadjovie-min.jpg') }}" alt="Antonio Quadjovie photo profil" class="profil-img">
                    <ul class="side-social">
                        <a href="https://www.linkedin.com/in/antonio-quadjovie/" title="Antonio Quadjovie profil Linkedin" target="_blank">
                            <img src="{{ asset('images/about/linkedin-logo-2430.svg') }}" alt="icon Linkedin">
                        </a>
                    </ul>
                    <div class="profile-info rest">
                        <a href="https://www.linkedin.com/in/antonio-quadjovie/" title="Antonio Quadjovie profil Linkedin" target="_blank">
                            <p class="profile-name">Antonio Quadjovie</p>
                        </a>                        
                        <p class="profile-work">Développeur web</p>
                    </div>
                </li>
            </ul>
            <p>
                N'hésitez pas à nous contacter si vous avez des questions ou si vous souhaitez en savoir plus sur notre équipe.
                Nous sommes impatients de vous rencontrer et de travailler avec vous.
            </p>
        </div>
        
    </section>
</main>

@endsection
