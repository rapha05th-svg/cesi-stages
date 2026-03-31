<?php

class Offer
{
    public static function paginate(int $limit, int $offset): array
    {
        $pdo = DB::pdo();
        $sql = "
            SELECT o.id, o.title, o.description, o.company_id, c.name AS company_name
            FROM offers o
            LEFT JOIN companies c ON c.id = o.company_id
            ORDER BY o.id DESC
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function search(string $q, int $companyId, string $sort, int $limit, int $offset, int $salaryMin = 0): array
    {
        $pdo = DB::pdo();
        $where = ['o.is_active = 1'];
        $params = [];

        if ($q !== '') {
            $where[] = '(o.title LIKE :q OR o.description LIKE :q)';
            $params[':q'] = '%' . $q . '%';
        }
        if ($companyId > 0) {
            $where[] = 'o.company_id = :cid';
            $params[':cid'] = $companyId;
        }
        if ($salaryMin > 0) {
            $where[] = 'o.salary >= :smin';
            $params[':smin'] = $salaryMin;
        }

        $whereStr = implode(' AND ', $where);

        $orderBy = match($sort) {
            'popular' => 'apps_count DESC',
            'oldest'  => 'o.created_at ASC',
            default   => 'o.created_at DESC',
        };

        $sql = "
            SELECT o.id, o.title, o.description, o.salary, o.start_date, o.end_date, o.company_id, o.created_at,
                   c.name AS company_name,
                   COUNT(a.id) AS apps_count
            FROM offers o
            LEFT JOIN companies c ON c.id = o.company_id
            LEFT JOIN applications a ON a.offer_id = o.id
            WHERE $whereStr
            GROUP BY o.id, o.title, o.description, o.salary, o.start_date, o.end_date, o.company_id, o.created_at, c.name
            ORDER BY $orderBy
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function countSearch(string $q, int $companyId): int
    {
        $pdo = DB::pdo();
        $where = ['o.is_active = 1'];
        $params = [];

        if ($q !== '') {
            $where[] = '(o.title LIKE :q OR o.description LIKE :q)';
            $params[':q'] = '%' . $q . '%';
        }
        if ($companyId > 0) {
            $where[] = 'o.company_id = :cid';
            $params[':cid'] = $companyId;
        }

        $whereStr = implode(' AND ', $where);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM offers o WHERE $whereStr");
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public static function countAll(): int
    {
        $stmt = DB::pdo()->query("SELECT COUNT(*) FROM offers");
        return (int) $stmt->fetchColumn();
    }

    public static function find(int $id): ?array
    {
        $sql = "
            SELECT o.id, o.title, o.description, o.salary, o.start_date, o.end_date, o.company_id, c.name AS company_name,
                   o.is_active, o.created_at,
                   (SELECT COUNT(*) FROM applications a WHERE a.offer_id = o.id) AS applications_count
            FROM offers o
            LEFT JOIN companies c ON c.id = o.company_id
            WHERE o.id = :id
            LIMIT 1
        ";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        $offer = $stmt->fetch(PDO::FETCH_ASSOC);
        return $offer ?: null;
    }

    public static function searchAdmin(string $q = ''): array
    {
        $sql = "
            SELECT o.id, o.title, o.description, o.salary, o.start_date, o.end_date, o.company_id, o.is_active,
                   c.name AS company_name
            FROM offers o
            LEFT JOIN companies c ON c.id = o.company_id
        ";
        $params = [];
        if ($q !== '') {
            $sql .= " WHERE o.title LIKE :q OR o.description LIKE :q";
            $params[':q'] = '%' . $q . '%';
        }
        $sql .= " ORDER BY o.id DESC";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAdmin(int $id): array|false
    {
        $stmt = DB::pdo()->prepare("
            SELECT o.*, c.name AS company_name
            FROM offers o
            LEFT JOIN companies c ON c.id = o.company_id
            WHERE o.id = :id LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createAdmin(string $title, string $description, int $companyId, ?float $salary = null, ?string $startDate = null, ?string $endDate = null): void
    {
        DB::pdo()->prepare("
            INSERT INTO offers (title, description, company_id, salary, start_date, end_date, is_active)
            VALUES (:title, :description, :company_id, :salary, :start_date, :end_date, 1)
        ")->execute([
            'title'       => $title,
            'description' => $description,
            'company_id'  => $companyId,
            'salary'      => $salary,
            'start_date'  => $startDate,
            'end_date'    => $endDate,
        ]);
    }

    public static function updateAdmin(int $id, string $title, string $description, int $companyId, ?float $salary = null, ?string $startDate = null, ?string $endDate = null): void
    {
        DB::pdo()->prepare("
            UPDATE offers SET title=:title, description=:description, company_id=:company_id, salary=:salary, start_date=:start_date, end_date=:end_date WHERE id=:id
        ")->execute([
            'title'       => $title,
            'description' => $description,
            'company_id'  => $companyId,
            'salary'      => $salary,
            'start_date'  => $startDate,
            'end_date'    => $endDate,
            'id'          => $id,
        ]);
    }

    public static function deleteAdmin(int $id): void
    {
        DB::pdo()->prepare("UPDATE offers SET is_active=0 WHERE id=:id")->execute(['id' => $id]);
    }
}