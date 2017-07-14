<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class CustomerController extends FOSRestController
{
    /**
     * @Rest\Get("/GET/customer/{id}", defaults={"_format"="json"})
     *
     * Creates a new customer registration in the database
     * 
     * @param type $id
     * @return View
     */
    public function getAction($id)
    {
        # Search for the customer in the DB.
        $customerResult = $this
                          ->getDoctrine()
                          ->getRepository('AppBundle:Customer')
                          ->find($id);
        
        # If the customer was not found, return code 404
        if ($customerResult === null) {
            return new View("Customer with ID '$id' does not exist", Response::HTTP_NOT_FOUND);   
        }
        
        # If the customer was found, return it
        return  $customerResult;
    }
    
   
    /**
     * @Rest\Post("/POST/customer", defaults={"_format"="json"})
     *
     * Creates a new customer registration in the database 
     * 
     * @param Request $request
     * @return View
     */
     public function postAction(Request $request)
    {
        $data = new Customer;
        $id         = $request->get('id');
        $firstName  = $request->get('firstName');
        $lastName   = $request->get('lastName');
        $email      = $request->get('email');
        
        # Search if the same customer ID existis in the DB
        $customerResult = $this
                          ->getDoctrine()
                          ->getRepository('AppBundle:Customer')
                          ->find($id);
        
        # If the customer exists, return code 409
        if ($customerResult !== null) {
            return new View("Customer with ID: '$id' already exists.", Response::HTTP_CONFLICT);
        }
        
        # Check if there are any blank fields
        if(empty($id) || empty($firstName) || empty($lastName) || empty($email)) {
            return new View("Empty fields were provided. "
                           . "Please fill in all required fields", Response::HTTP_NOT_ACCEPTABLE);
        } 
        
        # Compose the customer object before writing it to the database
        $data->setId($id);
        $data->setFirstName($firstName);
        $data->setLastName($lastName);
        $data->setEmail($email);
        
        # Send the information to the database
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Customer with ID '$id' was created", Response::HTTP_CREATED);
}
    
    
    /**
     * @Rest\Put("/PUT/customer/{id}", defaults={"_format"="json"})
     *
     * Updates a field of a customer record in the database
     *  
     * @param type $id
     * @param Request $request
     * @return View
     */
    public function putAction($id, Request $request)
    { 
        # Read information from the request
        $customer   = new Customer;
        $firstName  = $request->get('firstName');
        $lastName   = $request->get('lastName');
        $email      = $request->get('email');
        
        $em         = $this->getDoctrine()->getManager();
        
        # Search if the customer existis in the DB
        $customer = $this
                ->getDoctrine()
                ->getRepository('AppBundle:Customer')
                ->find($id);
        
        # If the customer exists, find which field needs to be updated, and modify it:
        if (empty($customer)) {
            return new View("The customer with ID: '$id' was not found", Response::HTTP_NOT_FOUND);
        } 
        elseif(!empty($firstName)){
            $customer->setId($id);
            $customer->setFirstName($firstName);
            $em->flush();
            return new View("Customer ID: '$id' - First Name updated successfully to $firstName", Response::HTTP_OK);
        }
        elseif(!empty($lastName)){
            $customer->setId($id);
            $customer->setLastName($lastName);
            $em->flush();
            return new View("Customer ID: '$id' - Last Name updated successfully to $lastName", Response::HTTP_OK);
        }    
        elseif(!empty($email)){
            $customer->setId($id);
            $customer->setEmail($email);
            $em->flush();
            return new View("Customer ID: '$id' - email updated successfully", Response::HTTP_OK);
        }   
        else 
            return new View("Customer ID cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
    }
    
    /**
     * @Rest\DELETE("DELETE/customer/{id}", defaults={"_format"="json"})
     *
     * Deletes a customer from the database
     * 
     * @param type $id
     * @return View
     */
    public function deleteAction($id)
    {
        $customer   = new Customer;
        $em         = $this->getDoctrine()->getManager();
        # Search if the customer existis in the DB
        $user       = $this
                      ->getDoctrine()
                      ->getRepository('AppBundle:Customer')
                      ->find($id);
        if (empty($user)) {
            return new View("The customer with ID: '$id' was not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $em->remove($user);
            $em->flush();
        }
        return new View("The customer with ID: '$id' was deleted successfully", Response::HTTP_OK);
    }
} 
    
    