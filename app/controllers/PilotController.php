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

    public function showRequests(): void
    {
        $this->requireRole(['PILOT']);

        $pilotId = Pilot::idByUserId((int) Auth::id());
        if (!$pilotId) {
            http_response_code(403);
            echo 'Aucun pilote lié à cet utilisateur.';
            return;
        }

        $requests = PilotRequest::byPilotId($pilotId);

        $this->view('pilot/requests', [
            'pageTitle' => 'Mes demandes | CESI Stages',
            'requests'  => $requests,
        ]);
    }

    public function storeRequest(): void
    {
        $this->requireRole(['PILOT']);
        Csrf::check();

        $pilotId = Pilot::idByUserId((int) Auth::id());
        if (!$pilotId) {
            http_response_code(403);
            return;
        }

        $type    = $_POST['type']    ?? '';
        $action  = $_POST['action']  ?? '';
        $message = trim($_POST['message'] ?? '');

        $validTypes   = ['company', 'student', 'offer'];
        $validActions = ['create', 'edit'];

        if (!in_array($type, $validTypes, true) || !in_array($action, $validActions, true)) {
            $this->flash('error', 'Type ou action invalide.');
            $this->redirect('/pilot/requests');
            return;
        }

        PilotRequest::create($pilotId, $type, $action, $message);

        $this->flash('success', 'Demande envoyée à l\'administrateur.');
        $this->redirect('/pilot/requests');
    }
}