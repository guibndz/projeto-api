<?php

require_once __DIR__ . '/services.php';

function handleGet(string $dataFile): void
{
	$users = getUsersService($dataFile);
	jsonResponse(['users' => $users], 200);
}

function handlePost(string $dataFile): void
{
	try {
		$payload = getJsonBody();
		$user = createUserService($dataFile, $payload);
		jsonResponse($user, 201);
	} catch (InvalidArgumentException $exception) {
		jsonError($exception->getMessage(), 422);
	}
}

function handlePut(string $dataFile): void
{
	try {
		$id = getUserIdFromQuery();
		$payload = getJsonBody();
		$user = updateUserPutService($dataFile, $id, $payload);
		jsonResponse($user, 200);
	} catch (InvalidArgumentException $exception) {
		jsonError($exception->getMessage(), 422);
	} catch (RuntimeException $exception) {
		jsonError($exception->getMessage(), 404);
	}
}

function handlePatch(string $dataFile): void
{
	try {
		$id = getUserIdFromQuery();
		$payload = getJsonBody();
		$user = updateUserPatchService($dataFile, $id, $payload);
		jsonResponse($user, 200);
	} catch (InvalidArgumentException $exception) {
		jsonError($exception->getMessage(), 422);
	} catch (RuntimeException $exception) {
		jsonError($exception->getMessage(), 404);
	}
}

function handleDelete(string $dataFile): void
{
	try {
		$id = getUserIdFromQuery();
		deleteUserService($dataFile, $id);
		jsonResponse(['message' => 'User deleted'], 200);
	} catch (InvalidArgumentException $exception) {
		jsonError($exception->getMessage(), 422);
	} catch (RuntimeException $exception) {
		jsonError($exception->getMessage(), 404);
	}
}

function handleMethodNotAllowed(): void
{
	header('Allow: GET, POST, PUT, PATCH, DELETE, OPTIONS');
	jsonError('Method not allowed', 405);
}

function getJsonBody(): array
{
	$rawBody = file_get_contents('php://input');

	if ($rawBody === false || trim($rawBody) === '') {
		return [];
	}

	$data = json_decode($rawBody, true);

	if (!is_array($data)) {
		throw new InvalidArgumentException('Invalid JSON body');
	}

	return $data;
}

function getUserIdFromQuery(): int
{
	$idRaw = $_GET['id'] ?? null;

	if ($idRaw === null || $idRaw === '') {
		throw new InvalidArgumentException('Query parameter id is required');
	}

	if (!is_numeric($idRaw) || (int) $idRaw <= 0) {
		throw new InvalidArgumentException('id must be a positive integer');
	}

	return (int) $idRaw;
}

function jsonResponse(array $payload, int $statusCode): void
{
	http_response_code($statusCode);
	echo json_encode($payload, JSON_UNESCAPED_UNICODE);
	exit;
}

function jsonError(string $message, int $statusCode): void
{
	jsonResponse(['error' => $message], $statusCode);
}
