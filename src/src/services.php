<?php

require_once __DIR__ . '/data.php';
require_once __DIR__ . '/validation.php';

function getUsersService(string $dataFile): array
{
	return readUsersFromFile($dataFile);
}

function createUserService(string $dataFile, array $payload): array
{
	$validated = validateUserForCreate($payload);
	$users = readUsersFromFile($dataFile);

	$nextId = getNextUserId($users);
	$newUser = [
		'id' => $nextId,
		'name' => $validated['name'],
		'age' => $validated['age'],
		'email' => $validated['email'],
	];

	$users[] = $newUser;
	writeUsersToFile($dataFile, $users);

	return $newUser;
}

function updateUserPutService(string $dataFile, int $id, array $payload): array
{
	$validated = validateUserForPut($payload);
	$users = readUsersFromFile($dataFile);
	$index = findUserIndexById($users, $id);

	if ($index === -1) {
		throw new RuntimeException('User not found');
	}

	$updated = [
		'id' => $id,
		'name' => $validated['name'],
		'age' => $validated['age'],
		'email' => $validated['email'],
	];

	$users[$index] = $updated;
	writeUsersToFile($dataFile, $users);

	return $updated;
}

function updateUserPatchService(string $dataFile, int $id, array $payload): array
{
	$validated = validateUserForPatch($payload);
	$users = readUsersFromFile($dataFile);
	$index = findUserIndexById($users, $id);

	if ($index === -1) {
		throw new RuntimeException('User not found');
	}

	$existingUser = $users[$index];
	$updated = array_merge($existingUser, $validated);

	$users[$index] = $updated;
	writeUsersToFile($dataFile, $users);

	return $updated;
}

function deleteUserService(string $dataFile, int $id): void
{
	$users = readUsersFromFile($dataFile);
	$index = findUserIndexById($users, $id);

	if ($index === -1) {
		throw new RuntimeException('User not found');
	}

	array_splice($users, $index, 1);
	writeUsersToFile($dataFile, $users);
}
