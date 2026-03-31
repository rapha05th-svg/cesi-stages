<?php

final class AdminController extends Controller
{
    public function dashboard(): void
    {
        $this->requireRole(['ADMIN']);

        $this->view('admin/dashboard', [
            'companiesCount'    => AdminStats::totalCompanies(),
            'offersCount'       => AdminStats::totalOffers(),
            'studentsCount'     => AdminStats::totalStudents(),
            'pilotsCount'       => AdminStats::totalPilots(),
            'applicationsCount' => AdminStats::totalApplications(),
            'topCompanies'      => AdminStats::topCompaniesByApplications(),
            'avgSalary'         => AdminStats::avgSalary(),
            'wishlistsCount'    => AdminStats::totalWishlists(),
            'recentApps'        => AdminStats::recentApplications(),
        ]);
    }

    public function companies(): void
    {
        $this->requireRole(['ADMIN']);

        $q = trim($_GET['q'] ?? '');
        $companies = Company::searchAdmin($q);

        $this->view('admin/companies/index', [
            'companies' => $companies,
            'q' => $q,
        ]);
    }

    public function createCompany(): void
    {
        $this->requireRole(['ADMIN']);
        $this->view('admin/companies/create');
    }

    public function storeCompany(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($name === '') {
            $this->flash('error', 'Le nom de l’entreprise est obligatoire.');
            $this->redirect('/admin/companies/create');
            return;
        }

        Company::createAdmin($name, $description, $email, $phone);

        $this->flash('success', 'Entreprise créée avec succès.');
        $this->redirect('/admin/companies');
    }

    public function editCompany(): void
    {
        $this->requireRole(['ADMIN']);

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo 'Bad request';
            return;
        }

        $company = Company::findAdmin($id);
        if (!$company) {
            http_response_code(404);
            echo 'Entreprise introuvable';
            return;
        }

