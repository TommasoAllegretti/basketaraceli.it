<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Basket Araceli API',
                'version' => '1.0.0',
            ],
            'routes' => [
                'api' => 'api/documentation',
            ],
            'paths' => [
                'use_absolute_path' => true,
                'swagger_ui_assets_path' => 'vendor/swagger-api/swagger-ui/dist/',
                'docs_json' => 'docs/api-docs.json',
                'docs_yaml' => 'docs/api-docs.yaml',
                'format_to_use_for_docs' => 'json',
                'annotations' => [
                    base_path('app'),
                ],
            ],
        ],
    ],
    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group_options' => [],
        ],
        'paths' => [
            'docs' => public_path('docs'),
            'views' => base_path('resources/views/vendor/l5-swagger'),
            'base' => null,
            'excludes' => [],
        ],
        'scanOptions' => [
            'exclude' => [],
            'open_api_spec_version' => '3.0.0',
        ],
        'securityDefinitions' => [
            'securitySchemes' => [],
            'security' => [],
        ],
    ],
]; 