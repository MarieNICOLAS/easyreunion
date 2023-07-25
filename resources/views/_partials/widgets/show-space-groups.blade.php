@php
    use App\Models\Tag;
    use Illuminate\Database\Eloquent\Collection;


    // Default variables values
    $route_name ??= 'spaceGroup';
    $show_search_bar ??= false;
    // ------------------------


    /*
     * Avant de débuter la lecture, voici les différentes variables d'initialisation (soit les variables définies lors
     * de l'intégration de ce template et les variables GET) :
     *
     *   - 'route_name' correspondant à la route qui sera appelée lorsque l'on clique sur les cartes.
     *   - 'show_search_bar' correspondant à une booléenne permettant l'affichage (ou non) de la barre de recherche.
     *   - 'city' correspondant à la ville recherchée.
     *   - 'type' correspond au type recherché.
     *   - 'number_attendees' correspond au nombre de participants attendus.
     *   - 'handicap_access' correspond au booléen permettant de savoir si l'espace a un accès pour les handicapés.
     *   - 'natural_light' correspond au booléean permettant de savoir si l'espace utilise de la lumière naturelle.
     */


    /*
     * Les résutats seront affichés à l'aide d'un tableau, dont celui-ci aura la forme suivante :
     *
     * PS: Pour chaque exemple, on considère que "..." correspond aux espaces/salles.
     *
     * Si la ville a été définie (seulement) : on aura deux clés nommés correspondant à la ville et au type.
     * array(
     *     'delaunay' => [
     *        'erp' => ...,
     *        'wedding' => ...,
     *     ]
     * )
     *
     * Si le type a été définie (seulement) : on utilisera uniquement comme clés nommés le nom de la ville.
     * array(
     *     'delaunay' => [ ... ],
     *     'leclerc' => [ ... ]
     * )
     *
     * Si la ville et le type ont été définies : on retournera le tableau de la recherche directement
     * (autrement dit, on ne met pas les résultats dans la combinaison de clés "ville-type").
     * array ( ... )
     *
     *
     * Processus de création du "tableau" correspondant au résultat :
     *
     * - On initialise le tableau des résultats
     * - Si la ville n'a pas été définie :
     *      - Si le type n'a pas été définie :
     *          - On initialise pour chaque ville les différents types et récupères les espaces/salles pour chaque type.
     *      - Sinon :
     *          - On récupère l'ensemble des espaces/salles ayant ce type.
     * - Sinon :
     *      - Si le type n'a pas été définie :
     *          - On récupères les espaces/salles pour chaque type.
     *      - Sinon :
     *          - On récupère l'ensemble des espaces/salles ayant cette ville et ce type.
     *
     * Une fois le tableau récuperé, on affichera avec en fonction des conditions ci-dessus.
     */

    // Ensemble des villes disponibles :
    $available_cities = \App\Models\SpaceGroup::getAvailableCities();
    // Ensemble des types enregistrés :
    $available_types = Tag::types();



    // Début du protocole de recherche

    // Les variables utilisées : 'result' correspont aux résultats, '_result' correspondant aux entrées récupérées avant
    // leur traitement.
    $result = []; $_result = null;

    // condition équivalente (en "pseudo code php") : isset($city) && !!$city
    if (!!$city ?? false) {

        // condition similaire (à la variable près) à la précédente.
        if (!!$type ?? false) {
            $_result = \App\Models\SpaceGroup::with('images')->searchTypeAndCity($type, $city);
            $_result = Collection::make($_result);

            $result = $_result->toArray();
        }
        else {
                $_result = \App\Models\SpaceGroup::with('images')->searchCity($city)->get();
                $result = $_result->toArray();
        }

    }
    else {

        foreach ( $available_cities as $_city ) {

            if (!!$type ?? false) {

                $_result = \App\Models\SpaceGroup::with('images')->searchTypeAndCity($type, $_city);
                $result[$_city] = $_result;

            }
            else {

                $_result = \App\Models\SpaceGroup::with('images')->searchCity($_city);
                $result = $_result;

            }

        }

    }

    // Fin du protocole
@endphp

<div data-cs-elements="frame" class="flex flex-col gap-y-16">
    @if($show_search_bar)
        @include('_partials.components.search-form', compact('city', 'type'))
    @endif

    @include('_partials.components.cards.index', [
        'route_name' => $route_name,
        'cards' => $result
    ])
</div>

{{--
{{ $space_groups->links() }}
--}}
