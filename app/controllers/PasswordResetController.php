<?php

final class PasswordResetController extends Controller
{
    public function showForgotPassword(): void
    {
        if (Auth::check()) {
            $this->redirect('/');
        }

        $this->view('auth/forgot-password', [
            'pageTitle'       => 'Mot de passe oublié | CESI Stages',
            'pageDescription' => 'Réinitialisez votre mot de passe CESI Stages.',
        ]);
    }

    public function sendResetEmail(): void
    {
        if (Auth::check()) {
            $this->redirect('/');
        }

        Csrf::check();

        $email = trim(mb_strtolower($_POST['email'] ?? ''));

        // Message générique pour éviter l'énumération de comptes
        $genericMsg = 'Si cette adresse est associée à un compte, un e-mail de réinitialisation vous a été envoyé.';

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('error', 'Adresse e-mail invalide.');
            $this->redirect('/forgot-password');
            return;
        }

        $user = User::findByEmail($email);

        if (!$user) {
            // Ne pas révéler si le compte existe ou non
            $this->flash('success', $genericMsg);
            $this->redirect('/forgot-password');
            return;
        }

        // Nettoyer les tokens expirés au passage
        PasswordReset::deleteExpired();

        $token = PasswordReset::create((int) $user['id']);

        $scheme   = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base     = App::config()['app']['base_path'] ?? '';
        $resetUrl = "{$scheme}://{$host}{$base}/reset-password?token={$token}";

        $debug = App::config()['mail']['debug'] ?? false;

        if ($debug) {
            // Mode développement : afficher le lien directement sur la page
            $this->flash('success', $genericMsg);
            $safeUrl = htmlspecialchars($resetUrl);
            $this->flash('dev', 'Cliquez ici pour réinitialiser votre mot de passe : <a href="' . $safeUrl . '" style="color:#1d4ed8;word-break:break-all;">Réinitialiser mon mot de passe</a>');
        } else {
            Mailer::sendPasswordReset($email, $email, $resetUrl);
            $this->flash('success', $genericMsg);
        }

        $this->redirect('/forgot-password');
    }

    public function showResetPassword(): void
    {
        if (Auth::check()) {
            $this->redirect('/');
        }

        $token = trim($_GET['token'] ?? '');

        if ($token === '') {
            $this->flash('error', 'Lien de réinitialisation invalide.');
            $this->redirect('/forgot-password');
            return;
        }

        $record = PasswordReset::findValid($token);

        if (!$record) {
            $this->flash('error', 'Ce lien est invalide ou a expiré. Veuillez en demander un nouveau.');
            $this->redirect('/forgot-password');
            return;
        }

        $this->view('auth/reset-password', [
            'pageTitle'       => 'Nouveau mot de passe | CESI Stages',
            'pageDescription' => 'Choisissez un nouveau mot de passe pour votre compte CESI Stages.',
            'token'           => $token,
        ]);
    }

    public function resetPassword(): void
    {
        if (Auth::check()) {
            $this->redirect('/');
        }

        Csrf::check();

        $token           = trim($_POST['token'] ?? '');
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($token === '') {
            $this->flash('error', 'Token manquant.');
            $this->redirect('/forgot-password');
            return;
        }

        $record = PasswordReset::findValid($token);

        if (!$record) {
            $this->flash('error', 'Ce lien est invalide ou a expiré. Veuillez en demander un nouveau.');
            $this->redirect('/forgot-password');
            return;
        }

        if ($newPassword === '' || $confirmPassword === '') {
            $this->flash('error', 'Tous les champs sont obligatoires.');
            $this->redirect('/reset-password?token=' . urlencode($token));
            return;
        }

        if (strlen($newPassword) < 8) {
            $this->flash('error', 'Le mot de passe doit contenir au moins 8 caractères.');
            $this->redirect('/reset-password?token=' . urlencode($token));
            return;
        }

        if ($newPassword !== $confirmPassword) {
            $this->flash('error', 'La confirmation du mot de passe ne correspond pas.');
            $this->redirect('/reset-password?token=' . urlencode($token));
            return;
        }

        User::updatePassword((int) $record['user_id'], $newPassword);
        PasswordReset::markUsed((int) $record['id']);

        $this->flash('success', 'Mot de passe réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
        $this->redirect('/login');
    }
}
