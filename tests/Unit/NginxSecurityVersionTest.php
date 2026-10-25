<?php

test('Coolify images pin nginx versions with the published security fixes', function (string $dockerfile) {
    $source = remoteOutputSource($dockerfile);

    expect(preg_match('/^ARG NGINX_VERSION=([0-9]+\\.[0-9]+\\.[0-9]+)-r[0-9]+$/m', $source, $matches))
        ->toBe(1);

    $version = $matches[1];
    $minimum = str_starts_with($version, '1.30.') ? '1.30.6' : '1.31.7';

    expect(version_compare($version, $minimum, '>='))->toBeTrue();
})->with([
    'production' => 'docker/production/Dockerfile',
    'development' => 'docker/development/Dockerfile',
]);
