<?php

$router->get('/', [HomeController::class, 'index']);
$router->get('/mentions-legales', [HomeController::class, 'mentions']);

// Auth
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Public offers/companies
$router->get('/offers', [OfferController::class, 'list']);
$router->get('/offers/show', [OfferController::class, 'show']);
$router->get('/companies', [CompanyController::class, 'list']);
$router->get('/companies/show', [CompanyController::class, 'show']);

// Stats public
$router->get('/stats', [StatsController::class, 'index']);

// Student
$router->post('/wishlist/add', [WishlistController::class, 'add']);
$router->post('/wishlist/remove', [WishlistController::class, 'remove']);
$router->get('/wishlist', [WishlistController::class, 'index']);

$router->post('/apply', [ApplicationController::class, 'apply']);
$router->get('/my-applications', [ApplicationController::class, 'mine']);

// Pilot
$router->get('/pilot/applications', [PilotController::class, 'applications']);

// Admin/Pilot
$router->get('/admin', [AdminController::class, 'dashboard']);