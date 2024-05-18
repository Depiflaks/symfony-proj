<?php
declare(strict_types=1);

namespace App\Model;

class UserTable
{
    private const MYSQL_DATETIME_FORMAT = 'Y-m-d';

    public function __construct(private \PDO $connection)
    {
        
    }

    public function addUser(UserInterface $user): int
    {
        $query = 'INSERT INTO `user` (`first_name`, `last_name`, `middle_name`, 
        `gender`, `birth_date`, `email`, `phone`)
        VALUES (:first_name, :last_name, :middle_name, :gender, 
        :birth_date, :email, :phone);';
        $statement = $this->connection->prepare($query);
        //var_dump($this->parseDateTime($user->getBirthDate()));
        $statement->execute([
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':middle_name' => $user->getMiddleName(), 
            ':gender' => $user->getGender(), 
            ':birth_date' => $user->getBirthDate(), 
            ':email' => $user->getEmail(), 
            ':phone' => $user->getPhone(), 
        ]);
        return (int)$this->connection->lastInsertId();
    }

    public function updateUser(UserInterface $user): int
    {
        $query = 'UPDATE `user` SET 
        first_name=:first_name, 
        last_name=:last_name, 
        middle_name=:middle_name, 
        gender=:gender, 
        birth_date=:birth_date, 
        email=:email, 
        phone=:phone 
        WHERE user_id=:user_id';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':user_id' => $user->getId(),
            ':first_name' => $user->getFirstName(),
            ':last_name' => $user->getLastName(),
            ':middle_name' => $user->getMiddleName(), 
            ':gender' => $user->getGender(), 
            ':birth_date' => $user->getBirthDate(), 
            ':email' => $user->getEmail(), 
            ':phone' => $user->getPhone(), 
        ]);
        return (int)$this->connection->lastInsertId();
    }

    public function deleteUser(int $id): void
    {
        $query = 'DELETE FROM user
        WHERE user_id=:user_id';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':user_id' => $id
        ]);
    }

    public function addAvatarPath(string $path, int $id): void
    {
        $query = 'UPDATE `user` SET avatar_path=:avatar_path
        WHERE user_id=:user_id';
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ':avatar_path' => $path,
            ':user_id' => $id,
        ]);
    }

    public function getAllUsers(): array
    {
        $query = "SELECT * FROM `user`";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $res = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC))
        {
            array_push($res, $this->createUserFromRow($row));
        }
        return $res;
    }

    public function find(int $user_id): ?UserInterface
    {
        $query = "SELECT `user_id`, `first_name`, `last_name`, `middle_name`, `gender`, `birth_date`, `email`, `phone`, `avatar_path`
          FROM `user`
          WHERE user_id = :user_id";
        $statement = $this->connection->prepare($query);
        $statement->execute([':user_id' => $user_id]);
        if ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            return $this->createUserFromRow($row);
        }
        return null;
    }

    private function createUserFromRow(array $row): UserInterface
    {
        return new User(
            $row['user_id'],
            $row['first_name'], 
            $row['last_name'],
            $row['middle_name'],
            $row['gender'],
            $row['birth_date'],
            $row['email'],
            $row['phone'],
            $row['avatar_path'],
        );
    }

    private function parseDateTime(string $value): \DateTimeImmutable
    {
        $result = \DateTimeImmutable::createFromFormat(self::MYSQL_DATETIME_FORMAT, $value);
        if (!$result)
        {
            throw new \InvalidArgumentException("Invalid datetime value '$value'");
        }
        return $result;
    }
}