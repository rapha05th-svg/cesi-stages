<?php

final class Mailer
{
    public static function sendPasswordReset(
        string $toEmail,
        string $toName,
        string $resetUrl
    ): bool {
        $config    = App::config()['mail'] ?? [];
        $fromEmail = $config['from_email'] ?? 'noreply@localhost';
        $fromName  = $config['from_name'] ?? 'CESI Stages';
        $expiryMin = App::config()['token']['expiry_minutes'] ?? 60;

        $subject  = 'Réinitialisation de votre mot de passe — CESI Stages';
        $bodyHtml = self::buildHtml($toName, $resetUrl, $expiryMin);
        $bodyText = self::buildText($toName, $resetUrl, $expiryMin);
        $boundary = md5(uniqid('', true));

        $headers  = "From: {$fromName} <{$fromEmail}>\r\n";
        $headers .= "Reply-To: {$fromEmail}\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
        $headers .= "X-Mailer: CESI-Stages\r\n";

        $body  = "--{$boundary}\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $body .= $bodyText . "\r\n\r\n";
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n\r\n";
        $body .= $bodyHtml . "\r\n\r\n";
        $body .= "--{$boundary}--";

        return mail($toEmail, $subject, $body, $headers);
    }

    private static function buildHtml(string $name, string $url, int $expiryMin): string
    {
        $safeUrl    = htmlspecialchars($url);
        $safeName   = htmlspecialchars($name);
        $expiryText = $expiryMin >= 60
            ? ($expiryMin / 60) . ' heure' . ($expiryMin / 60 > 1 ? 's' : '')
            : $expiryMin . ' minute' . ($expiryMin > 1 ? 's' : '');

        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<body style="font-family:Arial,sans-serif;background:#f9fafb;margin:0;padding:24px;">
  <div style="max-width:480px;margin:0 auto;background:#fff;border-radius:12px;
              padding:32px;border:1px solid #e5e7eb;box-shadow:0 4px 16px rgba(0,0,0,.06);">
    <div style="text-align:center;margin-bottom:24px;">
      <div style="display:inline-block;background:#fff;border:1px solid rgba(215,25,32,.14);
                  border-radius:12px;padding:10px 16px;">
        <strong style="color:#d71920;font-size:1.1rem;">CESI Stages</strong>
      </div>
    </div>
    <h2 style="color:#161b26;margin:0 0 12px;">Réinitialisation de mot de passe</h2>
    <p style="color:#374151;">Bonjour <strong>{$safeName}</strong>,</p>
    <p style="color:#374151;">
      Vous avez demandé la réinitialisation de votre mot de passe sur la plateforme
      <strong>CESI Stages</strong>.
    </p>
    <p style="color:#374151;">
      Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe.
      Ce lien est valable <strong>{$expiryText}</strong>.
    </p>
    <p style="text-align:center;margin:28px 0;">
      <a href="{$safeUrl}"
         style="background:#d71920;color:#fff;padding:14px 28px;border-radius:10px;
                text-decoration:none;font-weight:700;display:inline-block;">
        Réinitialiser mon mot de passe
      </a>
    </p>
    <p style="color:#667085;font-size:0.85rem;">
      Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet e-mail.
      Votre mot de passe ne sera pas modifié.
    </p>
    <hr style="border:none;border-top:1px solid #e5e7eb;margin:24px 0;">
    <p style="color:#9ca3af;font-size:0.78rem;word-break:break-all;">
      Lien direct : <a href="{$safeUrl}" style="color:#9ca3af;">{$safeUrl}</a>
    </p>
  </div>
</body>
</html>
HTML;
    }

    private static function buildText(string $name, string $url, int $expiryMin): string
    {
        $expiryText = $expiryMin >= 60
            ? ($expiryMin / 60) . ' heure' . ($expiryMin / 60 > 1 ? 's' : '')
            : $expiryMin . ' minute' . ($expiryMin > 1 ? 's' : '');

        return "Bonjour {$name},\n\n"
            . "Vous avez demandé la réinitialisation de votre mot de passe sur CESI Stages.\n\n"
            . "Cliquez sur ce lien pour réinitialiser votre mot de passe (valable {$expiryText}) :\n"
            . "{$url}\n\n"
            . "Si vous n'êtes pas à l'origine de cette demande, ignorez cet e-mail.\n\n"
            . "— CESI Stages";
    }
}
