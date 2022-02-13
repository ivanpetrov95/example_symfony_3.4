<?php

namespace ShopBundle\Controller;

use ShopBundle\Entity\Role;
use ShopBundle\Entity\User;
use ShopBundle\Form\UpdateUserType;
use ShopBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     */
    public function registerAction(Request $request, \Swift_Mailer $swiftMailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $encodedPassword = $this->get("security.password_encoder")->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository(Role::class)->findOneBy(["name" => "ROLE_USER"]);
            $user->addRole($role);
            $em->persist($user);
            $em->flush();
            $this->sendMail($user->getUsername(), $swiftMailer);
            return $this->redirectToRoute("login_path");
        }
        return $this->render("@Shop/UserController/register.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/user/{id}", name="user_profile", requirements={"id"="\d+"})
     * @param Request $request
     */
    public function specificUserAction(Request $request, int $id)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $specificUser = $userRepo->find($id);
        return $this->render("@Shop/UserController/user.html.twig", ["specificUser" => $specificUser]);
    }

    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function profileAction(Request $request)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser());
        return $this->render("@Shop/UserController/profile.html.twig", ["user" => $user]);
    }

    /**
     * @Route("/users/all", name="users")
     */
    public function allUsersAction()
    {
        $userRepo = $this->getDoctrine()
            ->getRepository(User::class);
        $allUsers = $userRepo->findAll();
        return $this->render("@Shop/UserController/users.html.twig",
            ["allUsers" => $allUsers]);
    }

    /**
     * @Route("profile/edit", name="edit_profile")
     */
    public function profileEditAction(Request $request, UserInterface $user)
    {
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $pictureURI = $form->get("pictureURI")->getData();
            if ($pictureURI)
            {
                $originalPictureName = pathinfo($pictureURI->getClientOriginalName(), PATHINFO_FILENAME);
                $safePictureURI = transliterator_transliterate("Any-Latin;Latin-ASCII; [^A-Za-z0-9_] remove; Lower()", $originalPictureName);
                $newPictureURI = $safePictureURI."-".uniqid().".".$pictureURI->guessExtension();
                $tmpName = $pictureURI->getPathName();
                list($imgWidth, $imgHeight) = getimagesize($tmpName);
                if($imgWidth >= 200 && $imgHeight >= 200)
                {
                    $image = new \Imagick($tmpName);
                    $image->resizeImage(200, 200, \Imagick::FILTER_LANCZOS, 1);
                    $image->writeImage($newPictureURI);
                }
                try
                {
                    $pictureURI->move(
                        $this->getParameter("pictures_directory"),
                        $newPictureURI
                    );
                }
                catch (FileException $exc){

                }
                $user->setPictureURI($newPictureURI);
            }
            $em = $this->getDoctrine()->getManager();
            $em->merge($user);
            $em->flush();
            return $this->redirectToRoute("profile");
        }
        return $this->render("@Shop/UserController/edit_profile.html.twig", ["form" => $form->createView(), "username" => $user->getUsername(), "picture" => $user->getPictureURI()]);
    }

    private function sendMail($name, \Swift_Mailer $swiftMailer)
    {
        $message = (new \Swift_Message("Successfull registration"))
            ->setFrom("ivan959095@gmail.com")
            ->setTo("thekiller9590@gmail.com")
            ->setBody(
                $this->renderView("@Shop/Emails/registration.html.twig",
                    ["name" => $name]), "text/html"
            );
        $swiftMailer->send($message);
        return $this->redirectToRoute("login_path");
    }

    private function randomizeNameOfPicture($pictureName)
    {

    }
}


