<?php

final class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login', [
            'pageTitle'       => 'Connexion | CESI Stages',
            'pageDescription' => 'Connectez-vous à la plateforme CESI Stages pour accéder à vos offres de stage, candidatures et favoris.',
            'pageKeywords'    => 'connexion, login, CESI Stages, étudiant, pilote, administrateur',
        ]);
    }

    public function login(): void
    {
        Csrf::check();

        $email = trim(mb_strtolower($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            $this->flash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('/login');
            return;
        }

        $user = User::findByEmail($email);

        if (!$user) {
            $this->flash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('/login');
            return;
        }

        $hash = $user['password_hash'] ?? '';

        if ($hash === '' || !password_verify($password, $hash)) {
            $this->flash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('/login');
            return;
        }

        Auth::login($user);
        $this->redirect('/');
    }

    public function logout(): void
    {
        Csrf::check();
        Auth::logout();
        $this->redirect('/');
    }

    public function showChangePassword(): void
    {
        $this->requireLogin();
        $this->view('auth/change-password');
    }

    public function changePassword(): void
    {
        $this->requireLogin();
        Csrf::check();

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
            $this->flash('error', 'Tous les champs sont obligatoires.');
            $this->redirect('/change-password');
            return;
        }

        if (strlen($newPassword) < 8) {
            $this->flash('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
            $this->redirect('/change-password');
            return;
        }

        if ($newPassword !== $confirmPassword) {
            $this->flash('error', 'La confirmation du nouveau mot de passe ne correspond pas.');
            $this->redirect('/change-password');
            return;
        }

        if ($currentPassword === $newPassword) {
            $this->flash('error', 'Le nouveau mot de passe doit être différent de l’ancien.');
            $this->redirect('/change-password');
            return;
        }

        $userId = Auth::id();
        if ($userId === null) {
            $this->flash('error', 'Utilisateur non connecté.');
            $this->redirect('/login');
            return;
        }

        $user = User::find((int) $userId);

        if (!$user) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('/login');
            return;
        }

        if (!password_verify($currentPassword, $user['password_hash'] ?? '')) {
            $this->flash('error', 'Le mot de passe actuel est incorrect.');
            $this->redirect('/change-password');
            return;
        }

        User::updatePassword((int) $user['id'], $newPassword);

        $freshUser = User::find((int) $user['id']);
        if ($freshUser) {
            Auth::login($freshUser);
        }

        $this->flash('success', 'Mot de passe modifié avec succès.');
        $this->redirect('/');
    }
}