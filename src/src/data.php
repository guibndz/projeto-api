<?php

function readUsersFromFile(string $dataFile): array
{
	ensureDataFile($dataFile);

	$content = file_get_contents($dataFile);

	if ($content === false || trim($content) === '') {
		return [];
	}

	$decoded = json_decode($content, true);

	if (!is_array($decoded)) {
		writeUsersToFile($dataFile, []);
		return [];
	}

	if (array_key_exists('users', $decoded) && is_array($decoded['users'])) {
		return $decoded['users'];
	}

	return array_is_list($decoded) ? $decoded : [];
}

function writeUsersToFile(string $dataFile, array $users): void
{
	ensureDataFile($dataFile);

	$payload = json_encode(['users' => array_values($users)], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

	if ($payload === false) {
		throw new RuntimeException('Failed to encode JSON data');
	}

	if (file_put_contents($dataFile, $payload . PHP_EOL, LOCK_EX) === false) {
		throw new RuntimeException('Failed to write data file');
	}
}

function ensureDataFile(string $dataFile): void
{
	$directory = dirname($dataFile);

	if (!is_dir($directory)) {
		mkdir($directory, 0777, true);
	}

	if (!file_exists($dataFile) || filesize($dataFile) === 0) {
		file_put_contents($dataFile, "{\n    \"users\": []\n}\n", LOCK_EX);
	}
}

function findUserIndexById(array $users, int $id): int
{
	foreach ($users as $index => $user) {
		if (isset($user['id']) && (int) $user['id'] === $id) {
			return $index;
		}
	}

	return -1;
}

function getNextUserId(array $users): int
{
	$maxId = 0;

	foreach ($users as $user) {
		$id = isset($user['id']) ? (int) $user['id'] : 0;

		if ($id > $maxId) {
			$maxId = $id;
		}
	}

	return $maxId + 1;
}