        $this->view('admin/companies/edit', [
            'company' => $company,
        ]);
    }

    public function updateCompany(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if ($id <= 0 || $name === '') {
            $this->flash('error', 'Données invalides.');
            $this->redirect('/admin/companies');
            return;
        }

        Company::updateAdmin($id, $name, $description, $email, $phone);

        $this->flash('success', 'Entreprise modifiée avec succès.');
        $this->redirect('/admin/companies');
    }

    public function deleteCompany(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/admin/companies');
            return;
        }

        Company::deleteAdmin($id);

        $this->flash('success', 'Entreprise désactivée avec succès.');
        $this->redirect('/admin/companies');
    }

    public function offers(): void
    {
        $this->requireRole(['ADMIN']);

        $q = trim($_GET['q'] ?? '');
        $offers = Offer::searchAdmin($q);

        $this->view('admin/offers/index', [
            'offers' => $offers,
            'q' => $q,
        ]);
    }

    public function createOffer(): void
    {
        $this->requireRole(['ADMIN']);

        $companies = Company::searchAdmin('');
        $this->view('admin/offers/create', [
            'companies' => $companies,
        ]);
    }

    public function storeOffer(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $companyId = (int) ($_POST['company_id'] ?? 0);

        if ($title === '' || $companyId <= 0) {
            $this->flash('error', 'Titre et entreprise obligatoires.');
            $this->redirect('/admin/offers/create');
            return;
        }

        Offer::createAdmin($title, $description, $companyId);

        $this->flash('success', 'Offre créée avec succès.');
        $this->redirect('/admin/offers');
    }

    public function editOffer(): void
    {
        $this->requireRole(['ADMIN']);

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo 'Bad request';
            return;
        }

        $offer = Offer::findAdmin($id);
        if (!$offer) {
            http_response_code(404);
            echo 'Offre introuvable';
            return;
        }

        $companies = Company::searchAdmin('');

        $this->view('admin/offers/edit', [
            'offer' => $offer,
            'companies' => $companies,
        ]);
    }

    public function updateOffer(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id          = (int) ($_POST['id'] ?? 0);
        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $companyId   = (int) ($_POST['company_id'] ?? 0);
        $salaryRaw   = trim($_POST['salary'] ?? '');
        $salary      = $salaryRaw !== '' ? (float) $salaryRaw : null;
        $startDate   = trim($_POST['start_date'] ?? '') !== '' ? trim($_POST['start_date']) : null;
        $endDate     = trim($_POST['end_date'] ?? '') !== '' ? trim($_POST['end_date']) : null;

        if ($id <= 0 || $title === '' || $companyId <= 0) {
            $this->flash('error', 'Données invalides.');
            $this->redirect('/admin/offers');
            return;
        }

        Offer::updateAdmin($id, $title, $description, $companyId, $salary, $startDate, $endDate);

        $this->flash('success', 'Offre modifiée avec succès.');
        $this->redirect('/admin/offers');
    }

    public function deleteOffer(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/admin/offers');
            return;
        }

        Offer::deleteAdmin($id);

        $this->flash('success', 'Offre désactivée avec succès.');
        $this->redirect('/admin/offers');
    }

    public function students(): void
    {
        $this->requireRole(['ADMIN']);

        $q = trim($_GET['q'] ?? '');
        $students = Student::allAdmin($q);

        $this->view('admin/students/index', [
            'students' => $students,
            'q' => $q,
        ]);
    }

    public function createStudent(): void
    {
        $this->requireRole(['ADMIN']);

        $pilots = Pilot::allAdmin('');

        $this->view('admin/students/create', [
            'pilots' => $pilots,
        ]);
    }

    public function storeStudent(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pilotId = (int) ($_POST['pilot_id'] ?? 0);

        if ($firstname === '' || $lastname === '' || $email === '') {
            $this->flash('error', 'Nom, prénom et email sont obligatoires.');
            $this->redirect('/admin/students/create');
            return;
        }

        if (User::findByEmail($email)) {
            $this->flash('error', 'Cet email existe déjà.');
            $this->redirect('/admin/students/create');
            return;
        }

        $userId = User::create($email, 'cesi123', 'STUDENT');
        Student::createAdmin($userId, $firstname, $lastname, $pilotId > 0 ? $pilotId : null);

        $this->flash('success', 'Étudiant créé avec succès. Mot de passe par défaut : cesi123');
        $this->redirect('/admin/students');
    }

    public function editStudent(): void
    {
        $this->requireRole(['ADMIN']);

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo 'Bad request';
            return;
        }

        $student = Student::findAdmin($id);
        if (!$student) {
            http_response_code(404);
            echo 'Étudiant introuvable';
            return;
        }

        $pilots = Pilot::allAdmin('');

        $this->view('admin/students/edit', [
            'student' => $student,
            'pilots' => $pilots,
        ]);
    }

    public function updateStudent(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        $userId = (int) ($_POST['user_id'] ?? 0);
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pilotId = (int) ($_POST['pilot_id'] ?? 0);

        if ($id <= 0 || $userId <= 0 || $firstname === '' || $lastname === '' || $email === '') {
            $this->flash('error', 'Données invalides.');
            $this->redirect('/admin/students');
            return;
        }

        User::updateEmail($userId, $email);
        Student::updateAdmin($id, $firstname, $lastname, $pilotId > 0 ? $pilotId : null);

        $this->flash('success', 'Étudiant modifié avec succès.');
        $this->redirect('/admin/students');
    }

    public function deleteStudent(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        $userId = (int) ($_POST['user_id'] ?? 0);

        if ($id <= 0 || $userId <= 0) {
            $this->redirect('/admin/students');
            return;
        }

        Student::deleteAdmin($id);
        User::delete($userId);

        $this->flash('success', 'Étudiant supprimé avec succès.');
        $this->redirect('/admin/students');
    }

    public function pilots(): void
    {
        $this->requireRole(['ADMIN']);

        $q = trim($_GET['q'] ?? '');
        $pilots = Pilot::allAdmin($q);

        $this->view('admin/pilots/index', [
            'pilots' => $pilots,
            'q' => $q,
        ]);
    }

    public function createPilot(): void
    {
        $this->requireRole(['ADMIN']);
        $this->view('admin/pilots/create');
    }

    public function storePilot(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($firstname === '' || $lastname === '' || $email === '') {
            $this->flash('error', 'Nom, prénom et email sont obligatoires.');
            $this->redirect('/admin/pilots/create');
            return;
        }

        if (User::findByEmail($email)) {
            $this->flash('error', 'Cet email existe déjà.');
            $this->redirect('/admin/pilots/create');
            return;
        }

        $userId = User::create($email, 'cesi123', 'PILOT');
        Pilot::createAdmin($userId, $firstname, $lastname);

        $this->flash('success', 'Pilote créé avec succès. Mot de passe par défaut : cesi123');
        $this->redirect('/admin/pilots');
    }

    public function editPilot(): void
    {
        $this->requireRole(['ADMIN']);

        $id = (int) ($_GET['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo 'Bad request';
            return;
        }

        $pilot = Pilot::findAdmin($id);
        if (!$pilot) {
            http_response_code(404);
            echo 'Pilote introuvable';
            return;
        }

        $this->view('admin/pilots/edit', [
            'pilot' => $pilot,
        ]);
    }

    public function updatePilot(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        $userId = (int) ($_POST['user_id'] ?? 0);
        $firstname = trim($_POST['firstname'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($id <= 0 || $userId <= 0 || $firstname === '' || $lastname === '' || $email === '') {
            $this->flash('error', 'Données invalides.');
            $this->redirect('/admin/pilots');
            return;
        }

        User::updateEmail($userId, $email);
        Pilot::updateAdmin($id, $firstname, $lastname);

        $this->flash('success', 'Pilote modifié avec succès.');
        $this->redirect('/admin/pilots');
    }

    public function deletePilot(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $id = (int) ($_POST['id'] ?? 0);
        $userId = (int) ($_POST['user_id'] ?? 0);

        if ($id <= 0 || $userId <= 0) {
            $this->redirect('/admin/pilots');
            return;
        }

        Pilot::deleteAdmin($id);
        User::delete($userId);

        $this->flash('success', 'Pilote supprimé avec succès.');
        $this->redirect('/admin/pilots');
    }

    public function showResetUserPassword(): void
    {
        $this->requireRole(['ADMIN']);

        $userId = (int) ($_GET['user_id'] ?? 0);
        if ($userId <= 0) {
            $this->flash('error', 'Utilisateur invalide.');
            $this->redirect('/admin');
            return;
        }

        $targetUser = User::find($userId);
        if (!$targetUser) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('/admin');
            return;
        }

        if (!in_array($targetUser['role'], ['STUDENT', 'PILOT'], true)) {
            $this->flash('error', 'Seuls les étudiants et pilotes peuvent être réinitialisés ici.');
            $this->redirect('/admin');
            return;
        }

        $this->view('admin/reset-user-password', [
            'targetUser' => $targetUser,
        ]);
    }

    public function resetUserPassword(): void
    {
        Csrf::check();
        $this->requireRole(['ADMIN']);

        $userId = (int) ($_POST['user_id'] ?? 0);
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($userId <= 0) {
            $this->flash('error', 'Utilisateur invalide.');
            $this->redirect('/admin');
            return;
        }

        $targetUser = User::find($userId);
        if (!$targetUser) {
            $this->flash('error', 'Utilisateur introuvable.');
            $this->redirect('/admin');
            return;
        }

        if (!in_array($targetUser['role'], ['STUDENT', 'PILOT'], true)) {
            $this->flash('error', 'Seuls les étudiants et pilotes peuvent être réinitialisés ici.');
            $this->redirect('/admin');
            return;
        }

        if ($newPassword === '' || $confirmPassword === '') {
            $this->flash('error', 'Tous les champs sont obligatoires.');
            $this->redirect('/admin/users/reset-password?user_id=' . $userId);
            return;
        }

        if (strlen($newPassword) < 8) {
            $this->flash('error', 'Le nouveau mot de passe doit contenir au moins 8 caractères.');
            $this->redirect('/admin/users/reset-password?user_id=' . $userId);
            return;
        }

        if ($newPassword !== $confirmPassword) {
            $this->flash('error', 'La confirmation ne correspond pas.');
            $this->redirect('/admin/users/reset-password?user_id=' . $userId);
            return;
        }

        User::updatePassword($userId, $newPassword);

        $this->flash('success', 'Mot de passe réinitialisé avec succès pour ' . $targetUser['email'] . '.');

        if ($targetUser['role'] === 'STUDENT') {
            $this->redirect('/admin/students');
            return;
        }

        $this->redirect('/admin/pilots');
    }
}