<?php

function validateUserForCreate(array $payload): array
{
	return validateFullUserPayload($payload);
}

function validateUserForPut(array $payload): array
{
	return validateFullUserPayload($payload);
}

function validateUserForPatch(array $payload): array
{
	if ($payload === []) {
		throw new InvalidArgumentException('At least one field is required for PATCH');
	}

	$allowedFields = ['name', 'age', 'email'];
	$keys = array_keys($payload);

	foreach ($keys as $key) {
		if (!in_array($key, $allowedFields, true)) {
			throw new InvalidArgumentException("Field $key is not allowed");
		}
	}

	if (count($keys) > 2) {
		throw new InvalidArgumentException('PATCH accepts only 1 or 2 fields');
	}

	$validated = [];

	if (array_key_exists('name', $payload)) {
		$validated['name'] = validateName($payload['name']);
	}

	if (array_key_exists('age', $payload)) {
		$validated['age'] = validateAge($payload['age']);
	}

	if (array_key_exists('email', $payload)) {
		$validated['email'] = validateEmail($payload['email']);
	}

	return $validated;
}

function validateFullUserPayload(array $payload): array
{
	$requiredFields = ['name', 'age', 'email'];

	foreach ($requiredFields as $field) {
		if (!array_key_exists($field, $payload)) {
			throw new InvalidArgumentException("Field $field is required");
		}
	}

	return [
		'name' => validateName($payload['name']),
		'age' => validateAge($payload['age']),
		'email' => validateEmail($payload['email']),
	];
}

function validateName(mixed $name): string
{
	if (!is_string($name)) {
		throw new InvalidArgumentException('name must be a string');
	}

	$name = trim($name);

	if ($name === '') {
		throw new InvalidArgumentException('name cannot be empty');
	}

	return $name;
}

function validateAge(mixed $age): int
{
	if (!is_numeric($age) || (int) $age < 0) {
		throw new InvalidArgumentException('age must be a non-negative integer');
	}

	return (int) $age;
}

function validateEmail(mixed $email): string
{
	if (!is_string($email)) {
		throw new InvalidArgumentException('email must be a string');
	}

	$email = trim($email);

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		throw new InvalidArgumentException('email is invalid');
	}

	return $email;
}
