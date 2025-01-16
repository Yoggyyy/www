<?php

/**
 * Punto de entrada principal de la aplicación.
 * Gestiona el enrutamiento de las solicitudes y delega la lógica a los controladores correspondientes.
 * 
 * @author Jordi Santos Torres 
 * @version 1.0
 */

// Cargar configuración global y dependencias
require_once($_SERVER['DOCUMENT_ROOT'] . '/app/includes/connection.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/app/includes/env.inc.php');

// Obtener la página solicitada desde la URL
$page = $_GET['page'] ?? 'index';

/**
 * Enrutamiento principal
 * Procesa las solicitudes basadas en el valor del parámetro 'page'.
 */
try {
	switch ($page) {
		case 'index':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/IndexController.php');
			$controller = new IndexController();
			$controller->showIndex();
			break;

		case 'login':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/AuthController.php');
			$controller = new AuthController();
			$controller->login();
			break;

		case 'signup':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/AuthController.php');
			$controller = new AuthController();
			$controller->signup();
			break;

		case 'logout':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/AuthController.php');
			$controller = new AuthController();
			$controller->logout();
			break;

		case 'new':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/PostController.php');
			$controller = new PostController();
			$controller->createPost();
			break;

		case 'entry':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/PostController.php');
			$controller = new PostController();
			$controller->viewPost($_GET['id'] ?? null);
			break;

		case 'list':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/PostController.php');
			$controller = new PostController();
			$controller->listPosts();
			break;

		case 'account':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/AccountController.php');
			$controller = new AccountController();
			$controller->viewAccount();
			break;

		case 'cancel':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/AccountController.php');
			$controller = new AccountController();
			$controller->deleteAccount();
			break;

		case 'results':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/SearchController.php');
			$controller = new SearchController();
			$controller->search($_GET['query'] ?? '');
			break;

		case 'author':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommonController.php');
			$controller = new CommonController();
			$controller->showAuthor();
			break;
		case 'addComment':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommentController.php');
			$controller = new CommentController();
			$controller->addComment($_GET['postId']);
			break;

		case 'deleteComment':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommentController.php');
			$controller = new CommentController();
			$controller->deleteComment($_GET['id']);
			break;

		case 'listComments':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommentController.php');
			$controller = new CommentController();
			$controller->listComments($_GET['postId']);
			break;

		case 'search':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/SearchController.php');
			$controller = new SearchController();
			$controller->search($_GET['query'] ?? '');
			break;

		case 'author':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommonController.php');
			$controller = new CommonController();
			$controller->showAuthor();
			break;

		case 'terms':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommonController.php');
			$controller = new CommonController();
			$controller->showTerms();
			break;

		case 'addLike':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/PostController.php');
			$controller = new PostController();
			$controller->addLike($_GET['id']);
			break;

		case 'addDislike':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/PostController.php');
			$controller = new PostController();
			$controller->addDislike($_GET['id']);
			break;

		case 'followUser':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/UserController.php');
			$controller = new UserController();
			$controller->followUser($_GET['id']);
			break;

		case 'unfollowUser':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/UserController.php');
			$controller = new UserController();
			$controller->unfollowUser($_GET['id']);
			break;

		case 'userProfile':
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/UserController.php');
			$controller = new UserController();
			$controller->viewProfile($_GET['id']);
			break;


		default:
			require_once($_SERVER['DOCUMENT_ROOT'] . '/app/controllers/CommonController.php');
			$controller = new CommonController();
			$controller->show404();
			break;
	}
} catch (Exception $e) {
	// Manejo de errores global
	http_response_code(500);
	echo 'Se produjo un error interno en el servidor: ' . $e->getMessage();
}
