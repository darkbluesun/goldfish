<?php

namespace Darkbluesun\GoldfishBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkbluesun\GoldfishBundle\Entity\Workspace;
use Darkbluesun\GoldfishBundle\Entity\Client;
use Darkbluesun\GoldfishBundle\Entity\ClientComment;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Client controller.
 *
 * @Route("/api/clients")
 */
class ClientController extends Controller
{
    /**
     * Lists all Client entities.
     *
     * @Route("/", name="clients")
     * @Method("GET")
     */
    public function getcAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $workspace = $user->getWorkspace();

        if (!$workspace) {
            $em = $this->getDoctrine()->getManager();
            $workspace = new Workspace();
            $workspace->addUser($user);
            $workspace->setPrivate(true);
            $workspace->setName($user->getEmail()."'s workspace");
            $em->persist($workspace);
            $em->flush();
        }

        return new Response(
            $this->get('serializer')->serialize(
                    $workspace->getClients(), 'json',
                    SerializationContext::create()->setGroups(['client_list'])
            ));
    }

    /**
     * Gets an existing Client entity.
     * @Security("is_granted('VIEW', client)")
     * @Route("/{id}", name="clients_get")
     * @Method("GET")
     */
    public function getAction(Client $client)
    {
        return new Response($this->get('serializer')->serialize($client,'json',SerializationContext::create()->setGroups(['client_details'])));
    }
    /**
     * Creates a new Client entity.
     *
     * @Route("", name="clients_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $serializer = $this->get('serializer');
        $em = $this->getDoctrine()->getManager();
        $client = $serializer->deserialize($request->getContent(), Client::class, 'json');
        $client->setWorkspace($this->getUser()->getWorkspace());
        $client->setCreatedAt(new \DateTime())->setUpdatedAt(new \DateTime());
        $em->persist($client);
        $em->flush();

        $aclProvider = $this->get('security.acl.provider');
        $acl = $aclProvider->createAcl(ObjectIdentity::fromDomainObject($client));
        $acl->insertObjectAce(UserSecurityIdentity::fromAccount($this->getUser()), MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);

        return $this->getAction($client);
    }

    /**
     * Updates an existing Client entity.
     * @Security("is_granted('EDIT', client)")
     * @Route("/{id}", name="clients_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, Client $client)
    {
        $em = $this->getDoctrine()->getManager();
        $created = $client->getCreatedAt();
        $client = $serializer->deserialize($request->getContent(), Client::class, 'json');
        $client->setCreatedAt($created)->setUpdatedAt(new \DateTime());
        $em->merge($client);
        $em->flush();
        return $this->getAction($client);
    }

    /**
     * Adds a comment to a client
     *
     * @Route("/{id}/comment", name="clients_comment")
     * @Method("POST")
     */
    public function commentAction(Request $request, Client $client) {
        $comment = new ClientComment;
        $em = $this->getDoctrine()->getManager();

        $comment->setClient($client);
        $comment->setContent($request->request->get('content'));
        $em->persist($comment);
        $em->flush();

        return new Response($this->get('serializer')->serialize($client,'json',SerializationContext::create()->setGroups(['client_details'])));
    }


    /**
     * Deletes a Client entity.
     * @Security("is_granted('DELETE', client)")
     * @Route("/{id}", name="clients_delete")
     * @Method("DELETE")
     */
    public function destroyAction(Request $request, Client $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        return new Response(null, Response::HTTP_OK);
    }

}
