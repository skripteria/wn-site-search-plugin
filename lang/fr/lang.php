<?php return [
    'plugin'            => [
        'name'                       => 'SiteSearch',
        'description'                => 'Recherche globale pour votre frontend',
        'author'                     => 'Skripteria',
        'manage_settings'            => 'Gérer les paramètres de SiteSearch',
        'manage_settings_permission' => 'Peut gérer les paramètres de SiteSearch',
        'view_log_permission'        => 'Peut consulter le journal des requêtes',
    ],
    'settings'          => [
        'mark_results'               => 'Marquer les correspondances dans les résultats de recherche',
        'mark_results_comment'       => 'Enveloppez le terme de recherche dans des balises <mark>.',
        'log_queries'                => 'Log requêtes',
        'log_queries_comment'        => 'Enregistrer toutes les requêtes dans la base de données',
        'log_keep_days'              => 'Nettoyer le journal après plusieurs jours',
        'log_keep_days_comment'      => 'Supprimer les anciennes entrées du journal après ce nombre de jours (par défaut : 365)',
        'excerpt_length'             => 'Longueur de l\'extrait',
        'excerpt_length_comment'     => 'Longueur de l\'extrait affiché dans la liste des résultats de recherche.',
        'use_this_provider'          => 'Utiliser ce fournisseur',
        'use_this_provider_comment'  => 'Activer l\'affichage des résultats pour ce fournisseur',
        'provider_badge'             => 'Badge du fournisseur',
        'provider_badge_comment'     => 'Texte à afficher dans le badge d\'un résultat de recherche',
        'blog_posturl'               => 'Url de la page des articles du blog',
        'blog_posturl_comment'       => 'Ne spécifier que la partie fixe de l\'URL sans aucun paramètre dynamique',
        'blog_page'                  => 'Page des articles du blog',
        'blog_page_comment'          => 'Sélectionnez une page utilisée pour afficher un seul article du blog. Nécessaire pour former l\'URL des articles.',
        'album_page'                 => 'Page de l\'album',
        'album_page_comment'         => 'Sélectionnez une page utilisée pour afficher un album photo. Nécessaire pour former l\'URL des albums.',
        'photo_page'                 => 'Page photo',
        'photo_page_comment'         => 'Sélectionnez une page utilisée pour afficher une seule photo. Nécessaire pour former l\'URL des photos.',
        'portfolio_itemurl'          => 'Url de la page de détail du portfolio',
        'portfolio_itemurl_comment'  => 'Ne spécifier que la partie fixe de l\'URL sans aucun paramètre dynamique',
        'brands_itemurl'             => 'Url de la page détaillée d\'une marque',
        'brands_itemurl_comment'     => 'Ne spécifier que la partie fixe de l\'URL sans aucun paramètre dynamique',
        'showcase_itemurl'           => 'Url de la page de détail de la présentation',
        'showcase_itemurl_comment'   => 'Ne spécifier que la partie fixe de l\'URL sans aucun paramètre dynamique',
        'octoshop_itemurl'           => 'Url de la page détaillée d\'un produit',
        'octoshop_itemurl_comment'   => 'Ne spécifier que la partie fixe de l\'URL sans aucun paramètre dynamique',
        'octoshop_itemurl_badge'     => 'Produit',
        'snipcartshop_itemurl_badge' => 'Produit',
        'jkshop_itemurl'             => 'Url de la page détaillée d\'un produit',
        'jkshop_itemurl_comment'     => 'Ne spécifier que la partie fixe de l\'URL sans aucun paramètre dynamique',
        'jkshop_itemurl_badge'       => 'Produit',
        'experimental'               => 'Fonctionnalité expérimentale:',
        'experimental_refer_to_docs' => 'Ce fournisseur est expérimental !',
        'news_page'                  => 'Page des actualités',
        'news_page_comment'          => 'Sélectionnez une page utilisée pour afficher un seul article. Nécessaire pour former l\'URL des actualités.',
    ],
    'searchResults'     => [
        'title'       => 'Résultats de recherche',
        'description' => 'Affiche une liste des résultats de la recherche',
        'properties'  => [
            'no_results'       => [
                'title'       => 'Message aucun résultat',
                'description' => 'Ce qu\'il faut afficher, si aucun résultat n\'est retourné',
            ],
            'provider_badge'   => [
                'title'       => 'Afficher le badge du fournisseur',
                'description' => 'Afficher le nom du fournisseur de recherche pour chaque résultat',
            ],
            'results_per_page' => [
                'title' => 'Résultats par page',
            ],
            'visit_page'       => [
                'title'       => 'Label "Visitez la page"',
                'description' => 'Le texte de ce lien est placé sous chaque résultat',
            ],
        ],
    ],
    'searchInput'       => [
        'title'       => 'Formulaire de recherche',
        'description' => 'Affiche une saisie de recherche',
        'properties'  => [
            'use_auto_complete'          => [
                'title' => 'Recherche en cours de frappe',
            ],
            'auto_complete_result_count' => [
                'title' => 'Résultats max. de l\'autocomplétion',
            ],
            'search_page'                => [
                'title'       => 'Page de résultats de recherche',
                'description' => 'Votre recherche sera envoyée à cette page.',
                'null_value'  => '-- Ne pas afficher de lien',
            ],
        ],
    ],
    'siteSearchInclude' => [
        'title'       => 'Inclure dans SiteSearch',
        'description' => 'Ajouter ceci à une page CMS pour l\'inclure dans les résultats de recherche',
    ],
    'log'               => [
        'id'           => 'ID',
        'description'  => 'Journalisation de toutes les requêtes de recherche',
        'title'        => 'Requêtes de recherche',
        'title_update' => 'Vie search query',
        'query'        => 'Requête',
        'created_at'   => 'Créé le',
        'domain'       => 'Domaine',
        'location'     => 'Chemin',
        'session_id'   => 'Session',
        'export'       => 'Exporter le journal',
        'useragent'    => 'User agent',
    ],
];
