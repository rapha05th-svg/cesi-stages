<?php

final class PilotController extends Controller
{
    public function applications(): void
    {
        $this->requireRole(['PILOT']);

        $pilotId = Pilot::idByUserId((int) Auth::id());
        if (!$pilotId) {
            http_response_code(403);
            echo 'Aucun pilote lié à cet utilisateur.';
            return;
        }

        $apps = Application::byPilot($pilotId);

        $this->view('pilot/applications', [
            'pageTitle'       => 'Candidatures de mes étudiants | CESI Stages',
            'pageDescription' => 'Suivez les candidatures de vos étudiants sur la plateforme CESI Stages.',
            'pageKeywords'    => 'candidatures, étudiants, pilote, CESI Stages, suivi',
            'apps' => $apps,
        ]);
    }
}