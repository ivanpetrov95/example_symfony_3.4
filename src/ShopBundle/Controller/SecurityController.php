<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_path")
     */
    public function loginAction()
    {
        return $this->render('@Shop/SecurityController/login.html.twig');
    }

    /**
     * @Route ("/logout", name="logout_path")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/reset", name="reset_password")
     */
    public function resetPasswordAction(Request $request)
    {
        $defaultData = ["message" => "There is no data."];
        $form = $this->createFormBuilder($defaultData)
            ->add("email", EmailType::class)
            ->add("submit", SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            print($form->getData()["email"]);
        }
        return $this->render("@Shop/SecurityController/reset.html.twig", ["form" => $form->createView(),]);
    }
}
