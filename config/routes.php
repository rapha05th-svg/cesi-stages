<?php

$router->get('/', [HomeController::class, 'index']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/change-password', [AuthController::class, 'showChangePassword']);
$router->post('/change-password', [AuthController::class, 'changePassword']);

$router->get('/offers', [OfferController::class, 'list']);
$router->get('/offers/show', [OfferController::class, 'show']);

$router->get('/companies', [CompanyController::class, 'list']);
$router->get('/companies/show', [CompanyController::class, 'show']);

$router->get('/wishlist', [WishlistController::class, 'index']);
$router->post('/wishlist/toggle', [WishlistController::class, 'toggle']);

$router->get('/favorite-companies', [CompanyFavoriteController::class, 'index']);
$router->post('/favorite-companies/toggle', [CompanyFavoriteController::class, 'toggle']);

$router->post('/apply', [ApplicationController::class, 'apply']);
$router->get('/my-applications', [ApplicationController::class, 'mine']);

$router->get('/pilot/applications', [PilotController::class, 'applications']);

$router->get('/admin', [AdminController::class, 'dashboard']);

$router->get('/admin/companies', [AdminController::class, 'companies']);
$router->get('/admin/companies/create', [AdminController::class, 'createCompany']);
$router->post('/admin/companies/store', [AdminController::class, 'storeCompany']);
$router->get('/admin/companies/edit', [AdminController::class, 'editCompany']);
$router->post('/admin/companies/update', [AdminController::class, 'updateCompany']);
$router->post('/admin/companies/delete', [AdminController::class, 'deleteCompany']);
$router->post('/companies/rate', [CompanyController::class, 'rate']);

$router->get('/admin/offers', [AdminController::class, 'offers']);
$router->get('/admin/offers/create', [AdminController::class, 'createOffer']);
$router->post('/admin/offers/store', [AdminController::class, 'storeOffer']);
$router->get('/admin/offers/edit', [AdminController::class, 'editOffer']);
$router->post('/admin/offers/update', [AdminController::class, 'updateOffer']);
$router->post('/admin/offers/delete', [AdminController::class, 'deleteOffer']);

$router->get('/admin/students', [AdminController::class, 'students']);
$router->get('/admin/students/create', [AdminController::class, 'createStudent']);
$router->post('/admin/students/store', [AdminController::class, 'storeStudent']);
$router->get('/admin/students/edit', [AdminController::class, 'editStudent']);
$router->post('/admin/students/update', [AdminController::class, 'updateStudent']);
$router->post('/admin/students/delete', [AdminController::class, 'deleteStudent']);

$router->get('/admin/pilots', [AdminController::class, 'pilots']);
$router->get('/admin/pilots/create', [AdminController::class, 'createPilot']);
$router->post('/admin/pilots/store', [AdminController::class, 'storePilot']);
$router->get('/admin/pilots/edit', [AdminController::class, 'editPilot']);
$router->post('/admin/pilots/update', [AdminController::class, 'updatePilot']);
$router->post('/admin/pilots/delete', [AdminController::class, 'deletePilot']);

$router->get('/admin/users/reset-password', [AdminController::class, 'showResetUserPassword']);
$router->post('/admin/users/reset-password', [AdminController::class, 'resetUserPassword']);

$router->get('/mentions-legales', [HomeController::class, 'legalNotice']);

$router->get('/wishlist', [WishlistController::class, 'index']);
$router->post('/wishlist/add', [WishlistController::class, 'add']);
$router->post('/wishlist/toggle', [WishlistController::class, 'toggle']);
$router->get('/stats', [StatsController::class, 'index']);

$router->get('/cv', [ApplicationController::class, 'serveCv']);