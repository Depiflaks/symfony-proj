<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    private $uploaddir = __DIR__ . '/../../uploads/';

    public function __construct(private UserRepository $UserRepository)
    {
    }

    public function index(): Response 
    {
        $contents = $this->render('registration/registration.html.twig');
        return $contents;
    }

    public function saveUserToDatabase(Request $request): Response
    {
        $user = $this->createUserObj($request);
        try {
            $last = $this->UserRepository->store($user);
            if ($_FILES['avatar_icon']['name'] != '') {
                $file_name = $this->saveIconById($_FILES, $last);
                $user->setAvatarPath($file_name);
                $this->UserRepository->store($user);
            }
        } catch (\PDOException $e) {
            return new Response('Error: '. $e->getMessage());
        } catch (\ErrorException $e) {
            return new Response($e->getMessage());
        }
        return $this->redirectToRoute('show_user', ["userId" => $last], Response::HTTP_SEE_OTHER);
    }


    public function deleteUserFromDatabase(Request $request): Response
    {
        $id = (int)$request->get('user_id');
        $user = $this->UserRepository->findById($id);
        $this->deleteIcon($id);
        $this->UserRepository->delete($user);
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    public function updateUserData(Request $request): Response
    {
        $user = $this->createUserObj($request);
        $this->UserRepository->store($user);
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    public function showUser(int $userId): Response
    {   
        try {
            if ($userId === null)
            {
                throw new \InvalidArgumentException('Parameter userId is not defined');
            }
            $user = $this->UserRepository->findById($userId);
            var_dump($user);
            if (!$user) {
                throw new \InvalidArgumentException('there is no user with this ID');
            }
            $data = $this->getValuesFromObj($user);
            return $this->render('user/profile.html.twig', $data);
        } catch (\InvalidArgumentException $e) {
            return new Response($e->getMessage());
        }
    }

    public function showUsersList(): Response
    {
        $user_list = $this->UserRepository->listAll();
        $func = function(User $user): array {
            return $this->getValuesFromObj($user);
        };
        $data = array_map($func, $user_list);
        return $this->render('user/user_list.html.twig', ["user_list" => $data]);
    }

    public function saveIconById(array $userFiles, int $id): string
    {
        var_dump($userFiles);
        $file = $userFiles['avatar_icon'];
        if (!in_array($file['type'], ['image/png', 'image/jpg', 'image/gif']))
        {
            throw new \ErrorException('Error: unexpected file type');
        }
        if ($file['size'] > 1024000)
        {
            throw new \ErrorException('The file size is too large');
        }
        $file_name = "avatar" . $id . "." . explode('/', $file['type'])[1];
        $uploadfile = $this->uploaddir . $file_name;
        move_uploaded_file($file['tmp_name'], $uploadfile);
        return $file_name;
    }

    public function deleteIcon(int $id)
    {
        $user = $this->UserRepository->findById((int) $id);
        $file_name = $user->getAvatarPath();
        if ($file_name != "") {
            $uploadfile = $this->uploaddir . $file_name;
            unlink($uploadfile);
        }
    }

    private function createUserObj(Request $request): User 
    {
        return new User(
            $request->get('user_id') ? (int)$request->get('user_id') : null, 
            htmlentities($request->get('first_name')), 
            htmlentities($request->get('last_name')),    
            $request->get('middle_name') ? htmlentities($request->get('middle_name')) : null, 
            htmlentities($request->get('gender')), 
            htmlentities($request->get('birth_date')), 
            htmlentities($request->get('email')), 
            $request->get('phone') ? htmlentities($request->get('phone')) : null, 
            null);
    }

    private function getValuesFromObj(User $user): array
    {
        return [
            'user_id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'middle_name' => $user->getMiddleName(), 
            'gender' => $user->getGender(), 
            'birth_date' => $user->getBirthDate(), 
            'email' => $user->getEmail(), 
            'phone' => $user->getPhone(), 
            'avatar_path' => $user->getAvatarPath(),
        ];
    }
}