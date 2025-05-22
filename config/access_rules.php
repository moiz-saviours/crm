<?php
return [
    'sales' => [
        'routes' => [
            'user.dashboard',
            'user.profile',
            'user.profile.image.update',
            'user.profile.update',
            'customer.company.index',
            'customer.contact.index',
            'customer.contact.store',
            'customer.contact.edit',
            'customer.contact.update',
            'team-member.index',
            'brand.index',
            'lead.index',
            'lead.change.lead-status',
            'lead-status.index',
            'invoice.index',
            'invoice.store',
            'invoice.edit',
            'invoice.update',
            'invoice.payment_proofs',
            'user.client.account.by.brand',
            'payment.index',
            'payment-transaction-logs',
            'save.settings',
        ],
    ],
    'development' => [
        'routes' => [
        ],
    ],
    'marketing' => [
        'routes' => [
            'user.dashboard', // Marketing dashboard
            'user.profile',
            'user.profile.image.update',
            'user.profile.update',
        ],
    ],
    'humanresources' => [
        'routes' => [
        ],
    ],
    'operations' => [
        'roles' => [
            'Q/A Analyst' => [
                'routes' => [
                ],
            ],
            'Accounts' => [
                'routes' => [
                    'user.dashboard',
                    'user.profile',
                    'user.profile.image.update',
                    'user.profile.update',
                    'user.client.contact.index',
                    'user.client.contact.store',
                    'user.client.contact.edit',
                    'user.client.contact.update',
                    'user.client.contact.change.status',
                    'user.client.company.index',
                    'user.client.company.store',
                    'user.client.contact.companies',
                    'user.client.company.edit',
                    'user.client.company.update',
                    'user.client.company.change.status',
                    'user.client.account.index',
                    'user.client.account.store',
                    'user.client.account.edit',
                    'user.client.account.update',
                    'user.client.account.change.status',
                    'payment.index',
                    'payment-transaction-logs',
                    'save.settings',
                ],
                'restrictions' => [
                ],
            ],
        ],
    ],
];
