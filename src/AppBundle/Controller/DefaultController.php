<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        $response = $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
        ));

        $cookie = new \Symfony\Component\HttpFoundation\Cookie("name", "ali", time() + 3600, "/");

        $response->headers->setCookie($cookie);

        return $response;
    }

//
//
//    /**
//     * @Route("/", name="homepage")
//     */
//    public function indexAction(Request $request) {
//        $response = new \Symfony\Component\HttpFoundation\Response("Hello");
//
//        $cookie = new \Symfony\Component\HttpFoundation\Cookie("test", 10, time() + 3600, "/");
//
//        $response->headers->setCookie($cookie);
//
//        return $response;
//    }
//    
    /**
     * @Route("/get")
     */
    public function getAction(Request $request) {
        $response = new \Symfony\Component\HttpFoundation\Response("Hello");

        $c = $request->cookies->get("test");

        return $response;
    }

//
//    /**
//     * @Route("/upload")
//     * @Template
//     */
//    public function uploadAction(Request $request) {
//
//        $form = $this->createFormBuilder()
//                ->add("myfile", "file")
//                ->getForm()
//        ;
//
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $file = $form['myfile']->getData();
//            $ext = $file->guessExtension();
//            if (!$ext) {
//                $ext = "bin";
//            }
//            $file->move("./files", rand(1111, 9999) . "." . $ext);
//        }
//
//        return array("form" => $form->createView());
//    }

    /**
     * @Route("/upload")
     * @Template
     */
    public function uploadAction(Request $request) {

        $form = $this->createForm(new \AppBundle\Form\MyFormType());


        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $file = $data->getFile();

            $filename = rand(1111, 9999) . ".jpg";

            $file->move("./files", $filename);
            $data->setFile($filename);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
        }

        return array("form" => $form->createView());
    }

    /**
     * @Route("/ad/{id}")
     * @Template
     * @ParamConverter("category", class="AppBundle\Entity\Category")
     */
    public function AdAction(Request $request, $category) {

        $types = $this->getDoctrine()->getRepository("AppBundle:Type")->findBy(['category' => $category]);
        $formBuilder = $this->createFormBuilder();
    
        foreach ($types as $type) {
            switch ($type->getType()) {
                case "integer":
                    $fieldType = "text";
                    break;
                case "string":
                    $fieldType = "textarea";
                    break;
                case "enum":
                    $fieldType = "choise";
                    break;
            }
            $formBuilder->add("prop_" . $type->getId(), $fieldType, ['label' => $type->getName()]);
        }
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            
            var_dump($data);
        }
        return array("form" => $form->createView());
    }

}
