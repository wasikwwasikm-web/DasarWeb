<?php
$databaseUrl = getenv('DATABASE_URL');

if ($databaseUrl !== false && $databaseUrl !== '') {
    $parts = parse_url($databaseUrl);

    if (
        $parts === false
        || !in_array($parts['scheme'] ?? '', ['postgres', 'postgresql'], true)
        || empty($parts['host'])
        || empty($parts['path'])
        || !isset($parts['user'], $parts['pass'])
    ) {
        throw new InvalidArgumentException('DATABASE_URL must be a valid PostgreSQL connection URL.');
    }

    $query = [];
    parse_str($parts['query'] ?? '', $query);

    return [
        'db_host' => $parts['host'],
        'db_port' => $parts['port'] ?? '5432',
        'db_name' => rawurldecode(ltrim($parts['path'], '/')),
        'db_user' => rawurldecode($parts['user']),
        'db_pass' => rawurldecode($parts['pass']),
        'db_sslmode' => $query['sslmode'] ?? (getenv('DB_SSLMODE') ?: 'require'),
    ];
}

return [
    'db_host' => getenv('DB_HOST') ?: 'localhost',
    'db_port' => getenv('DB_PORT') ?: '5432',
    'db_name' => getenv('DB_NAME') ?: 'simpus_mini',
    'db_user' => getenv('DB_USER') ?: 'postgres',
    'db_pass' => getenv('DB_PASS') ?: 'postgres',
    'db_sslmode' => getenv('DB_SSLMODE') ?: 'require',
];
